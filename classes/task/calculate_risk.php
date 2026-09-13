<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_smartdashboard\task;

/**
 * Scheduled task to calculate at-risk student scores using Rule Subplugins.
 *
 * Runs daily and evaluates every enrolled student across all active courses.
 * It loops through all installed 'smartdashboardrule' subplugins.
 *
 * @package     local_smartdashboard
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class calculate_risk extends \core\task\scheduled_task {
    /**
     * Get the name of this task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_calculate_risk', 'local_smartdashboard');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;

        $now = time();

        // Get all installed rule plugins.
        $pluginmanager = \core_plugin_manager::instance();
        $ruleplugins = $pluginmanager->get_plugins_of_type('smartdashboardrule');

        $rules = [];
        $totalweight = 0.0;

        foreach ($ruleplugins as $plugin) {
            $component = $plugin->component;
            $classname = '\\' . $component . '\rule';

            if (class_exists($classname)) {
                $ruleinstance = new $classname();
                $weight = $ruleinstance->get_weight();

                $rules[] = [
                    'component' => $component,
                    'instance' => $ruleinstance,
                    'weight' => $weight,
                ];

                // Only add to total weight if it's not a hard trigger.
                if (!$ruleinstance->is_hard_trigger()) {
                    $totalweight += $weight;
                }
            }
        }

        // Get all visible courses with students enrolled.
        $courses = $DB->get_records('course', ['visible' => 1], '', 'id');
        unset($courses[1]); // Remove site course.

        $processedcount = 0;
        $highriskcount = 0;

        foreach ($courses as $course) {
            $context = \context_course::instance($course->id, IGNORE_MISSING);
            if (!$context) {
                continue;
            }

            // Get all students enrolled in this course (users with 'mod/assign:submit' capability).
            $students = get_enrolled_users($context, 'mod/assign:submit', 0, 'u.id', null, 0, 0, true);
            if (empty($students)) {
                continue;
            }

            // Issue 9: Fix N+1 queries - Bulk fetch previous risk levels for all enrolled students in this course.
            $studentids = array_keys($students);

            // Do not reuse named parameters in Moodle SQL to avoid parameter count mismatch errors.
            [$uinsql1, $uinparams1] = $DB->get_in_or_equal($studentids, SQL_PARAMS_NAMED, 'u1_');
            [$uinsql2, $uinparams2] = $DB->get_in_or_equal($studentids, SQL_PARAMS_NAMED, 'u2_');

            $params = array_merge($uinparams1, $uinparams2);
            $params['courseid1'] = $course->id;
            $params['courseid2'] = $course->id;

            // Get the latest risk record for each student in this course using a subquery for max timecreated.
            $sql = "SELECT r.userid, r.risklevel
                      FROM {local_smartdashboard_risk} r
                      JOIN (
                          SELECT userid, MAX(timecreated) AS maxtime
                            FROM {local_smartdashboard_risk}
                           WHERE courseid = :courseid1 AND userid $uinsql1
                           GROUP BY userid
                      ) latest ON r.userid = latest.userid AND r.timecreated = latest.maxtime
                     WHERE r.courseid = :courseid2 AND r.userid $uinsql2";

            $previousrisksrecords = $DB->get_records_sql($sql, $params);
            $previousrisks = [];
            foreach ($previousrisksrecords as $rec) {
                $previousrisks[$rec->userid] = $rec->risklevel;
            }

            foreach ($students as $student) {
                $finalscore = 0.0;
                $ishardtriggered = false;
                $subscores = []; // Keep track for the DB record if needed (legacy columns).

                foreach ($rules as $rule) {
                    $instance = $rule['instance'];
                    $weight = $rule['weight'];
                    $component = $rule['component'];

                    try {
                        $result = $instance->evaluate($student->id, $course->id, $context, $now);

                        if ($instance->is_hard_trigger()) {
                            if ($result === true) {
                                $ishardtriggered = true;
                                break; // Instant High Risk, stop evaluating other rules!
                            }
                        } else {
                            // It's a weighted rule (result is 0-100)
                            if ($totalweight > 0 && $weight > 0) {
                                // Normalized weight proportion
                                $proportion = $weight / $totalweight;
                                $finalscore += ($result * $proportion);
                            }

                            // Map to legacy columns so we don't break the DB schema right now.
                            // In a future upgrade we should change the DB to use a JSON rules_data column.
                            if ($component === 'smartdashboardrule_loginrecency') {
                                $subscores['login'] = $result;
                            }
                            if ($component === 'smartdashboardrule_coursecompletion') {
                                $subscores['completion'] = $result;
                            }
                            if ($component === 'smartdashboardrule_grades') {
                                $subscores['grade'] = $result;
                            }
                            if ($component === 'smartdashboardrule_overdue') {
                                $subscores['overdue'] = $result;
                            }
                            if ($component === 'smartdashboardrule_adaptiveplan') {
                                $subscores['adaptiveplan'] = $result;
                            }
                        }
                    } catch (\Exception $e) {
                        mtrace("Error evaluating rule {$component} for user {$student->id}: " . $e->getMessage());
                    }
                }

                if ($ishardtriggered) {
                    $finalscore = 100.0;
                }

                // Clamp to 0-100.
                $finalscore = max(0, min(100, $finalscore));

                // Classify risk level.
                if ($finalscore >= 60) {
                    $risklevel = 'high';
                } else if ($finalscore >= 30) {
                    $risklevel = 'medium';
                } else {
                    $risklevel = 'low';
                }

                // Check previous risk level to detect transitions.
                // We use the pre-fetched map to avoid N+1 queries.
                $previouslevel = null;
                if (isset($previousrisks[$student->id])) {
                    $previouslevel = $previousrisks[$student->id];
                }

                // Insert new snapshot.
                $record = new \stdClass();
                $record->userid = $student->id;
                $record->courseid = $course->id;
                $record->riskscore = round($finalscore, 2);
                $record->risklevel = $risklevel;
                $record->score_login = isset($subscores['login']) ? round($subscores['login'], 2) : null;
                $record->score_completion = isset($subscores['completion']) ? round($subscores['completion'], 2) : null;
                $record->score_grade = isset($subscores['grade']) ? round($subscores['grade'], 2) : null;
                $record->score_overdue = isset($subscores['overdue']) ? round($subscores['overdue'], 2) : null;
                $record->score_adaptiveplan = isset($subscores['adaptiveplan']) ? round($subscores['adaptiveplan'], 2) : null;
                $record->timecreated = $now;

                $DB->insert_record('local_smartdashboard_risk', $record);
                $processedcount++;

                // Send notification if student transitioned to high risk.
                if ($risklevel === 'high' && $previouslevel !== 'high') {
                    $this->notify_teachers($student->id, $course->id, $finalscore);
                    $highriskcount++;
                }
            }
        }

        // Clean up old snapshots (keep last 90 days).
        $cutoff = $now - (90 * DAYSECS);
        $DB->delete_records_select('local_smartdashboard_risk', 'timecreated < :cutoff', ['cutoff' => $cutoff]);

        // Clean up snapshots for users deleted from Moodle.
        $DB->delete_records_select('local_smartdashboard_risk', 'userid IN (SELECT id FROM {user} WHERE deleted = 1)', []);

        mtrace("Risk calculation complete: {$processedcount} students processed, {$highriskcount} new high-risk alerts sent using the Subplugin Engine.");
    }

    /**
     * Notify the teachers of a course that a student has become high-risk.
     *
     * @param int $studentid
     * @param int $courseid
     * @param float $riskscore
     */
    private function notify_teachers($studentid, $courseid, $riskscore) {
        global $DB;

        $student = $DB->get_record('user', ['id' => $studentid]);
        $course = $DB->get_record('course', ['id' => $courseid], 'id, fullname, shortname');

        if (!$student || !$course) {
            return;
        }

        $context = \context_course::instance($courseid, IGNORE_MISSING);
        if (!$context) {
            return;
        }

        // Get all teachers (editing + non-editing) in this course.
        $teachers = get_enrolled_users($context, 'moodle/grade:viewall');

        $studentfullname = fullname($student);

        foreach ($teachers as $teacher) {
            $message = new \core\message\message();
            $message->component = 'local_smartdashboard';
            $message->name = 'risk_alert';
            $message->userfrom = \core_user::get_noreply_user();
            $message->userto = $teacher;
            $message->subject = get_string('risk_alert_subject', 'local_smartdashboard', $studentfullname);
            $message->fullmessage = get_string('risk_alert_body', 'local_smartdashboard', (object) [
                'studentname' => $studentfullname,
                'coursename' => $course->fullname,
                'riskscore' => round($riskscore),
            ]);
            $message->fullmessageformat = FORMAT_PLAIN;
            $message->fullmessagehtml = get_string('risk_alert_body_html', 'local_smartdashboard', (object) [
                'studentname' => $studentfullname,
                'coursename' => $course->fullname,
                'riskscore' => round($riskscore),
            ]);
            $message->smallmessage = get_string('risk_alert_small', 'local_smartdashboard', (object) [
                'studentname' => $studentfullname,
                'coursename' => $course->shortname,
            ]);
            $message->notification = 1;
            $message->contexturl = new \moodle_url('/local/smartdashboard/index.php');
            $message->contexturlname = get_string('pluginname', 'local_smartdashboard');

            message_send($message);
        }
    }
}

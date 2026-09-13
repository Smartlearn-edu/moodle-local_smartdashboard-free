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

namespace local_smartdashboard\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use core_external\external_single_structure;
use core_external\external_multiple_structure;

/**
 * External functions for the At-Risk Student Alert System.
 *
 * @package     local_smartdashboard
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class risk extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function get_risk_data_parameters() {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'Course ID (0 for all courses)', VALUE_DEFAULT, 0),
        ]);
    }

    /**
     * Get the latest risk data for students in the specified course(s).
     *
     * @param int $courseid Course ID, or 0 for all courses the teacher can see.
     * @return array
     */
    public static function get_risk_data($courseid = 0) {
        global $DB, $USER;

        $params = self::validate_parameters(self::get_risk_data_parameters(), [
            'courseid' => $courseid,
        ]);

        $courseid = $params['courseid'];
        $context = \context_system::instance();
        self::validate_context($context);

        // Build the list of courses to query.
        $courseids = [];
        if ($courseid > 0) {
            $coursecontext = \context_course::instance($courseid);
            require_capability('moodle/grade:viewall', $coursecontext);
            $courseids[] = $courseid;
        } else {
            // Get all courses where the user has grade viewing capability.
            $courses = enrol_get_all_users_courses($USER->id, true);
            foreach ($courses as $course) {
                $cctx = \context_course::instance($course->id, IGNORE_MISSING);
                if ($cctx && has_capability('moodle/grade:viewall', $cctx)) {
                    $courseids[] = $course->id;
                }
            }
        }

        if (empty($courseids)) {
            return ['students' => [], 'summary' => ['total' => 0, 'high' => 0, 'medium' => 0, 'low' => 0]];
        }

        // Get the latest risk snapshot for each student-course combination.
        [$insql, $inparams] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);

        $sql = "SELECT r.*
                  FROM {local_smartdashboard_risk} r
                  JOIN (
                      SELECT userid, courseid, MAX(timecreated) AS maxtime
                        FROM {local_smartdashboard_risk}
                       WHERE courseid {$insql}
                       GROUP BY userid, courseid
                  ) latest ON r.userid = latest.userid
                          AND r.courseid = latest.courseid
                          AND r.timecreated = latest.maxtime
                  JOIN {user} u ON u.id = r.userid AND u.deleted = 0
                 WHERE EXISTS (
                           SELECT 1
                             FROM {user_enrolments} ue
                             JOIN {enrol} e ON e.id = ue.enrolid
                            WHERE e.courseid = r.courseid
                              AND ue.userid = r.userid
                              AND ue.status = 0
                              AND e.status = 0
                       )
                 ORDER BY r.riskscore DESC";

        $records = $DB->get_records_sql($sql, $inparams);

        $students = [];
        $summary = ['total' => 0, 'high' => 0, 'medium' => 0, 'low' => 0];

        // Fetch categories cache.
        $categories = $DB->get_records('course_categories', [], '', 'id, name');

        // Bulk-fetch all user and course records referenced by risk data (avoid N+1).
        $userids = [];
        $courseids = [];
        foreach ($records as $record) {
            $userids[$record->userid] = $record->userid;
            $courseids[$record->courseid] = $record->courseid;
        }

        $users = [];
        if (!empty($userids)) {
            [$uinsql, $uinparams] = $DB->get_in_or_equal(array_values($userids), SQL_PARAMS_NAMED);
            $users = $DB->get_records_select('user', "id $uinsql AND deleted = 0", $uinparams, '', 'id, firstname, lastname, email');
        }

        $courses = [];
        if (!empty($courseids)) {
            [$cinsql, $cinparams] = $DB->get_in_or_equal(array_values($courseids), SQL_PARAMS_NAMED);
            $courses = $DB->get_records_select('course', "id $cinsql", $cinparams, '', 'id, fullname, shortname, category');
        }

        foreach ($records as $record) {
            $user = $users[$record->userid] ?? null;
            $course = $courses[$record->courseid] ?? null;

            if (!$user || !$course) {
                continue;
            }

            $catname = 'Unknown';
            if (isset($categories[$course->category])) {
                $catname = format_string($categories[$course->category]->name);
            }

            $students[] = [
                'userid' => (int) $record->userid,
                'fullname' => fullname($user),
                'email' => $user->email,
                'courseid' => (int) $record->courseid,
                'coursename' => $course->fullname,
                'courseshortname' => $course->shortname,
                'categoryid' => (int) $course->category,
                'categoryname' => $catname,
                'riskscore' => round((float) $record->riskscore, 1),
                'risklevel' => $record->risklevel,
                'score_login' => round((float) $record->score_login, 1),
                'score_completion' => round((float) $record->score_completion, 1),
                'score_grade' => round((float) $record->score_grade, 1),
                'score_overdue' => round((float) $record->score_overdue, 1),
                'score_adaptiveplan' => round((float) $record->score_adaptiveplan, 1),
                'timecreated' => (int) $record->timecreated,
            ];

            $summary['total']++;
            $summary[$record->risklevel]++;
        }

        return ['students' => $students, 'summary' => $summary];
    }

    /**
     * Returns description of method result value.
     *
     * @return external_single_structure
     */
    public static function get_risk_data_returns() {
        return new external_single_structure([
            'students' => new external_multiple_structure(
                new external_single_structure([
                    'userid' => new external_value(PARAM_INT, 'Student user ID'),
                    'fullname' => new external_value(PARAM_TEXT, 'Student full name'),
                    'email' => new external_value(PARAM_TEXT, 'Student email'),
                    'courseid' => new external_value(PARAM_INT, 'Course ID'),
                    'coursename' => new external_value(PARAM_TEXT, 'Course full name'),
                    'courseshortname' => new external_value(PARAM_TEXT, 'Course short name'),
                    'categoryid' => new external_value(PARAM_INT, 'Category ID'),
                    'categoryname' => new external_value(PARAM_TEXT, 'Category name'),
                    'riskscore' => new external_value(PARAM_FLOAT, 'Overall risk score 0-100'),
                    'risklevel' => new external_value(PARAM_TEXT, 'Risk level: low, medium, or high'),
                    'score_login' => new external_value(PARAM_FLOAT, 'Login recency sub-score'),
                    'score_completion' => new external_value(PARAM_FLOAT, 'Completion sub-score'),
                    'score_grade' => new external_value(PARAM_FLOAT, 'Grade sub-score'),
                    'score_overdue' => new external_value(PARAM_FLOAT, 'Overdue activities sub-score'),
                    'score_adaptiveplan' => new external_value(PARAM_FLOAT, 'Adaptive plan sub-score'),
                    'timecreated' => new external_value(PARAM_INT, 'Timestamp of this snapshot'),
                ])
            ),
            'summary' => new external_single_structure([
                'total' => new external_value(PARAM_INT, 'Total students evaluated'),
                'high' => new external_value(PARAM_INT, 'High-risk students count'),
                'medium' => new external_value(PARAM_INT, 'Medium-risk students count'),
                'low' => new external_value(PARAM_INT, 'Low-risk students count'),
            ]),
        ]);
    }
}

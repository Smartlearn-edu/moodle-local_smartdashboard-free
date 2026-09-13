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

/**
 * Mobile output class for Smart Dashboard.
 *
 * Provides the PHP methods called by the Moodle App via
 * tool_mobile_get_content to render Ionic templates.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard\output;

/**
 * Mobile output class.
 *
 * Contains static methods referenced from db/mobile.php handlers.
 * Each method returns a content response array with templates,
 * otherdata, and optional JavaScript.
 */
class mobile {
    /**
     * Returns the main dashboard view for the mobile app.
     *
     * This is a dynamic template: it is generated each time the user
     * opens the Smart Dashboard from the app's main menu. The method
     * detects the user's role and renders the appropriate welcome view.
     *
     * @param array $args Arguments passed by the app (userid, appversioncode, etc.)
     * @return array Content response with templates and otherdata
     */
    public static function mobile_view_dashboard($args) {
        global $OUTPUT, $USER, $CFG;

        // Determine user role.
        $context = \context_system::instance();
        $isprivileged = has_capability('moodle/site:config', $context)
                     || has_capability('moodle/course:create', $context)
                     || is_siteadmin();

        $isstudent = false;
        if (!$isprivileged) {
            $studentroles = get_archetype_roles('student');
            foreach ($studentroles as $role) {
                if (user_has_role_assignment($USER->id, $role->id)) {
                    $isstudent = true;
                    break;
                }
            }
        }

        $isteacher = !$isstudent && !$isprivileged;

        // If the user is not a student and not privileged, check if they have
        // teaching capability in any course.
        if ($isteacher) {
            $mycourses = enrol_get_all_users_courses($USER->id, true);
            $teachingcount = 0;
            foreach ($mycourses as $course) {
                $cctx = \context_course::instance($course->id, IGNORE_MISSING);
                if ($cctx && has_capability('moodle/grade:viewall', $cctx)) {
                    $teachingcount++;
                }
            }
        }

        // Build template data.
        $data = [
            'userid' => $USER->id,
            'userfullname' => fullname($USER),
            'isstudent' => $isstudent,
            'isprivileged' => $isprivileged,
            'isteacher' => $isteacher,
            'wwwroot' => $CFG->wwwroot,
            'dashboardurl' => (new \moodle_url('/local/smartdashboard/index.php'))->out(false),
            'courses' => [],
            'dailyplan' => [],
            'hasdailyplan' => false,
        ];

        // Fetch student specific data.
        if ($isstudent) {
            $data['welcomemessage'] = get_string('welcomebackstudent', 'local_smartdashboard', fullname($USER));

            try {
                // Fetch progress data.
                $progress = \local_smartdashboard\external\analytics::get_cross_course_progress();
                if (!empty($progress['students'][0]['completions'])) {
                    $completions = [];
                    foreach ($progress['students'][0]['completions'] as $comp) {
                        $completions[$comp['courseid']] = clone (object)$comp;
                    }

                    $mobilecourses = [];
                    foreach ($progress['courses'] as $course) {
                        $courseid = $course['id'];
                        $iscompleted = isset($completions[$courseid]) && $completions[$courseid]->completed;
                        $completionpercentage = $iscompleted ? 100 : 0;
                        // Simple fallback logic for now.

                        $course['completion_percentage'] = $completionpercentage;
                        $course['completion_color'] = $completionpercentage == 100 ? 'success' : 'warning';
                        $mobilecourses[] = $course;
                    }
                    $data['courses'] = $mobilecourses;
                }
            } catch (\Exception $e) {
                unset($e);
            }

            try {
                // Fetch daily plan.
                $plan = \local_smartdashboard\external\adaptiveplan::get_daily_plan();
                if (!empty($plan['courses'])) {
                    $data['dailyplan'] = $plan;
                    $data['hasdailyplan'] = true;
                }
            } catch (\Exception $e) {
                unset($e);
            }
        }

        // Fetch teacher/admin specific data.
        if ($isteacher || $isprivileged) {
            try {
                // Fetch risk data (courseid 0 means all courses they have access to).
                $riskdata = \local_smartdashboard\external\risk::get_risk_data(0);
                if (!empty($riskdata['summary']['total'])) {
                    $students = [];
                    foreach ($riskdata['students'] as $s) {
                        $level = strtolower($s['risklevel']);
                        $s['color'] = ($level === 'high') ? 'danger' : (($level === 'medium') ? 'warning' : 'success');
                        // Round risk score to 1 decimal place.
                        $s['riskscore'] = round($s['riskscore'], 1);
                        $students[] = $s;
                    }
                    $data['risk_students'] = $students;
                    $data['risk_summary'] = $riskdata['summary'];
                    $data['hasriskdata'] = true;
                }
            } catch (\Exception $e) {
                unset($e);
            }

            try {
                // Fetch grading overview (courseid 0 means all courses).
                $grading = \local_smartdashboard\external\grading::get_grading_overview(0);
                if (!empty($grading['courses'])) {
                    $data['gradingcourses'] = $grading['courses'];
                    $data['hasgrading'] = true;
                }
            } catch (\Exception $e) {
                unset($e);
            }
        }

        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => $OUTPUT->render_from_template(
                        'local_smartdashboard/mobileapp/dashboard',
                        $data
                    ),
                ],
            ],
            'javascript' => '',
            'otherdata' => [
                'isstudent' => $isstudent ? '1' : '0',
                'isprivileged' => $isprivileged ? '1' : '0',
                'isteacher' => $isteacher ? '1' : '0',
                'userid' => (string) $USER->id,
            ],
        ];
    }
}

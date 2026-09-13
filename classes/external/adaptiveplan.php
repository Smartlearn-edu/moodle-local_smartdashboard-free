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
 * External service for Adaptive Plan integration.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_multiple_structure;
use core_external\external_value;

/**
 * Adaptive plan class.
 */
class adaptiveplan extends external_api {
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function get_daily_plan_parameters() {
        return new external_function_parameters([
            'userid' => new external_value(PARAM_INT, 'User ID to fetch plan for', VALUE_DEFAULT, 0),
        ]);
    }

    /**
     * Get the student's daily study plan from mod_adaptiveplan.
     *
     * @return array
     */
    public static function get_daily_plan($userid = 0) {
        global $DB, $USER;

        // Parameter validation.
        $params = self::validate_parameters(self::get_daily_plan_parameters(), [
            'userid' => $userid,
        ]);
        $targetuserid = $params['userid'];
        if (empty($targetuserid)) {
            $targetuserid = $USER->id;
        }

        // Context validation and capability check.
        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/smartdashboard:view', $context);

        // Security check: if requesting someone else's agenda, ensure permission
        if ($targetuserid != $USER->id) {
            require_once(__DIR__ . '/../../lib.php');
            if (!local_smartdashboard_can_access_user($targetuserid, $USER->id)) {
                throw new \moodle_exception('permissiondenied', 'local_smartdashboard');
            }
        }

        // Check if mod_adaptiveplan is installed.
        $pluginman = \core_plugin_manager::instance();
        $adaptiveplaninfo = $pluginman->get_plugin_info('mod_adaptiveplan');

        if (!$adaptiveplaninfo || !$adaptiveplaninfo->is_installed_and_upgraded()) {
            return [
                'is_installed' => false,
                'courses' => [],
            ];
        }

        // Get courses the user is actively enrolled in.
        $enrolledcourses = enrol_get_users_courses($targetuserid, true, 'id, fullname');
        if (empty($enrolledcourses)) {
            return [
                'is_installed' => true,
                'courses' => [],
            ];
        }

        $courseids = array_keys($enrolledcourses);
        [$cins, $cparams] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);
        $cparams['userid'] = $targetuserid;

        // Get start and end of today.
        $todaystart = usergetmidnight(time());
        $todayend = $todaystart + DAYSECS - 1;

        $cparams['todaystart'] = $todaystart;
        $cparams['todayend'] = $todayend;

        // We need to fetch items that are status = 0 (ToDo) and are either:
        // 1. Overdue: due_date < $todaystart
        // 2. Today: due_date >= $todaystart AND due_date <= $todayend

        $sql = "
            SELECT
                i.id AS itemid,
                i.title,
                i.due_date,
                a.id AS planid,
                a.course AS courseid,
                a.name AS planname
            FROM {adaptiveplan_items} i
            JOIN {adaptiveplan} a ON a.id = i.adaptiveplanid
            JOIN {course_modules} cm ON cm.instance = a.id AND cm.course = a.course
            JOIN {modules} m ON m.id = cm.module AND m.name = 'adaptiveplan'
            WHERE i.userid = :userid
              AND i.status = 0
              AND cm.deletioninprogress = 0
              AND a.course $cins
              AND i.due_date <= :todayend
            ORDER BY a.course ASC, i.due_date ASC
        ";

        $items = $DB->get_records_sql($sql, $cparams);

        if (empty($items)) {
            return [
                'is_installed' => true,
                'courses' => [],
            ];
        }

        // Group by course, then categorize into 'overdue' and 'today'.
        $coursesdata = [];

        foreach ($items as $item) {
            $courseid = $item->courseid;

            if (!isset($coursesdata[$courseid])) {
                $coursesdata[$courseid] = [
                    'courseid' => $courseid,
                    'coursename' => $enrolledcourses[$courseid]->fullname,
                    'overdue_items' => [],
                    'today_items' => [],
                ];
            }

            // Fetch sub-activities for this item.
            $activities = $DB->get_records('adaptiveplan_item_activities', ['itemid' => $item->itemid, 'status' => 0], 'id ASC', 'id, activityname, estimated_time');
            $subtasks = [];
            foreach ($activities as $act) {
                $subtasks[] = [
                    'name' => $act->activityname,
                    'estimated_time' => $act->estimated_time ?: '',
                ];
            }

            $isoverdue = ($item->due_date < $todaystart);
            $itemdata = [
                'id' => $item->itemid,
                'title' => $item->title,
                'due_date' => $item->due_date,
                'due_date_str' => userdate($item->due_date, get_string('strftimedate', 'core_langconfig')),
                'activities' => $subtasks,
            ];

            if ($isoverdue) {
                $coursesdata[$courseid]['overdue_items'][] = $itemdata;
            } else {
                $coursesdata[$courseid]['today_items'][] = $itemdata;
            }
        }

        return [
            'is_installed' => true,
            'courses' => array_values($coursesdata),
        ];
    }

    /**
     * Returns description of method result value
     *
     * @return external_single_structure
     */
    public static function get_daily_plan_returns() {
        return new external_single_structure([
            'is_installed' => new external_value(PARAM_BOOL, 'Whether mod_adaptiveplan is installed'),
            'courses' => new external_multiple_structure(
                new external_single_structure([
                    'courseid' => new external_value(PARAM_INT, 'Course ID'),
                    'coursename' => new external_value(PARAM_TEXT, 'Course Name'),
                    'overdue_items' => new external_multiple_structure(
                        self::get_item_structure(),
                        'List of overdue items',
                        VALUE_OPTIONAL
                    ),
                    'today_items' => new external_multiple_structure(
                        self::get_item_structure(),
                        'List of items due today',
                        VALUE_OPTIONAL
                    ),
                ])
            ),
        ]);
    }

    /**
     * Helper to define item structure.
     */
    private static function get_item_structure() {
        return new external_single_structure([
            'id' => new external_value(PARAM_INT, 'Item ID'),
            'title' => new external_value(PARAM_TEXT, 'Item Title'),
            'due_date' => new external_value(PARAM_INT, 'Due Date Timestamp'),
            'due_date_str' => new external_value(PARAM_TEXT, 'Formatted Due Date'),
            'activities' => new external_multiple_structure(
                new external_single_structure([
                    'name' => new external_value(PARAM_TEXT, 'Activity Name'),
                    'estimated_time' => new external_value(PARAM_TEXT, 'Estimated Time'),
                ])
            ),
        ]);
    }
}

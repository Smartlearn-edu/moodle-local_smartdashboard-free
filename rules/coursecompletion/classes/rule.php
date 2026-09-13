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
 * Smart Dashboard plugin.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace smartdashboardrule_coursecompletion;
use local_smartdashboard\risk\rule_base;
/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function get_weight(): float {
        return (float) get_config('smartdashboardrule_coursecompletion', 'weight');
    }
    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {

        global $DB;
        $totalactivities = $DB->count_records_sql("SELECT COUNT(cm.id) FROM {course_modules} cm JOIN {modules} m ON m.id = cm.module WHERE cm.course = :courseid AND cm.completion > 0 AND cm.deletioninprogress = 0 AND cm.visible = 1", ['courseid' => $courseid]);
        if ($totalactivities > 0) {
            $completed = $DB->count_records_sql("SELECT COUNT(cmc.id) FROM {course_modules_completion} cmc JOIN {course_modules} cm ON cm.id = cmc.coursemoduleid WHERE cmc.userid = :userid AND cm.course = :courseid AND cmc.completionstate > 0", ['userid' => $userid, 'courseid' => $courseid]);
            $completionpct = ($completed / $totalactivities) * 100;
            return 100.0 - $completionpct;
        }
        return 0.0;
    }
}

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

namespace smartdashboardrule_overdue;
use local_smartdashboard\risk\rule_base;
/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function get_weight(): float {
        return (float) get_config('smartdashboardrule_overdue', 'weight');
    }
    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {

        global $DB;
        $overdueassigns = $DB->count_records_sql("SELECT COUNT(a.id) FROM {assign} a JOIN {course_modules} cm ON cm.instance = a.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'assign' WHERE a.course = :courseid2 AND a.duedate > 0 AND a.duedate < :now AND cm.visible = 1 AND cm.deletioninprogress = 0 AND NOT EXISTS (SELECT 1 FROM {assign_submission} sub WHERE sub.assignment = a.id AND sub.userid = :userid AND sub.status = 'submitted')", ['courseid' => $courseid, 'courseid2' => $courseid, 'now' => $now, 'userid' => $userid]);
        $overduequizzes = $DB->count_records_sql("SELECT COUNT(q.id) FROM {quiz} q JOIN {course_modules} cm ON cm.instance = q.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'quiz' WHERE q.course = :courseid2 AND q.timeclose > 0 AND q.timeclose < :now AND cm.visible = 1 AND cm.deletioninprogress = 0 AND NOT EXISTS (SELECT 1 FROM {quiz_attempts} qa WHERE qa.quiz = q.id AND qa.userid = :userid AND qa.state = 'finished')", ['courseid' => $courseid, 'courseid2' => $courseid, 'now' => $now, 'userid' => $userid]);
        $overduecount = $overdueassigns + $overduequizzes;
        $totalgraded = $DB->count_records_sql("SELECT COUNT(a.id) FROM {assign} a JOIN {course_modules} cm ON cm.instance = a.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'assign' WHERE a.course = :courseid2 AND a.duedate > 0 AND cm.visible = 1 AND cm.deletioninprogress = 0", ['courseid' => $courseid, 'courseid2' => $courseid]) + $DB->count_records_sql("SELECT COUNT(q.id) FROM {quiz} q JOIN {course_modules} cm ON cm.instance = q.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'quiz' WHERE q.course = :courseid2 AND q.timeclose > 0 AND cm.visible = 1 AND cm.deletioninprogress = 0", ['courseid' => $courseid, 'courseid2' => $courseid]);
        if ($totalgraded > 0) {
            return min(100.0, ($overduecount / $totalgraded) * 100);
        }
        return 0.0;
    }
}

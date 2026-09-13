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

namespace smartdashboardrule_adaptiveplan;
use local_smartdashboard\risk\rule_base;
/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function get_weight(): float {
        return (float) get_config('smartdashboardrule_adaptiveplan', 'weight');
    }
    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {

        global $DB;
        $dbman = $DB->get_manager();
        if (!$dbman->table_exists('adaptiveplan') || !$dbman->table_exists('adaptiveplan_items')) {
            return 0.0;
        }
        $totalitems = $DB->count_records_sql("SELECT COUNT(api.id) FROM {adaptiveplan_items} api JOIN {adaptiveplan} ap ON ap.id = api.adaptiveplanid JOIN {course_modules} cm ON cm.instance = ap.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'adaptiveplan' WHERE ap.course = :courseid2 AND cm.visible = 1 AND api.userid = :userid", ['courseid' => $courseid, 'courseid2' => $courseid, 'userid' => $userid]);
        if ($totalitems == 0) {
            return 0.0;
        }
        $overdueitems = $DB->count_records_sql("SELECT COUNT(api.id) FROM {adaptiveplan_items} api JOIN {adaptiveplan} ap ON ap.id = api.adaptiveplanid JOIN {course_modules} cm ON cm.instance = ap.id AND cm.course = :courseid JOIN {modules} m ON m.id = cm.module AND m.name = 'adaptiveplan' WHERE ap.course = :courseid2 AND cm.visible = 1 AND api.userid = :userid AND api.due_date > 0 AND api.due_date < :now AND api.status = 0", ['courseid' => $courseid, 'courseid2' => $courseid, 'now' => $now, 'userid' => $userid]);
        return min(100.0, ($overdueitems / $totalitems) * 100);
    }
}

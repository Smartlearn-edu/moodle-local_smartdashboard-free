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

namespace smartdashboardrule_grades;
use local_smartdashboard\risk\rule_base;
/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function get_weight(): float {
        return (float) get_config('smartdashboardrule_grades', 'weight');
    }
    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {

        global $DB;
        $grade = $DB->get_record_sql("SELECT gg.finalgrade, gi.grademax FROM {grade_grades} gg JOIN {grade_items} gi ON gi.id = gg.itemid WHERE gi.courseid = :courseid AND gi.itemtype = 'course' AND gg.userid = :userid", ['courseid' => $courseid, 'userid' => $userid]);
        if ($grade && $grade->grademax > 0 && $grade->finalgrade !== null) {
            $gradepct = ($grade->finalgrade / $grade->grademax) * 100;
            return 100.0 - $gradepct;
        }
        return 40.0; // Moderate risk if no grade
    }
}

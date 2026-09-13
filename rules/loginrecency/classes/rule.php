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

namespace smartdashboardrule_loginrecency;
use local_smartdashboard\risk\rule_base;
/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function get_weight(): float {
        return (float) get_config('smartdashboardrule_loginrecency', 'weight');
    }
    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {

        global $DB;
        $maxdays = (int) get_config('smartdashboardrule_loginrecency', 'max_inactive_days') ?: 14;
        $lastaccess = $DB->get_field('user_lastaccess', 'timeaccess', ['userid' => $userid, 'courseid' => $courseid]);
        if (!$lastaccess) {
            return 100.0;
        }
        $dayssincelogin = ($now - $lastaccess) / DAYSECS;
        return min(100.0, ($dayssincelogin / $maxdays) * 100);
    }
}

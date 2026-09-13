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

defined('MOODLE_INTERNAL') || die;
if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('smartdashboardrule_loginrecency/weight', get_string('weight', 'smartdashboardrule_loginrecency'), get_string('weight_desc', 'smartdashboardrule_loginrecency'), 20, PARAM_FLOAT));
    $settings->add(new admin_setting_configtext('smartdashboardrule_loginrecency/max_inactive_days', get_string('max_inactive_days', 'smartdashboardrule_loginrecency'), get_string('max_inactive_days_desc', 'smartdashboardrule_loginrecency'), 14, PARAM_INT));
}

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
    $settings->add(new admin_setting_configcheckbox(
        'smartdashboardrule_safetynet70/is_hard_trigger',
        get_string('is_hard_trigger', 'smartdashboardrule_safetynet70'),
        get_string('is_hard_trigger_desc', 'smartdashboardrule_safetynet70'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'smartdashboardrule_safetynet70/exam_threshold',
        get_string('exam_threshold', 'smartdashboardrule_safetynet70'),
        get_string('exam_threshold_desc', 'smartdashboardrule_safetynet70'),
        70,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'smartdashboardrule_safetynet70/consecutive_exams',
        get_string('consecutive_exams', 'smartdashboardrule_safetynet70'),
        get_string('consecutive_exams_desc', 'smartdashboardrule_safetynet70'),
        2,
        PARAM_INT
    ));
}

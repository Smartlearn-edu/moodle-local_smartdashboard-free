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
 * External services definition.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_smartdashboard_get_cross_course_progress' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_cross_course_progress',
        'description' => 'Get student progress data for the dashboard',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'local_smartdashboard_get_system_analytics' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_system_analytics',
        'description' => 'Get system wide analytics for admin',
        'type'        => 'read',
        'ajax'        => true,
    ],
    'local_smartdashboard_get_cross_course_grades' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_cross_course_grades',
        'description' => 'Get student grades data for the dashboard overview',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'local_smartdashboard_get_student_detailed_progress' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_student_detailed_progress',
        'description' => 'Get detailed activity progress for a specific student',
        'type'        => 'read',
        'ajax'        => true,
    ],
    'local_smartdashboard_get_grading_overview' => [
        'classname'   => 'local_smartdashboard\external\grading',
        'methodname'  => 'get_grading_overview',
        'description' => 'Get overview of assignments needing grading',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'local_smartdashboard_save_dashboard_settings' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'save_dashboard_settings',
        'description' => 'Save dashboard settings',
        'type'        => 'write',
        'ajax'        => true,
    ],
    'local_smartdashboard_get_dashboard_settings' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_dashboard_settings',
        'description' => 'Get dashboard settings',
        'type'        => 'read',
        'ajax'        => true,
    ],
    // Programs plugin integration.
    'local_smartdashboard_get_programs' => [
        'classname'   => 'local_smartdashboard\external\analytics',
        'methodname'  => 'get_programs',
        'description' => 'Get list of programs with their course IDs (requires enrol/programs plugin)',
        'type'        => 'read',
        'ajax'        => true,
    ],
    // Announcements.
    'local_smartdashboard_dismiss_announcement' => [
        'classname'   => 'local_smartdashboard\external\announcements',
        'methodname'  => 'dismiss_announcement',
        'description' => 'Dismiss an announcement so it no longer shows in the popup',
        'type'        => 'write',
        'ajax'        => true,
    ],
    // Adaptive Study Plan integration.
    'local_smartdashboard_get_daily_plan' => [
        'classname'   => 'local_smartdashboard\external\adaptiveplan',
        'methodname'  => 'get_daily_plan',
        'description' => 'Get the student\'s daily study plan from mod_adaptiveplan',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    // At-Risk Student Alert System.
    'local_smartdashboard_get_risk_data' => [
        'classname'   => 'local_smartdashboard\external\risk',
        'methodname'  => 'get_risk_data',
        'description' => 'Get at-risk student data for the dashboard',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];

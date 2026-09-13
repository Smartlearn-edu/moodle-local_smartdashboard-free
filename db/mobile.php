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
 * Mobile app handler registry for Smart Dashboard.
 *
 * This file tells the Moodle App which delegates to register and which
 * PHP method to call for rendering the mobile view.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$addons = [
    'local_smartdashboard' => [
        'handlers' => [
            'smartdashboard' => [
                'delegate' => 'CoreMainMenuDelegate',
                'method' => 'mobile_view_dashboard',
                'displaydata' => [
                    'title' => 'pluginname',
                    'icon' => 'stats-chart',
                    'class' => '',
                ],
                'styles' => [
                    'url' => '',
                    'version' => 1,
                ],
            ],
        ],
        'lang' => [
            ['pluginname', 'local_smartdashboard'],
            ['welcome_back', 'local_smartdashboard'],
            ['welcomebackstudent', 'local_smartdashboard'],
            ['student_welcome_sub', 'local_smartdashboard'],
            ['teacher_welcome_sub', 'local_smartdashboard'],
            ['loading', 'local_smartdashboard'],
            ['nocourses', 'local_smartdashboard'],
            ['section_overview', 'local_smartdashboard'],
            ['section_progress', 'local_smartdashboard'],
            ['section_grading', 'local_smartdashboard'],
            ['risk_level_high', 'local_smartdashboard'],
            ['risk_level_medium', 'local_smartdashboard'],
            ['risk_level_low', 'local_smartdashboard'],
            ['todays_agenda', 'local_smartdashboard'],
            ['no_pending_tasks', 'local_smartdashboard'],
            ['caught_up', 'local_smartdashboard'],
            ['mobile_no_data', 'local_smartdashboard'],
            ['section_analytics', 'local_smartdashboard'],
            ['category', 'local_smartdashboard'],
            ['at_risk_students', 'local_smartdashboard'],
            ['risk_high', 'local_smartdashboard'],
            ['risk_medium', 'local_smartdashboard'],
            ['risk_low', 'local_smartdashboard'],
            ['grading_pending', 'local_smartdashboard'],
            ['needsgrading', 'local_smartdashboard'],
            ['risk_score', 'local_smartdashboard'],
            ['gotocourse', 'local_smartdashboard'],
            ['due_date', 'local_smartdashboard'],
        ],
    ],
];

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
 * Settings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_smartdashboard', get_string('pluginname', 'local_smartdashboard'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_heading(
        'local_smartdashboard/redirect_heading',
        get_string('redirect_heading', 'local_smartdashboard'),
        get_string('redirect_desc', 'local_smartdashboard')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartdashboard/enabledirect',
        get_string('enabledirect', 'local_smartdashboard'),
        get_string('enabledirect_desc', 'local_smartdashboard'),
        0
    ));

    $roleoptions = [];
    $allroles = role_get_names();
    if ($allroles) {
        foreach ($allroles as $role) {
            $roleoptions[$role->id] = $role->localname;
        }
    }

    $settings->add(new admin_setting_configmultiselect(
        'local_smartdashboard/redirectroles',
        get_string('redirectroles', 'local_smartdashboard'),
        get_string('redirectroles_desc', 'local_smartdashboard'),
        [],
        $roleoptions
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartdashboard/redirectadmins',
        get_string('redirectadmins', 'local_smartdashboard'),
        get_string('redirectadmins_desc', 'local_smartdashboard'),
        0
    ));

    // --- Appearance Settings ---
    $settings->add(new admin_setting_heading(
        'local_smartdashboard/appearance_heading',
        get_string('appearance_heading', 'local_smartdashboard'),
        get_string('appearance_desc', 'local_smartdashboard')
    ));

    $settings->add(new admin_setting_configselect(
        'local_smartdashboard/thememode',
        get_string('thememode', 'local_smartdashboard'),
        get_string('thememode_desc', 'local_smartdashboard'),
        'dark',
        [
            'dark'  => get_string('thememode_dark', 'local_smartdashboard'),
            'light' => get_string('thememode_light', 'local_smartdashboard'),
        ]
    ));

    $settings->add(new admin_setting_configselect(
        'local_smartdashboard/parent_terminology',
        get_string('parent_terminology', 'local_smartdashboard'),
        get_string('parent_terminology_desc', 'local_smartdashboard'),
        'parent',
        [
            'parent' => get_string('term_parent', 'local_smartdashboard'),
            'mentor' => get_string('term_mentor', 'local_smartdashboard'),
            'partner' => get_string('term_partner', 'local_smartdashboard'),
            'supervisor' => get_string('term_supervisor', 'local_smartdashboard'),
            'guardian' => get_string('term_guardian', 'local_smartdashboard'),
            'sponsor' => get_string('term_sponsor', 'local_smartdashboard'),
        ]
    ));

    // --- Student Icons ---
    $settings->add(new admin_setting_heading(
        'local_smartdashboard/student_icons_heading',
        get_string('student_icons_heading', 'local_smartdashboard'),
        get_string('student_icons_desc', 'local_smartdashboard')
    ));

    for ($i = 1; $i <= 10; $i++) {
        $settings->add(new admin_setting_heading(
            'local_smartdashboard/icon_heading_' . $i,
            get_string('icon_heading', 'local_smartdashboard', $i),
            ''
        ));

        $settings->add(new admin_setting_configtext(
            'local_smartdashboard/icon_name_' . $i,
            get_string('icon_name', 'local_smartdashboard'),
            '',
            '',
            PARAM_TEXT
        ));

        $settings->add(new admin_setting_configtext(
            'local_smartdashboard/icon_class_' . $i,
            get_string('icon_class', 'local_smartdashboard'),
            get_string('icon_class_desc', 'local_smartdashboard'),
            'fa-star',
            PARAM_TEXT
        ));

        $settings->add(new admin_setting_configtext(
            'local_smartdashboard/icon_url_' . $i,
            get_string('icon_url', 'local_smartdashboard'),
            '',
            '#',
            PARAM_URL
        ));
    }

    // --- Pro Edition Features Info ---
    $settings->add(new admin_setting_heading(
        'local_smartdashboard/pro_features_heading',
        get_string('pro_features_heading', 'local_smartdashboard'),
        get_string('pro_features_desc', 'local_smartdashboard')
    ));

    // --- Load Subplugin Settings ---
    // Load each risk rule's settings directly into this page under its own heading.
    $ruleplugins = \core_plugin_manager::instance()->get_plugins_of_type('smartdashboardrule');
    foreach ($ruleplugins as $plugin) {
        $settingsfile = $plugin->full_path('settings.php');
        if (file_exists($settingsfile)) {
            $settings->add(new admin_setting_heading(
                'local_smartdashboard/rule_heading_' . $plugin->name,
                $plugin->displayname,
                ''
            ));
            include($settingsfile);
        }
    }
}

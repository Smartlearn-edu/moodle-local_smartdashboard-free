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

namespace local_smartdashboard\plugininfo;

use core\plugininfo\base;

/**
 * Plugininfo class for Smart Dashboard Risk Rules.
 *
 * @package     local_smartdashboard
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class smartdashboardrule extends base {
    /**
     * Determines if a subplugin of this type can be uninstalled from the UI.
     *
     * @return bool
     */
    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        return parent::get_enabled_plugins(); // Assume all installed are enabled by default for now.
    }
}

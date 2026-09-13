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
 * Hook callbacks for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard;

/**
 * Hook callbacks class.
 */
class hook_callbacks {
    /**
     * Executes before HTTP headers are sent, allowing a clean server-side redirect
     * away from the default dashboard before any HTML is rendered.
     */
    public static function before_http_headers(\core\hook\output\before_http_headers $hook): void {
        global $CFG;

        // Skip during install/upgrade to prevent breaking the system.
        if (during_initial_install() || !empty($CFG->upgraderunning)) {
            return;
        }

        // We only intercept direct requests to the default dashboard.
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        if (strpos($script, '/my/index.php') !== false) {
            // Load the plugin's library to access our redirect logic function.
            require_once($CFG->dirroot . '/local/smartdashboard/lib.php');

            // If the user qualifies, redirect them seamlessly.
            if (local_smartdashboard_should_redirect()) {
                $url = new \moodle_url('/local/smartdashboard/index.php');
                \redirect($url);
            }
        }
    }
}

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

namespace local_smartdashboard;

use moodle_url;

/**
 * Event observers for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Event observer class.
 */
class observer {
    /**
     * Intercepts when a user views the default dashboard and redirects them if applicable.
     *
     * @param \core\event\dashboard_viewed $event
     */
    public static function dashboard_viewed(\core\event\dashboard_viewed $event) {
        // Observers run after page headers have already been sent.
        // Redirection is now handled securely in local_smartdashboard_extend_navigation() in lib.php.
    }
}

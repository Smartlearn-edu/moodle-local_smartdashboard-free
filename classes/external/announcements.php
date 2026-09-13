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
 * External functions for announcements.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard\external;

defined('MOODLE_INTERNAL') || die;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;

/**
 * Announcements external functions.
 */
class announcements extends external_api
{
    /**
     * Parameters for dismiss_announcement.
     * @return external_function_parameters
     */
    public static function dismiss_announcement_parameters() {
        return new external_function_parameters([
            'announcementid' => new external_value(\PARAM_INT, 'The discussion ID of the announcement to dismiss'),
        ]);
    }

    /**
     * Dismiss an announcement for the current user.
     *
     * Adds the announcement ID to the user's dismissed list stored as a user preference.
     *
     * @param int $announcementid
     * @return array
     */
    public static function dismiss_announcement($announcementid) {
        global $USER;

        $params = self::validate_parameters(self::dismiss_announcement_parameters(), [
            'announcementid' => $announcementid,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);

        $announcementid = $params['announcementid'];

        // Get current dismissed list.
        $dismissedpref = get_user_preferences('local_smartdashboard_dismissed_announcements', '');
        $dismissedids = $dismissedpref ? explode(',', $dismissedpref) : [];

        // Add new ID if not already present.
        $idstr = (string)$announcementid;
        if (!in_array($idstr, $dismissedids)) {
            $dismissedids[] = $idstr;
        }

        // Save updated preference.
        $newpref = implode(',', $dismissedids);
        set_user_preference('local_smartdashboard_dismissed_announcements', $newpref);

        return ['success' => true, 'dismissed' => $newpref];
    }

    /**
     * Return description for dismiss_announcement.
     * @return external_single_structure
     */
    public static function dismiss_announcement_returns() {
        return new external_single_structure([
            'success' => new external_value(\PARAM_BOOL, 'Whether the dismissal was saved'),
            'dismissed' => new external_value(\PARAM_RAW, 'Updated comma-separated list of dismissed IDs'),
        ]);
    }
}

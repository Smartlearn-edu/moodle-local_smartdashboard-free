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

namespace local_smartdashboard\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\approved_userlist;

/**
 * Privacy API implementation for the Smart Dashboard plugin.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\user_preference_provider {
    /**
     * Returns metadata about this plugin.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'local_smartdashboard_risk',
            [
                'userid' => 'privacy:metadata:risk:userid',
                'courseid' => 'privacy:metadata:risk:courseid',
                'riskscore' => 'privacy:metadata:risk:riskscore',
                'risklevel' => 'privacy:metadata:risk:risklevel',
                'timecreated' => 'privacy:metadata:risk:timecreated',
            ],
            'privacy:metadata:risk'
        );

        $collection->add_user_preference(
            'local_smartdashboard_dismissed_announcements',
            'privacy:metadata:preference:dismissed_announcements'
        );

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist $contextlist The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();

        // Reports are stored at the system context level.
        $sql = "SELECT c.id
                  FROM {context} c
                  JOIN {local_smartdashboard_reports} r ON r.userid = :reportuserid
                 WHERE c.contextlevel = :reportcontextlevel";

        $params = [
            'reportuserid' => $userid,
            'reportcontextlevel' => CONTEXT_SYSTEM,
        ];

        $contextlist->add_from_sql($sql, $params);

        // Risk data is stored at system context level.
        $sql = "SELECT c.id
                  FROM {context} c
                  JOIN {local_smartdashboard_risk} risk ON risk.userid = :riskuserid
                 WHERE c.contextlevel = :riskcontextlevel";

        $params = [
            'riskuserid' => $userid,
            'riskcontextlevel' => CONTEXT_SYSTEM,
        ];

        $contextlist->add_from_sql($sql, $params);

        // AI grades data is stored at system context level.
        $sql = "SELECT c.id
                  FROM {context} c
                  JOIN {local_smartdashboard_ai_grades} g ON g.userid = :aiuserid
                 WHERE c.contextlevel = :aicontextlevel";

        $params = [
            'aiuserid' => $userid,
            'aicontextlevel' => CONTEXT_SYSTEM,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }

        $user = $contextlist->get_user();

        foreach ($contextlist as $context) {
            if ($context->contextlevel == CONTEXT_SYSTEM) {
                // Export reports.
                $records = $DB->get_records('local_smartdashboard_reports', ['userid' => $user->id]);
                if (!empty($records)) {
                    $data = (object)[
                        'reports' => array_values((array)$records),
                    ];
                    \core_privacy\local\request\writer::with_context($context)->export_data(
                        [get_string('pluginname', 'local_smartdashboard'), get_string('saved_reports', 'local_smartdashboard')],
                        $data
                    );
                }

                // Export risk data.
                $riskrecords = $DB->get_records('local_smartdashboard_risk', ['userid' => $user->id]);
                if (!empty($riskrecords)) {
                    $data = (object)[
                        'risk_snapshots' => array_values((array)$riskrecords),
                    ];
                    \core_privacy\local\request\writer::with_context($context)->export_data(
                        [get_string('pluginname', 'local_smartdashboard'), get_string('risk', 'local_smartdashboard')],
                        $data
                    );
                }

                // Export AI grades feedback.
                $aigrades = $DB->get_records('local_smartdashboard_ai_grades', ['userid' => $user->id]);
                if (!empty($aigrades)) {
                    $data = (object)[
                        'ai_grades' => array_values((array)$aigrades),
                    ];
                    \core_privacy\local\request\writer::with_context($context)->export_data(
                        [get_string('pluginname', 'local_smartdashboard'), get_string('grades', 'local_smartdashboard')],
                        $data
                    );
                }
            }
        }
    }

    /**
     * Delete all use data which matches the specified context.
     *
     * @param \context $context A user context.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;
        if ($context->contextlevel == CONTEXT_SYSTEM) {
            $DB->delete_records('local_smartdashboard_reports', []);
            $DB->delete_records('local_smartdashboard_risk', []);
            $DB->delete_records('local_smartdashboard_ai_grades', []);
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
        if (empty($contextlist->count())) {
            return;
        }

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist as $context) {
            if ($context->contextlevel == CONTEXT_SYSTEM) {
                $DB->delete_records('local_smartdashboard_reports', ['userid' => $userid]);
                $DB->delete_records('local_smartdashboard_risk', ['userid' => $userid]);
                $DB->delete_records('local_smartdashboard_ai_grades', ['userid' => $userid]);
            }
        }
    }

    /**
     * Export all user preferences for the plugin.
     *
     * @param int $userid The userid of the user whose data is to be exported.
     */
    public static function export_user_preferences(int $userid) {
        $dismissed = get_user_preferences('local_smartdashboard_dismissed_announcements', null, $userid);

        if ($dismissed !== null) {
            \core_privacy\local\request\writer::with_context(\context_system::instance())
                ->export_user_preference(
                    'local_smartdashboard',
                    'local_smartdashboard_dismissed_announcements',
                    $dismissed,
                    get_string('privacy:metadata:preference:dismissed_announcements', 'local_smartdashboard')
                );
        }
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_SYSTEM) {
            return;
        }

        $sql = "SELECT userid FROM {local_smartdashboard_reports}";
        $userlist->add_from_sql('userid', $sql, []);

        $sql = "SELECT userid FROM {local_smartdashboard_risk}";
        $userlist->add_from_sql('userid', $sql, []);

        $sql = "SELECT userid FROM {local_smartdashboard_ai_grades}";
        $userlist->add_from_sql('userid', $sql, []);
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_SYSTEM) {
            return;
        }

        $userids = $userlist->get_userids();
        if (empty($userids)) {
            return;
        }

        [$insql, $inparams] = $DB->get_in_or_equal($userids);
        $DB->delete_records_select('local_smartdashboard_reports', "userid $insql", $inparams);
        $DB->delete_records_select('local_smartdashboard_risk', "userid $insql", $inparams);
        $DB->delete_records_select('local_smartdashboard_ai_grades', "userid $insql", $inparams);
    }
}

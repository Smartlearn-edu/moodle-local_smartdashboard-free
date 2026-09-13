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
 * Library functions for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Adds the Smart Dashboard link to Moodle's navigation.
 *
 * Adds both a navigation drawer entry and injects JS to add
 * a link to the primary navigation bar in Moodle 4.x Boost themes.
 *
 * Only visible to users with the local/smartdashboard:view capability
 * (teachers, managers) or site admins.
 *
 * @param global_navigation $navigation The global navigation object.
 */
function local_smartdashboard_extend_navigation(global_navigation $navigation) {
    global $PAGE;

    if (!isloggedin() || isguestuser()) {
        return;
    }

    $url = new moodle_url('/local/smartdashboard/index.php');
    $dashboardurl = $url->out(false);

    // 1. Rewrite existing dashboard links if user should be redirected.
    if (local_smartdashboard_should_redirect()) {
        // ACTUAL REDIRECT: Redirect them directly on the server side if they load the page.
        if ($PAGE->pagetype === 'my-index' && !defined('AJAX_SCRIPT') && !defined('WS_SERVER')) {
            redirect($url);
            exit;
        }

        try {
            $PAGE->requires->js_call_amd('local_smartdashboard/redirect', 'init', [$dashboardurl]);
        } catch (Exception $e) {
            debugging(get_string('error_access_denied', 'local_smartdashboard') . ': ' . $e->getMessage());
        }
    }

    $context = context_system::instance();

    // Only show the dedicated Smart Dashboard menu link to admins, managers, and teachers.
    if (!is_siteadmin() && !has_capability('local/smartdashboard:view', $context)) {
        return;
    }

    // 1. Add to navigation drawer (flat navigation).
    $node = $navigation->add(
        get_string('pluginname', 'local_smartdashboard'),
        $url,
        navigation_node::TYPE_CUSTOM,
        null,
        'local_smartdashboard',
        new pix_icon('i/report', '')
    );

    if ($node) {
        $node->showinflatnavigation = true;
    }
}


/**
 * Checks if the current user qualifies for dashboard redirection and caches the result.
 *
 * @return bool
 */
function local_smartdashboard_should_redirect() {
    global $USER, $DB, $SESSION, $CFG;

    if (!isloggedin() || isguestuser()) {
        return false;
    }

    // Session caching removed to allow immediate testing of settings changes.

    $redirect = false;
    if (get_config('local_smartdashboard', 'enabledirect')) {
        if (is_siteadmin()) {
            if (get_config('local_smartdashboard', 'redirectadmins')) {
                $redirect = true;
            }
        } else {
            $roles = get_config('local_smartdashboard', 'redirectroles');
            if (!empty($roles)) {
                $roleids = explode(',', $roles);

                // FIX: Moodle's "Authenticated user" role is virtual and not physically in role_assignments table.
                if (!empty($CFG->defaultuserroleid) && in_array($CFG->defaultuserroleid, $roleids)) {
                    $redirect = true;
                } else {
                    [$insql, $params] = $DB->get_in_or_equal($roleids);
                    $params[] = $USER->id;

                    $sql = "SELECT id FROM {role_assignments} WHERE roleid $insql AND userid = ?";
                    if ($DB->record_exists_sql($sql, $params)) {
                        $redirect = true;
                    }
                }
            }
        }
    }

    return $redirect;
}

/**
 * Checks if the current user has access to view the grades of another user.
 *
 * @param int $userid The user ID whose grades are being accessed.
 * @param int|null $current_userid The user ID attempting access (defaults to $USER->id).
 * @return bool True if access is allowed, false otherwise.
 */
function local_smartdashboard_can_access_user($userid, $current_userid = null) {
    global $USER, $DB;

    if (empty($current_userid)) {
        $current_userid = $USER->id;
    }

    // 1. User can access their own data.
    if ($userid == $current_userid) {
        return true;
    }

    // 2. Admin/Manager with global configuration capability.
    if (is_siteadmin() || has_capability('moodle/site:config', context_system::instance())) {
        return true;
    }

    // 3. Check if the current user is a linked parent via local_parentportal.
    if ($DB->get_manager()->table_exists('local_parentportal_children')) {
        $isparent = $DB->record_exists('local_parentportal_children', [
            'parentid' => $current_userid,
            'childid' => $userid,
        ]);
        if ($isparent) {
            return true;
        }
    }

    // 4. Fallback: Check if they have the view capability in the target user context.
    $usercontext = context_user::instance($userid);
    if (has_capability('local/smartdashboard:view', $usercontext)) {
        return true;
    }

    return false;
}

/**
 * Returns a list of mentees (children) for a given user.
 *
 * Checks both Moodle core role assignments (CONTEXT_USER) and the local_parentportal plugin.
 *
 * @param int $userid The parent/mentor user ID.
 * @return array Array of user objects.
 */
function local_smartdashboard_get_mentees($userid) {
    global $DB;
    $mentees = [];

    // 1. Moodle core mentor roles (role assigned in CONTEXT_USER = level 30).
    $sql = "SELECT DISTINCT u.id, u.firstname, u.lastname, u.email,
                   u.firstnamephonetic, u.lastnamephonetic, u.middlename, u.alternatename
              FROM {role_assignments} ra
              JOIN {context} ctx ON ctx.id = ra.contextid AND ctx.contextlevel = 30
              JOIN {user} u ON u.id = ctx.instanceid AND u.deleted = 0
             WHERE ra.userid = :userid";
    if ($core_mentees = $DB->get_records_sql($sql, ['userid' => $userid])) {
        foreach ($core_mentees as $m) {
            $mentees[$m->id] = $m;
        }
    }

    // 2. local_parentportal links.
    if ($DB->get_manager()->table_exists('local_parentportal_children')) {
        $sql = "SELECT u.id, u.firstname, u.lastname, u.email,
                       u.firstnamephonetic, u.lastnamephonetic, u.middlename, u.alternatename
                  FROM {local_parentportal_children} pc
                  JOIN {user} u ON u.id = pc.childid AND u.deleted = 0
                 WHERE pc.parentid = :parentid";
        if ($portal_mentees = $DB->get_records_sql($sql, ['parentid' => $userid])) {
            foreach ($portal_mentees as $m) {
                $mentees[$m->id] = $m; // Deduplicates by user ID.
            }
        }
    }

    return $mentees;
}

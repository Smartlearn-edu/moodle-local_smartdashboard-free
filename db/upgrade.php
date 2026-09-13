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
 * Upgrade logic for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Xmldb_local_smartdashboard_upgrade function
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_smartdashboard_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2026021507) {
        // Define table local_smartdashboard_reports to be created.
        $table = new xmldb_table('local_smartdashboard_reports');

        // Adding fields to table local_smartdashboard_reports.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('title', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('sql_query', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('chart_type', XMLDB_TYPE_CHAR, '20', null, null, null, 'table');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_smartdashboard_reports.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('fk_userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Adding indexes to table local_smartdashboard_reports.
        $table->add_index('idx_userid', XMLDB_INDEX_NOTUNIQUE, ['userid']);

        // Conditionally launch create table for local_smartdashboard_reports.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2026021507, 'local', 'smartdashboard');
    }

    if ($oldversion < 2026060701) {
        // Define table local_smartdashboard_risk to be created.
        $table = new xmldb_table('local_smartdashboard_risk');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('riskscore', XMLDB_TYPE_NUMBER, '5,2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('risklevel', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, 'low');
        $table->add_field('score_login', XMLDB_TYPE_NUMBER, '5,2', null, null, null, null);
        $table->add_field('score_completion', XMLDB_TYPE_NUMBER, '5,2', null, null, null, null);
        $table->add_field('score_grade', XMLDB_TYPE_NUMBER, '5,2', null, null, null, null);
        $table->add_field('score_overdue', XMLDB_TYPE_NUMBER, '5,2', null, null, null, null);
        $table->add_field('score_adaptiveplan', XMLDB_TYPE_NUMBER, '5,2', null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('fk_userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
        $table->add_key('fk_courseid', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);

        $table->add_index('idx_userid_courseid', XMLDB_INDEX_NOTUNIQUE, ['userid', 'courseid']);
        $table->add_index('idx_risklevel', XMLDB_INDEX_NOTUNIQUE, ['risklevel']);
        $table->add_index('idx_timecreated', XMLDB_INDEX_NOTUNIQUE, ['timecreated']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2026060701, 'local', 'smartdashboard');
    }

    if ($oldversion < 2026061101) {
        // Clear all existing risk snapshots so the next scheduled task run
        // recalculates scores with the new optional hard trigger logic.
        // This avoids stale 100% risk scores from the old hardcoded hard trigger.
        $DB->delete_records('local_smartdashboard_risk');

        upgrade_plugin_savepoint(true, 2026061101, 'local', 'smartdashboard');
    }

    return true;
}

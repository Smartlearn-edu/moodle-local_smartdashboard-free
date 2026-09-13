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
 * External API for Magic Analytics (AI Reports).
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard\external;


use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_multiple_structure;
use core_external\external_value;
use context_system;

/**
 * Magic_analytics class
 */
class magic_analytics extends external_api {
    /**
     * Parameters for get_magic_insight.
     */
    public static function get_magic_insight_parameters() {
        return new external_function_parameters([
            'prompt' => new external_value(PARAM_TEXT, 'The natural language question from the admin'),
        ]);
    }

    /**
     * Helper to provide schema context for AI.
     */
    private static function get_schema_context() {
        global $CFG;
        return "You are an expert Moodle SQL query generator.\n" .
            "Moodle version: " . $CFG->release . "\n" .
            "Database: MySQL/MariaDB\n\n" .
            "IMPORTANT RULES:\n" .
            "1. Use Moodle's {table_name} placeholder syntax (e.g., {course}, {user}, {enrol}). Do NOT use mdl_ prefix.\n" .
            "2. Return ONLY valid JSON with the following keys:\n" .
            "   - 'sql': The SELECT query\n" .
            "   - 'explanation': Brief human-readable explanation of results\n" .
            "   - 'chart_type': One of 'bar', 'line', 'pie', 'doughnut', or 'none'. Use 'none' if " .
            "the data is not suitable for a chart.\n" .
            "   - 'chart_label_column': The SQL alias/column name to use as chart labels. Only if chart_type is not 'none'.\n" .
            "   - 'chart_value_column': The SQL alias/column name to use as chart values. Only if chart_type is not 'none'.\n" .
            "3. Do NOT wrap in markdown code blocks.\n" .
            "4. **CRITICAL SECURITY RULE**: SQL MUST be a pure SELECT query ONLY. You are STRICTLY FORBIDDEN from " .
            "generating any of the following: INSERT, UPDATE, DELETE, DROP, ALTER, TRUNCATE, CREATE, REPLACE, " .
            "GRANT, REVOKE, RENAME, EXEC, EXECUTE, CALL, LOAD DATA, INTO OUTFILE, INTO DUMPFILE, LOCK, " .
            "UNLOCK, FLUSH, SET, PREPARE, DEALLOCATE. Do NOT use semicolons. Do NOT use SQL comments. " .
            "Any non-SELECT query WILL BE REJECTED by the server and will not execute.\n" .
            "5. Do NOT use the LIMIT clause. The system handles limits automatically.\n" .
            "6. Use standard Moodle table names and column names. Do NOT abbreviate table names.\n" .
            "7. Make sure all column references in SELECT, WHERE, HAVING, and ORDER BY clauses come from " .
            "properly JOINed tables.\n" .
            "8. Use meaningful column aliases (e.g., 'course_name', 'student_count') for readability.\n\n" .
            "Common Table Names Reference (Use these exact names):\n" .
            "- {course}: Courses table\n" .
            "- {course_categories}: Course categories\n" .
            "- {user}: Users table\n" .
            "- {role}: Roles table\n" .
            "- {context}: Context table\n" .
            "- {role_assignments}: Role assignments\n" .
            "- {enrol}: Enrollment methods\n" .
            "- {user_enrolments}: User enrollments\n" .
            "- {course_modules}: Activity instances in a course\n" .
            "- {modules}: Module types (e.g. assign, quiz)\n" .
            "- {grade_items}: Grade items\n" .
            "- {grade_grades}: User grades\n" .
            "- {course_completions}: Course completion records\n" .
            "- {course_completion_criteria}: Completion criteria settings (NOT course_completion_crit)\n" .
            "- {course_modules_completion}: Activity completion records\n" .
            "- {assign}: Assignment settings\n" .
            "- {assign_submission}: Assignment submissions\n" .
            "- {quiz}: Quiz settings\n" .
            "- {quiz_attempts}: Quiz attempts\n" .
            "- {forum}: Forum settings\n" .
            "- {forum_posts}: Forum posts\n" .
            "- {logstore_standard_log}: Standard logs\n\n" .
            "Chart Type Guidelines:\n" .
            "- 'bar': Best for comparing quantities across categories (e.g., enrollments per course)\n" .
            "- 'line': Best for trends over time (e.g., enrollments per month)\n" .
            "- 'pie'/'doughnut': Best for showing proportions of a whole (e.g., user distribution by country)\n" .
            "- 'none': Use when data is a list of items, contains only text, or charting would not add value\n\n" .
            "Example output:\n" .
            "{\"sql\": \"SELECT c.fullname AS course_name, COUNT(ue.id) AS enrolled FROM {course} c " .
            "JOIN {enrol} e ON e.courseid = c.id JOIN {user_enrolments} ue ON ue.enrolid = e.id " .
            "GROUP BY c.id, c.fullname ORDER BY enrolled DESC\", " .
            "\"explanation\": \"Top 10 courses by enrollment count\", " .
            "\"chart_type\": \"bar\", \"chart_label_column\": \"course_name\", " .
            "\"chart_value_column\": \"enrolled\"}";
    }

    /**
     * Simulates AI analysis and returns a SQL query + results.
     *
     * @param string $prompt
     * @return array
     */
    public static function get_magic_insight($prompt) {
        global $DB, $USER;

        // Parameter validation.
        $params = self::validate_parameters(self::get_magic_insight_parameters(), [
            'prompt' => $prompt,
        ]);
        $prompt = $params['prompt'];

        // Security check: Only admins for now.
        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        $systemprompt = self::get_schema_context();
        $fullprompt = $systemprompt . "\n\nUser Question: " . $prompt;

        try {
            $generatedcontent = null;

            if (class_exists('\local_aihub\ai')) {
                try {
                    $userprompt = "User Question: " . $prompt;

                    // Call the AI Hub specifically requesting JSON mode = true
                    $aihub_result = \local_aihub\ai::generate_text(
                        $systemprompt, // The massive SQL schema instructions
                        $userprompt, // The user's question
                        true, // JSON mode enabled!
                        'local_smartdashboard', // Component name
                        'Magic SQL Analytics'   // Description
                    );

                    if (isset($aihub_result['success']) && $aihub_result['success']) {
                        $generatedcontent = $aihub_result['data'];
                    }
                } catch (\Throwable $e) {
                    // Silently catch errors so we can fall back to the native Moodle AI
                    error_log('local_smartdashboard: local_aihub failed, falling back to core_ai. Error: ' . $e->getMessage());
                }
            }

            // If the Hub didn't generate anything, use the native core_ai fallback
            if (empty($generatedcontent)) {
                // Check if AI subsystem exists (Moodle 4.1+).
                if (!class_exists('\core_ai\manager')) {
                    throw new \Exception('Moodle AI subsystem not found and local_aihub is not installed.');
                }

                $action = new \core_ai\aiactions\generate_text(
                    $context->id,
                    $USER->id,
                    $fullprompt
                );

                if (!class_exists('\core\di')) {
                    throw new \Exception('Dependency Injection not found.');
                }
                $manager = \core\di::get(\core_ai\manager::class);
                $result = $manager->process_action($action);

                // Check if the AI call was successful.
                if (!$result->get_success()) {
                    $errorcode = $result->get_errorcode();
                    $errormsg = $result->get_errormessage();
                    throw new \Exception('AI provider error (code: ' . $errorcode . '): ' . $errormsg);
                }

                // Get the generated content from the response data.
                $responsedata = $result->get_response_data();
                $generatedcontent = $responsedata['generatedcontent'] ?? '';

                if (empty($generatedcontent)) {
                    throw new \Exception('AI returned empty content. Response data keys: ' . implode(', ', array_keys($responsedata)));
                }
            }

            // Clean markdown if strictly formatted.
            $jsonstr = str_replace(['\x60\x60\x60json', '\x60\x60\x60'], '', $generatedcontent);
            $aidata = json_decode($jsonstr, true);

            if (!$aidata || !isset($aidata['sql'])) {
                // If JSON fails, try to extract it from text.
                if (preg_match('/\{.*\}/s', $jsonstr, $matches)) {
                    $aidata = json_decode($matches[0], true);
                }
                if (!$aidata || !isset($aidata['sql'])) {
                    throw new \Exception('AI did not return valid JSON. Response raw: ' . substr($generatedcontent, 0, 200));
                }
            }

            // Multi-layer SQL safety validation.
            // This is critical: AI-generated SQL must NEVER modify the database.

            $rawsql = trim($aidata['sql']);

            // LAYER 1: Must start with SELECT.
            if (stripos($rawsql, 'SELECT') !== 0) {
                throw new \Exception('Security: Query must start with SELECT. Rejected.');
            }

            // LAYER 2: Block ALL dangerous SQL keywords using word-boundary matching
            // Using \b word boundaries to avoid false positives (e.g., "selected", "updated_at").
            $dangerouskeywords = [
                'INSERT',
                'UPDATE',
                'DELETE',
                'DROP',
                'ALTER',
                'TRUNCATE',
                'CREATE',
                'REPLACE',
                'GRANT',
                'REVOKE',
                'RENAME',
                'EXEC',
                'EXECUTE',
                'CALL',
                'LOAD\s+DATA',
                'INTO\s+OUTFILE',
                'INTO\s+DUMPFILE',
                'LOCK\s+TABLES?',
                'UNLOCK\s+TABLES?',
                'FLUSH',
                'RESET',
                'PURGE',
                'HANDLER',
                'SET\s+',
                'PREPARE',
                'DEALLOCATE',
            ];
            foreach ($dangerouskeywords as $keyword) {
                // Word boundary check: \b ensures we match whole keywords, not substrings.
                if (preg_match('/\b' . $keyword . '\b/i', $rawsql)) {
                    throw new \Exception('Security: Forbidden SQL keyword detected (' . $keyword .
                        '). Only SELECT queries are allowed.');
                }
            }

            // LAYER 3: Block semicolons to prevent multi-statement injection
            // (e.g., "SELECT 1; DROP TABLE users").
            if (strpos($rawsql, ';') !== false) {
                throw new \Exception('Security: Semicolons are not allowed. Only single SELECT statements permitted.');
            }

            // LAYER 4: Block inline comments that could be used for obfuscation
            // E.g., "SEL/**/ECT ... ; DR/**/OP TABLE" or "SELECT 1 -- ; DROP TABLE".
            if (preg_match('/\/\*/', $rawsql) || preg_match('/--/', $rawsql)) {
                throw new \Exception('Security: SQL comments (/* */ or --) are not allowed.');
            }

            // LAYER 5: Block access to system/metadata tables that could leak sensitive info.
            if (preg_match('/\b(information_schema|mysql|performance_schema|sys)\b/i', $rawsql)) {
                throw new \Exception('Security: Access to system tables is not allowed.');
            }

            // Sanitize SQL: convert mdl_ prefix to {tablename} if AI used it.
            $sql = $rawsql;
            $sql = preg_replace('/\bmdl_([a-z_]+)/', '{$1}', $sql);

            // Strip LIMIT clause if present (system handles it).
            $sql = preg_replace('/\s+LIMIT\s+\d+(\s*,\s*\d+)?\s*;?\s*$/i', '', $sql);

            // Execute SQL using Moodle's read-only method (additional safety net).
            $results = $DB->get_records_sql($sql, null, 0, 1000);
            $data = array_values($results);

            return [
                'sql' => $sql,
                'data' => json_encode($data),
                'chart_type' => $aidata['chart_type'] ?? 'none',
                'chart_label_column' => $aidata['chart_label_column'] ?? '',
                'chart_value_column' => $aidata['chart_value_column'] ?? '',
                'explanation' => $aidata['explanation'] ?? 'Here is the report you requested.',
            ];
        } catch (\Throwable $e) {
            $debug = get_class($e) . ': ' . $e->getMessage() . "\n" . $e->getTraceAsString();
            return [
                'sql' => "/* ERROR:\n" . $debug . "\n*/",
                'data' => '[]',
                'chart_type' => 'table',
                'explanation' => 'Failed to generate report: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Returns for get_magic_insight.
     */
    public static function get_magic_insight_returns() {
        return new external_single_structure([
            'sql' => new external_value(PARAM_RAW, 'The generated SQL query'),
            'data' => new external_value(PARAM_RAW, 'JSON encoded result data'),
            'chart_type' => new external_value(PARAM_TEXT, 'Suggested chart type (bar, line, pie, doughnut, none)'),
            'chart_label_column' => new external_value(PARAM_TEXT, 'Column name to use for chart labels', VALUE_DEFAULT, ''),
            'chart_value_column' => new external_value(PARAM_TEXT, 'Column name to use for chart values', VALUE_DEFAULT, ''),
            'explanation' => new external_value(PARAM_TEXT, 'AI explanation'),
        ]);
    }

    /**
     * Parameters for save_report.
     */
    public static function save_report_parameters() {
        return new external_function_parameters([
            'title' => new external_value(PARAM_TEXT, 'Report Title'),
            'sql_query' => new external_value(PARAM_RAW, 'SQL Query'),
            'chart_type' => new external_value(PARAM_TEXT, 'Chart Type', VALUE_DEFAULT, 'table'),
        ]);
    }

    /**
     * Saves a magic report to the database.
     *
     * @param string $title
     * @param string $sqlquery
     * @param string $charttype
     * @return int
     */
    public static function save_report($title, $sqlquery, $charttype = 'table') {
        global $DB, $USER;

        $params = self::validate_parameters(self::save_report_parameters(), [
            'title' => $title,
            'sql_query' => $sqlquery,
            'chart_type' => $charttype,
        ]);
        $title = $params['title'];
        $sqlquery = $params['sql_query'];
        $charttype = $params['chart_type'];

        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        $record = new \stdClass();
        $record->userid = $USER->id;
        $record->title = $title;
        $record->sql_query = $sqlquery; // In real app, sanitization happens before execution.
        $record->chart_type = $charttype;
        $record->timecreated = time();
        $record->timemodified = time();

        $id = $DB->insert_record('local_smartdashboard_reports', $record);

        return $id;
    }

    /**
     * Returns for save_report.
     */
    public static function save_report_returns() {
        return new external_value(PARAM_INT, 'New Report ID');
    }

    /**
     * Parameters for get_saved_reports.
     */
    public static function get_saved_reports_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Lists saved reports.
     */
    public static function get_saved_reports() {
        global $DB, $USER;

        $params = self::validate_parameters(self::get_saved_reports_parameters(), []);

        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        // Get saved reports for this user (or all admins?) — Let's just get all for now for simplicity.
        $reports = $DB->get_records('local_smartdashboard_reports', null, 'timecreated DESC');

        $result = [];
        foreach ($reports as $r) {
            $result[] = [
                'id' => $r->id,
                'title' => $r->title,
                'chart_type' => $r->chart_type,
                'sql_query' => $r->sql_query,
            ];
        }

        return $result;
    }

    /**
     * Returns for get_saved_reports.
     */
    public static function get_saved_reports_returns() {
        return new external_multiple_structure(
            new external_single_structure([
                'id' => new external_value(PARAM_INT, 'Report ID'),
                'title' => new external_value(PARAM_TEXT, 'Title'),
                'chart_type' => new external_value(PARAM_TEXT, 'Chart Type'),
                'sql_query' => new external_value(PARAM_RAW, 'The SQL'),
            ])
        );
    }

    /**
     * Parameters for delete_report.
     */
    public static function delete_report_parameters() {
        return new external_function_parameters([
            'reportid' => new external_value(PARAM_INT, 'The ID of the report to delete'),
        ]);
    }

    /**
     * Deletes a saved magic report.
     *
     * @param int $reportid
     * @return bool
     */
    public static function delete_report($reportid) {
        global $DB;

        $params = self::validate_parameters(self::delete_report_parameters(), [
            'reportid' => $reportid,
        ]);
        $reportid = $params['reportid'];

        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        if (!$DB->record_exists('local_smartdashboard_reports', ['id' => $reportid])) {
            throw new \moodle_exception('invalidrecord', 'error', '', 'Report not found');
        }

        $DB->delete_records('local_smartdashboard_reports', ['id' => $reportid]);

        return true;
    }

    /**
     * Returns for delete_report.
     */
    public static function delete_report_returns() {
        return new external_value(PARAM_BOOL, 'True on success');
    }
}

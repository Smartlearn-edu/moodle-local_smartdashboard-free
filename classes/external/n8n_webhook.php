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

namespace local_smartdashboard\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use core_external\external_single_structure;

/**
 * External service for sending data to n8n webhooks.
 *
 * @package     local_smartdashboard
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class n8n_webhook extends external_api {
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function send_data_parameters() {
        return new external_function_parameters([
            // Use PARAM_TEXT or validate strictly instead of PARAM_RAW where possible.
            // Since it's JSON payload, we accept a text string and validate it internally.
            'payload' => new external_value(PARAM_RAW, 'JSON payload to send to n8n'),
        ]);
    }

    /**
     * Send data to n8n webhook
     *
     * @param string $payload
     * @return array
     */
    public static function send_data($payload) {
        global $USER, $CFG;
        require_once($CFG->libdir . '/filelib.php');

        $params = self::validate_parameters(self::send_data_parameters(), [
            'payload' => $payload,
        ]);

        $payload = $params['payload'];

        // Validate context and capabilities.
        $context = \context_system::instance();
        self::validate_context($context);

        // Check if user has permission to view dashboard/grades.
        if (!has_capability('moodle/grade:viewall', $context)) {
            // Also check if they are a teacher in any course.
            $courses = enrol_get_all_users_courses($USER->id, true);
            $hasaccess = false;
            foreach ($courses as $course) {
                $cctx = \context_course::instance($course->id);
                if (has_capability('moodle/grade:viewall', $cctx)) {
                    $hasaccess = true;
                    break;
                }
            }
            if (!$hasaccess) {
                throw new \moodle_exception('error_access_denied', 'local_smartdashboard');
            }
        }

        $n8nurl = get_config('local_smartdashboard', 'n8n_webhook_url');
        $n8ntoken = get_config('local_smartdashboard', 'n8n_webhook_token');

        if (empty($n8nurl)) {
            return [
                'success' => false,
                'message' => get_string('error_webhook_not_configured', 'local_smartdashboard'),
            ];
        }

        $curl = new \curl();
        $headers = ['Content-Type: application/json'];
        if (!empty($n8ntoken)) {
            $headers[] = 'Authorization: Bearer ' . $n8ntoken;
        }

        // Decode to ensure it's valid JSON and strictly enforce array structure.
        $decoded = json_decode($payload, true);
        if (!$decoded || !is_array($decoded)) {
            return [
                'success' => false,
                'message' => get_string('error_invalid_json', 'local_smartdashboard'),
            ];
        }

        // Add metadata. We sanitize the user's name just in case.
        $decoded['triggered_by'] = clean_param(fullname($USER), PARAM_TEXT);
        $decoded['trigger_time'] = time();
        $decoded['event'] = 'manual_dashboard_push';

        // Re-encode to JSON string. This implicitly sanitizes the structure.
        $safepayload = json_encode($decoded);

        $response = $curl->post($n8nurl, $safepayload, [
            'CURLOPT_HTTPHEADER' => $headers,
            'CURLOPT_TIMEOUT' => 30,
            'CURLOPT_CONNECTTIMEOUT' => 10,
        ]);

        if ($curl->error) {
            return [
                'success' => false,
                'message' => get_string('error_n8n_error', 'local_smartdashboard', $curl->error),
            ];
        }

        return [
            'success' => true,
            'message' => get_string('success_data_sent', 'local_smartdashboard'),
        ];
    }

    /**
     * Returns description of method result value
     *
     * @return external_single_structure
     */
    public static function send_data_returns() {
        return new external_single_structure([
            'success' => new external_value(PARAM_BOOL, 'True if successful'),
            'message' => new external_value(PARAM_TEXT, 'Status message'),
        ]);
    }
}

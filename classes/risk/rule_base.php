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

namespace local_smartdashboard\risk;

/**
 * Base class for all Smart Dashboard Risk Rules (smartdashboardrule subplugins).
 *
 * @package     local_smartdashboard
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class rule_base {
    /**
     * Get the weight of this rule from settings.
     * Default is 20 if not overridden.
     *
     * @return float
     */
    public function get_weight(): float {
        // By default, rules look for a setting named 'weight' in their own plugin configuration.
        // e.g., get_config('smartdashboardrule_loginrecency', 'weight');
        // If not set, return 0 so it doesn't affect the score unexpectedly.
        return 0.0;
    }

    /**
     * Is this rule a "Hard Trigger"?
     * Hard triggers bypass the weighted math. If a hard trigger evaluates to TRUE,
     * the student is instantly marked as HIGH RISK (100%).
     *
     * @return bool
     */
    public function is_hard_trigger(): bool {
        return false; // Default: most rules are just weighted math.
    }

    /**
     * Evaluate the risk for a specific student in a specific course.
     *
     * @param int $userid The student's user ID.
     * @param int $courseid The course ID.
     * @param \context_course $context The course context.
     * @param int $now The current timestamp.
     * @return float|bool If is_hard_trigger() is true, return a boolean (true = High Risk).
     *                    If is_hard_trigger() is false, return a float score between 0 and 100 (100 = max risk).
     */
    abstract public function evaluate(int $userid, int $courseid, \context_course $context, int $now);
}

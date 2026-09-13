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
 * Smart Dashboard plugin.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Safety Net 70% Hard Trigger';
$string['desc'] = 'Instantly flags students if they drop below 70% on two consecutive exams in the same subject, or if their attendance drops below 70% for two consecutive weeks.';
$string['exam_threshold'] = 'Exam Score Threshold (%)';
$string['exam_threshold_desc'] = 'The score percentage below which an exam is considered failed for the safety net.';
$string['consecutive_exams'] = 'Consecutive Exams';
$string['consecutive_exams_desc'] = 'Number of consecutive exams the student must fail to trigger the alert.';
$string['is_hard_trigger'] = 'Enable Hard Trigger';
$string['is_hard_trigger_desc'] = 'When enabled, this rule bypasses the weighted score calculation and instantly marks the student as HIGH RISK (100%) if triggered. When disabled, this rule is ignored.';

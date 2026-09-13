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

namespace smartdashboardrule_safetynet70;
use local_smartdashboard\risk\rule_base;

/**
 * Rule implementation.
 */
class rule extends rule_base {
    public function is_hard_trigger(): bool {
        return (bool) get_config('smartdashboardrule_safetynet70', 'is_hard_trigger');
    }

    /**
     * Evaluate rule.
     * @param int $userid
     * @param int $courseid
     * @return mixed
     */
    public function evaluate(int $userid, int $courseid, \context_course $context, int $now) {
        global $DB;

        $threshold = (int) get_config('smartdashboardrule_safetynet70', 'exam_threshold') ?: 70;
        $consecutive = (int) get_config('smartdashboardrule_safetynet70', 'consecutive_exams') ?: 2;

        // 1. Check for consecutive failed exams.
        // Get all finished quiz attempts for this user in this course, ordered by completion time.
        $sql = "SELECT qa.id, qa.sumgrades, q.sumgrades as maxgrades
                  FROM {quiz_attempts} qa
                  JOIN {quiz} q ON q.id = qa.quiz
                  JOIN {course_modules} cm ON cm.instance = q.id
                  JOIN {modules} m ON m.id = cm.module AND m.name = 'quiz'
                 WHERE qa.userid = :userid
                   AND q.course = :courseid
                   AND qa.state = 'finished'
                   AND cm.visible = 1
              ORDER BY qa.timefinish ASC";

        $attempts = $DB->get_records_sql($sql, ['userid' => $userid, 'courseid' => $courseid]);

        $consecutivefails = 0;
        foreach ($attempts as $attempt) {
            if ($attempt->maxgrades > 0 && $attempt->sumgrades !== null) {
                $percentage = ($attempt->sumgrades / $attempt->maxgrades) * 100;
                if ($percentage < $threshold) {
                    $consecutivefails++;
                    if ($consecutivefails >= $consecutive) {
                        return true; // HARD TRIGGER: 2 consecutive fails!
                    }
                } else {
                    $consecutivefails = 0; // Reset counter if they passed.
                }
            }
        }

        // 2. Check for attendance drop.
        // Assuming attendance is tracked using mod_attendance.
        if ($DB->get_manager()->table_exists('attendance_log')) {
            // Find the percentage of attendance in the last 14 days.
            $twoweeksago = $now - (14 * DAYSECS);
            $attsql = "SELECT COUNT(al.id) as total,
                              SUM(CASE WHEN al.statusid IN (
                                  SELECT id FROM {attendance_statuses} WHERE acronym IN ('P', 'L') 
                                  /* Present or Late count as attended */
                              ) THEN 1 ELSE 0 END) as attended
                         FROM {attendance_log} al
                         JOIN {attendance_sessions} ase ON ase.id = al.sessionid
                         JOIN {attendance} a ON a.id = ase.attendanceid
                        WHERE al.studentid = :userid
                          AND a.course = :courseid
                          AND ase.sessdate >= :twoweeksago
                          AND ase.sessdate <= :now";

            $attdata = $DB->get_record_sql($attsql, [
                'userid' => $userid,
                'courseid' => $courseid,
                'twoweeksago' => $twoweeksago,
                'now' => $now,
            ]);

            if ($attdata && $attdata->total > 0) {
                $attpct = ($attdata->attended / $attdata->total) * 100;
                if ($attpct < $threshold) {
                    return true; // HARD TRIGGER: Attendance dropped below threshold for 2 weeks!
                }
            }
        }

        return false; // Did not trigger safety net.
    }
}

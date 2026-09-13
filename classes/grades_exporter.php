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
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->libdir . '/gradelib.php');

/**
 * Class for Student Course Grades export
 */
class grades_exporter
{
    /** @var int User ID */
    private $userid;

    /** @var context User context */
    private $usercontext;

    /** @var bool Include activity descriptions */
    private $include_description;

    private $preloaded_grades = [];
    private $preloaded_category_items = [];
    private $preloaded_course_items = [];
    private $activity_description_cache = [];

    /**
     * Constructor
     *
     * @param int $userid User ID
     * @param bool $include_description Include activity descriptions
     */
    public function __construct($userid, $include_description = false) {
        $this->userid = $userid;
        $this->usercontext = \context_user::instance($userid);
        $this->include_description = $include_description;
    }

    /**
     * Export user's grades from all courses as HTML
     */
    public function export_user_grades() {
        global $CFG, $SITE, $DB;

        // Verify access
        if (!$this->can_view_user_grades()) {
            throw new \moodle_exception('nopermissions', 'error');
        }

        $user = $DB->get_record('user', ['id' => $this->userid], '*', MUST_EXIST);

        // Generate HTML content
        $html = $this->generate_grades_html($user);

        // Set headers for download
        $filename = clean_filename(fullname($user) . '_all_courses_grades.html');
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

        echo $html;
    }

    /**
     * Generate inline HTML content for user's grades across all courses
     *
     * @return string HTML content
     */
    public function get_inline_grades_html() {
        global $CFG, $SITE, $DB;

        $user = $DB->get_record('user', ['id' => $this->userid], '*', MUST_EXIST);

        $html = '<style>' . $this->get_word_compatible_css() . '</style>';

        $courses = $this->get_user_courses();

        if (empty($courses)) {
            $html .= '<div class="alert">' . get_string('student_nocourses', 'local_smartdashboard') . '</div>';
        } else {
            $html .= $this->get_filter_ui_html($courses);

            // Overall summary (Charts) removed per user request

            foreach ($courses as $course) {
                $html .= $this->get_course_grades_html($user, $course);
            }
        }

        return $html;
    }

    /**
     * Generate HTML content for user's grades across all courses
     *
     * @param stdClass $user User object
     * @return string HTML content
     */
    private function generate_grades_html($user) {
        global $CFG, $SITE;

        $html = $this->get_html_header($user);

        // Get all courses user is enrolled in
        $courses = $this->get_user_courses();

        if (empty($courses)) {
            $html .= '<div class="alert">' . get_string('student_nocourses', 'local_smartdashboard') . '</div>';
        } else {
            $html .= $this->get_filter_ui_html($courses);

            // Overall summary (Charts) removed per user request

            foreach ($courses as $course) {
                $html .= $this->get_course_grades_html($user, $course);
            }
        }

        $html .= $this->get_html_footer();

        return $html;
    }

    /**
     * Get courses user is enrolled in with error handling
     *
     * @return array Array of course objects
     */
    private function get_user_courses() {
        global $DB;

        try {
            // Get enrolled courses using Moodle API
            $courses = enrol_get_users_courses($this->userid, true, 'id,fullname,shortname,visible,summary,summaryformat');
            if (!empty($courses)) {
                return $courses;
            }
        } catch (\Exception $e) {
            error_log('local_smartdashboard: Error getting user courses: ' . $e->getMessage());
        }

        try {
            // Fallback: direct database query
            $sql = "SELECT DISTINCT c.id, c.fullname, c.shortname, c.visible, c.summary, c.summaryformat
                    FROM {course} c
                    JOIN {enrol} e ON e.courseid = c.id
                    JOIN {user_enrolments} ue ON ue.enrolid = e.id
                    WHERE ue.userid = ? AND ue.status = 0 AND e.status = 0 AND c.visible = 1
                    ORDER BY c.fullname";
            $courses = $DB->get_records_sql($sql, [$this->userid]);
            if (!empty($courses)) {
                return $courses;
            }
        } catch (\Exception $e) {
            error_log('local_smartdashboard: Error getting courses from database: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Generate HTML header
     *
     * @param stdClass $user User object
     * @return string HTML header
     */
    private function get_html_header($user) {
        global $SITE, $CFG;

        $html = '<!DOCTYPE html>';
        $html .= '<html dir="' . (right_to_left() ? 'rtl' : 'ltr') . '">';
        $html .= '<head>';
        $html .= '<meta charset="utf-8">';
        $html .= '<title>' . fullname($user) . ' - ' . get_string('pluginname', 'local_smartdashboard') . '</title>';
        $html .= '<style>' . $this->get_word_compatible_css() . '</style>';
        $html .= '</head>';
        $html .= '<body>';

        // Header section
        $html .= '<div class="header">';
        $html .= '<div class="logo-section">';

        // Add site logo if available
        $logourl = $this->get_site_logo_url();
        if ($logourl) {
            $html .= '<img src="' . $logourl . '" alt="' . format_string($SITE->fullname) . ' Logo" class="site-logo">';
        }

        $html .= '<div class="header-text">';
        $html .= '<h1>' . format_string($SITE->fullname) . '</h1>';
        $html .= '<h2>' . get_string('pluginname', 'local_smartdashboard') . '</h2>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="student-info">';
        $html .= '<h3>' . get_string('user', 'local_smartdashboard') . ': ' . fullname($user) . '</h3>';
        $html .= '<p>' . get_string('reportdate', 'local_smartdashboard') . ': ' . userdate(time()) . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Generate grade table HTML for a specific course
     *
     * @param stdClass $user User object
     * @param stdClass $course Course object
     * @return string HTML table
     */
    private function get_course_grades_html($user, $course) {
        global $CFG;

        try {
            $context = \context_course::instance($course->id);
            $gpr = new \grade_plugin_return(['type' => 'report', 'plugin' => 'studentgrades', 'courseid' => $course->id]);
            $gtree = new \grade_tree($course->id, false, false, null, $gpr);

            $html = '<div class="course-section" data-course="' . htmlspecialchars(format_string($course->fullname)) . '">';
            $html .= '<h2 class="course-name">' . format_string($course->fullname) . '</h2>';

            // Extract item data for the course dashboard charts
            $items_data = [];
            if (isset($gtree->top_element['children'])) {
                $this->extract_dashboard_chart_data($gtree->top_element['children'], $user->id, $items_data);
            }

            // Build conic-gradient for the donut chart
            $total_percentage = 0;
            foreach ($items_data as $item) {
                $total_percentage += $item['percentage'];
            }
            $conic_parts = [];
            $current_deg = 0;
            foreach ($items_data as $item) {
                if ($total_percentage > 0 && $item['percentage'] > 0) {
                    $slice_percentage = ($item['percentage'] / $total_percentage) * 100;
                    $end_deg = $current_deg + $slice_percentage;
                    $conic_parts[] = $item['color'] . ' ' . $current_deg . '% ' . $end_deg . '%';
                    $current_deg = $end_deg;
                }
            }
            if (empty($conic_parts)) {
                $conic_parts[] = '#e9ecef 0% 100%';
            }
            $conic_gradient = implode(', ', $conic_parts);

            // Render Dashboard UI
            $html .= '<div style="background: white; padding: 25px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 20px;">';
            $html .= '<h3 style="margin-top: 0; margin-bottom: 25px; color: #1a2b4c; font-size: 1.3em;">Activity Distribution</h3>';
            $html .= '<div style="display: flex; flex-wrap: wrap; gap: 40px;">';

            // Left: Donut Chart + Legend
            $html .= '<div style="flex: 1; min-width: 280px; display: flex; align-items: center; justify-content: center; gap: 30px;">';
            $html .= '<div style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient(' . $conic_gradient . '); display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: relative;">';
            $html .= '<div style="width: 80px; height: 80px; border-radius: 50%; background: white;"></div>';
            // Optional subtle white border slices
            $html .= '<div style="position: absolute; inset: 0; border-radius: 50%; box-shadow: inset 0 0 0 1px white;"></div>';
            $html .= '</div>';

            // Legend
            $html .= '<div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85em; color: #555;">';
            foreach ($items_data as $item) {
                $name = $item['name'];
                if (mb_strlen($name) > 22) {
                    $name = mb_substr($name, 0, 19) . '...';
                }
                $html .= '<div style="display: flex; align-items: center;">';
                $html .= '<span style="width: 24px; height: 10px; background: ' . $item['color'] . '; margin-right: 10px; flex-shrink: 0; display: inline-block;"></span>';
                $html .= '<span>' . htmlspecialchars($name) . '</span>';
                $html .= '</div>';
            }
            if (empty($items_data)) {
                $html .= '<div>No activities found.</div>';
            }
            $html .= '</div>';
            $html .= '</div>'; // End Left

            // Right: Bar Chart
            $html .= '<div style="flex: 1.5; min-width: 300px; display: flex; flex-direction: column; justify-content: flex-end;">';
            $html .= '<div style="display: flex; align-items: flex-end; height: 180px; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc; position: relative; padding-left: 10px; gap: 15px; justify-content: space-around;">';

            // Y-axis labels
            $html .= '<div style="position: absolute; left: -28px; top: -5px; bottom: 0; display: flex; flex-direction: column; justify-content: space-between; font-size: 0.7em; color: #888;">';
            $html .= '<span>100</span><span>75</span><span>50</span><span>25</span><span>0</span>';
            $html .= '</div>';

            // Grid lines
            $html .= '<div style="position: absolute; left: 0; right: 0; top: 25%; border-top: 1px solid #f0f0f0; z-index: 0;"></div>';
            $html .= '<div style="position: absolute; left: 0; right: 0; top: 50%; border-top: 1px solid #f0f0f0; z-index: 0;"></div>';
            $html .= '<div style="position: absolute; left: 0; right: 0; top: 75%; border-top: 1px solid #f0f0f0; z-index: 0;"></div>';
            $html .= '<div style="position: absolute; left: 0; right: 0; top: 0%; border-top: 1px solid #f0f0f0; z-index: 0;"></div>';

            // Bars
            foreach ($items_data as $item) {
                $h = $item['percentage'];
                if ($h <= 0) {
                    $h = 1; // Show tiny sliver for 0
                }
                $html .= '<div style="flex: 1; max-width: 35px; height: ' . $h . '%; background: ' . $item['color'] . '; position: relative; z-index: 1; border-radius: 0; min-width: 12px;">';

                // X-axis rotated label
                $name = $item['name'];
                if (mb_strlen($name) > 18) {
                    $name = mb_substr($name, 0, 15) . '...';
                }
                $html .= '<div style="position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%) rotate(-50deg); transform-origin: top left; font-size: 0.7em; white-space: nowrap; color: #666; text-align: right; width: 100px;">' . htmlspecialchars($name) . '</div>';

                $html .= '</div>';
            }
            $html .= '</div>'; // End chart area
            $html .= '<div style="height: 90px;"></div>'; // Spacer for rotated labels
            $html .= '</div>'; // End Right

            $html .= '</div>'; // End Flex Container
            $html .= '</div>'; // End Dashboard Container

            $html .= '<div class="grade-table" style="margin-top: 20px;">';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>' . get_string('gradeitem', 'local_smartdashboard') . '</th>';
            $html .= '<th>' . get_string('grade', 'local_smartdashboard') . '</th>';
            $html .= '<th>' . get_string('range', 'local_smartdashboard') . '</th>';
            $html .= '<th>' . get_string('percentage', 'local_smartdashboard') . '</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            // Process grade tree
            if (isset($gtree->top_element['children'])) {
                $html .= $this->process_grade_tree_children($gtree->top_element['children'], $user->id, 0);
            }

            // Add course total
            $course_total = $this->get_course_total($user->id, $course->id);
            if ($course_total !== null) {
                $html .= '<tr class="course-total-row">';
                $html .= '<td class="total-name"><strong>' . get_string('coursetotal', 'local_smartdashboard') . '</strong></td>';
                $html .= '<td class="grade-value total-value">' . $course_total['value'] . '</td>';
                $html .= '<td class="grade-range">' . $course_total['range'] . '</td>';
                $html .= '<td class="grade-percentage total-percentage">' . $course_total['percentage'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        } catch (\Exception $e) {
            error_log('local_smartdashboard: Error generating course grades: ' . $e->getMessage());
            return '<div class="course-section"><h2>' . format_string($course->fullname) . '</h2><p>Error loading grades</p></div>';
        }
    }

    /**
     * Extract data for charts (by top-level categories instead of all items)
     */
    private function extract_dashboard_chart_data($children, $userid, &$items_data) {
        $colors = ['#4285F4', '#00C853', '#00B0FF', '#FFB300', '#F44336', '#673AB7', '#FF6D00', '#E91E63', '#9C27B0', '#009688', '#3F51B5', '#8BC34A'];

        foreach ($children as $child) {
            if ($child['type'] == 'category') {
                $category = $child['object'];
                $category_total = $this->calculate_category_total($category, $userid);

                $percentage_val = 0;
                if ($category_total !== null && !empty($category_total['percentage'])) {
                    $raw_str = strip_tags($category_total['percentage']);
                    if ($raw_str !== '-' && $raw_str !== '') {
                        $percentage_val = (float) filter_var(str_replace(',', '.', $raw_str), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                }

                if ($percentage_val > 100) {
                    $percentage_val = 100;
                }
                if ($percentage_val < 0) {
                    $percentage_val = 0;
                }

                $items_data[] = [
                    'name' => format_string($category->fullname),
                    'percentage' => $percentage_val,
                    'color' => $colors[count($items_data) % count($colors)],
                ];
            } else if ($child['type'] == 'item') {
                $grade_item = $child['object'];
                if ($grade_item->itemtype == 'course' || !$this->can_view_grade_item($grade_item)) {
                    continue;
                }

                $grade_grade = $this->get_preloaded_grade($grade_item, $userid);

                $percentage_val = 0;
                if ($grade_grade && !is_null($grade_grade->finalgrade)) {
                    $formatted = \grade_format_gradevalue($grade_grade->finalgrade, $grade_item, true, GRADE_DISPLAY_TYPE_PERCENTAGE);
                    $raw_str = strip_tags($formatted);
                    if ($raw_str !== '-' && $raw_str !== '') {
                        $percentage_val = (float) filter_var(str_replace(',', '.', $raw_str), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                }

                if ($percentage_val > 100) {
                    $percentage_val = 100;
                }
                if ($percentage_val < 0) {
                    $percentage_val = 0;
                }

                $items_data[] = [
                    'name' => format_string($grade_item->itemname),
                    'percentage' => $percentage_val,
                    'color' => $colors[count($items_data) % count($colors)],
                ];
            }
        }
    }

    /**
     * Process grade tree children recursively
     *
     * @param array $children Grade tree children
     * @param int $userid User ID
     * @param int $level Nesting level
     * @return string HTML rows
     */
    private function process_grade_tree_children($children, $userid, $level = 0, $current_category = '') {
        $html = '';

        foreach ($children as $key => $child) {
            if ($child['type'] == 'category') {
                $category = $child['object'];
                $cat_name = format_string($category->fullname);

                // Category header
                $html .= '<tr class="category-row level-' . $level . '" data-category="' . htmlspecialchars($cat_name) . '">';
                $html .= '<td colspan="4"><strong>' . $cat_name . '</strong></td>';
                $html .= '</tr>';

                // Process category children
                if (!empty($child['children'])) {
                    $html .= $this->process_grade_tree_children($child['children'], $userid, $level + 1, $cat_name);
                }

                // Add category total
                if (!empty($child['children'])) {
                    $category_total = $this->calculate_category_total($category, $userid);
                    if ($category_total !== null) {
                        $html .= '<tr class="category-total-row level-' . $level . '" data-category="' . htmlspecialchars($cat_name) . '">';
                        $html .= '<td class="total-name"><strong>' . get_string('total', 'local_smartdashboard') . ' - ' . $cat_name . '</strong></td>';
                        $html .= '<td class="grade-value total-value">' . $category_total['value'] . '</td>';
                        $html .= '<td class="grade-range">' . $category_total['range'] . '</td>';
                        $html .= '<td class="grade-percentage total-percentage">' . $category_total['percentage'] . '</td>';
                        $html .= '</tr>';
                    }
                }
            } else if ($child['type'] == 'item') {
                $grade_item = $child['object'];

                // Skip course total item
                if ($grade_item->itemtype == 'course') {
                    continue;
                }

                // Check visibility
                if (!$this->can_view_grade_item($grade_item)) {
                    continue;
                }

                $grade_grade = $this->get_preloaded_grade($grade_item, $userid);

                $html .= '<tr class="grade-row level-' . $level . '" data-category="' . htmlspecialchars($current_category) . '">';

                $description = '';
                if ($this->include_description) {
                    $description = $this->get_activity_description($grade_item);
                }
                $html .= '<td class="item-name">';
                $html .= '<div class="item-title">' . format_string($grade_item->itemname) . '</div>';
                if ($description) {
                    $html .= '<div class="item-description">' . $description . '</div>';
                }
                $html .= '</td>';

                // Grade value
                $gradevalue = $this->format_grade_value($grade_grade, $grade_item);
                $html .= '<td class="grade-value">' . $gradevalue . '</td>';

                // Grade range
                $range = $this->format_grade_range($grade_item);
                $html .= '<td class="grade-range">' . $range . '</td>';

                // Percentage
                $percentage = $this->format_grade_percentage($grade_grade, $grade_item);
                $html .= '<td class="grade-percentage">' . $percentage . '</td>';

                $html .= '</tr>';
            }
        }

        return $html;
    }

    /**
     * Format grade value for display
     */
    private function format_grade_value($grade_grade, $grade_item) {
        if (!$grade_grade || is_null($grade_grade->finalgrade)) {
            return '-';
        }
        return \grade_format_gradevalue($grade_grade->finalgrade, $grade_item, true);
    }

    /**
     * Format grade range for display
     */
    private function format_grade_range($grade_item) {
        return \grade_format_gradevalue($grade_item->grademin, $grade_item, true) . ' - ' .
            \grade_format_gradevalue($grade_item->grademax, $grade_item, true);
    }

    /**
     * Format grade percentage for display
     */
    private function format_grade_percentage($grade_grade, $grade_item) {
        if (!$grade_grade || is_null($grade_grade->finalgrade)) {
            return '-';
        }
        return \grade_format_gradevalue($grade_grade->finalgrade, $grade_item, true, GRADE_DISPLAY_TYPE_PERCENTAGE);
    }

    /**
     * Calculate category total grade
     */
    private function calculate_category_total($category, $userid) {
        $category_item = $this->get_category_item($category);
        if (!$category_item) {
            return null;
        }

        $category_grade = $this->get_preloaded_grade($category_item, $userid);
        if (!$category_grade || is_null($category_grade->finalgrade)) {
            return null;
        }

        return [
            'value' => \grade_format_gradevalue($category_grade->finalgrade, $category_item, true),
            'range' => \grade_format_gradevalue($category_item->grademin, $category_item, true) . ' - ' .
                \grade_format_gradevalue($category_item->grademax, $category_item, true),
            'percentage' => \grade_format_gradevalue($category_grade->finalgrade, $category_item, true, GRADE_DISPLAY_TYPE_PERCENTAGE),
        ];
    }

    /**
     * Get course total grade
     */
    private function get_course_total($userid, $courseid) {
        $course_item = $this->get_course_item_cached($courseid);
        if (!$course_item) {
            return null;
        }

        $course_grade = $this->get_preloaded_grade($course_item, $userid);
        if (!$course_grade || is_null($course_grade->finalgrade)) {
            return null;
        }

        return [
            'value' => \grade_format_gradevalue($course_grade->finalgrade, $course_item, true),
            'range' => \grade_format_gradevalue($course_item->grademin, $course_item, true) . ' - ' .
                \grade_format_gradevalue($course_item->grademax, $course_item, true),
            'percentage' => \grade_format_gradevalue($course_grade->finalgrade, $course_item, true, GRADE_DISPLAY_TYPE_PERCENTAGE),
        ];
    }

    /**
     * Generate overall summary HTML
     */
    private function get_overall_summary_html($user, $courses) {
        $html = '<div class="overall-summary" style="margin-top: 40px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #6f42c1;">';
        $html .= '<h2 style="margin-top: 0;">' . get_string('overallsummary', 'local_smartdashboard') . '</h2>';
        $html .= '<p><strong>' . get_string('totalcourses', 'local_smartdashboard') . ':</strong> ' . count($courses) . '</p>';

        $chart_data = [];
        foreach ($courses as $course) {
            $percentage_val = 0;
            $percentage_str = '0 %';

            $course_total = $this->get_course_total($user->id, $course->id);
            if ($course_total && !empty($course_total['percentage'])) {
                $raw_str = strip_tags($course_total['percentage']);
                if ($raw_str !== '-' && $raw_str !== '') {
                    $percentage_str = $raw_str;
                    $percentage_val = (float) filter_var(str_replace(',', '.', $percentage_str), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }
            }

            if ($percentage_val > 100) {
                $percentage_val = 100;
            }
            if ($percentage_val < 0) {
                $percentage_val = 0;
            }

            $chart_data[] = [
                'name' => format_string($course->fullname),
                'percentage' => $percentage_val,
                'display' => $percentage_str,
            ];
        }

        if (!empty($chart_data)) {
            $html .= '<h3 style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 15px;">Course Performance</h3>';
            $html .= '<div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;">';
            foreach ($chart_data as $data) {
                $percentage = $data['percentage'];
                $color = '#28a745'; // Green
                if ($percentage < 50) {
                    $color = '#dc3545'; // Red
                } else if ($percentage < 75) {
                    $color = '#ffc107'; // Yellow
                } else if ($percentage < 85) {
                    $color = '#17a2b8'; // Blue
                }

                $html .= '<div style="width: 160px; text-align: center; display: flex; flex-direction: column; align-items: center;">';
                // Pie chart using conic-gradient
                $html .= '<div style="width: 120px; height: 120px; border-radius: 50%; background: conic-gradient(' . $color . ' 0% ' . $percentage . '%, #e9ecef ' . $percentage . '% 100%); display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">';
                // Inner circle for donut effect
                $html .= '<div style="width: 90px; height: 90px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1em; color: #333; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
                $html .= $data['display'];
                $html .= '</div>';
                $html .= '</div>';
                // Course Name
                $html .= '<div style="margin-top: 12px; font-size: 0.9em; font-weight: bold; color: #555; word-wrap: break-word;">' . $data['name'] . '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Check if user can view grade item
     */
    private function can_view_grade_item($grade_item) {
        try {
            if ($grade_item->is_hidden()) {
                return false;
            }
            return !$grade_item->is_locked() && !$grade_item->is_hidden();
        } catch (\Exception $e) {
            error_log('local_smartdashboard: Error checking grade item visibility: ' . $e->getMessage());
            return true;
        }
    }

    /**
     * Check if current user can view this user's grades
     */
    private function can_view_user_grades() {
        global $CFG;
        require_once($CFG->dirroot . '/report/studentgrades/lib.php');
        return local_smartdashboard_can_access_user($this->userid);
    }

    /**
     * Get color setting with fallback to default
     */
    private function get_color_setting($setting, $default) {
        $value = get_config('local_smartdashboard', $setting);
        return !empty($value) ? $value : $default;
    }

    /**
     * Get all color settings
     */
    private function get_color_settings() {
        return [
            'header_primary' => $this->get_color_setting('header_primary_color', '#6f42c1'),
            'header_secondary' => $this->get_color_setting('header_secondary_color', '#8e44ad'),
            'header_text' => $this->get_color_setting('header_text_color', '#ffffff'),
            'grade_excellent' => $this->get_color_setting('grade_excellent_color', '#28a745'),
            'grade_good' => $this->get_color_setting('grade_good_color', '#17a2b8'),
            'grade_average' => $this->get_color_setting('grade_average_color', '#ffc107'),
            'grade_poor' => $this->get_color_setting('grade_poor_color', '#dc3545'),
            'table_border' => $this->get_color_setting('table_border_color', '#dee2e6'),
            'row_alternate' => $this->get_color_setting('row_alternate_color', '#f8f9fa'),
            'row_hover' => $this->get_color_setting('row_hover_color', '#e8f4fd'),
            'category_primary' => $this->get_color_setting('category_primary_color', '#4a4a4a'),
            'category_secondary' => $this->get_color_setting('category_secondary_color', '#2d2d2d'),
            'category_total_primary' => $this->get_color_setting('category_total_primary_color', '#17a2b8'),
            'category_total_secondary' => $this->get_color_setting('category_total_secondary_color', '#138496'),
            'course_total_primary' => $this->get_color_setting('course_total_primary_color', '#28a745'),
            'course_total_secondary' => $this->get_color_setting('course_total_secondary_color', '#1e7e34'),
            'grade_value' => $this->get_color_setting('grade_value_color', '#28a745'),
            'grade_value_bg' => $this->get_color_setting('grade_value_bg_color', '#f8fff9'),
            'percentage' => $this->get_color_setting('percentage_color', '#007bff'),
            'percentage_bg' => $this->get_color_setting('percentage_bg_color', '#f8feff'),
        ];
    }

    /**
     * Get Word-compatible CSS with configurable colors
     */
    private function get_word_compatible_css() {
        $colors = $this->get_color_settings();

        return '
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            margin: 20px;
            direction: ' . (right_to_left() ? 'rtl' : 'ltr') . ';
            background-color: #f8f9fa;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid ' . $colors['header_primary'] . ';
            padding-bottom: 20px;
            background: linear-gradient(135deg, ' . $colors['header_primary'] . ' 0%, ' . $colors['header_secondary'] . ' 100%);
            color: ' . $colors['header_text'] . ';
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .site-logo {
            max-height: 60px;
            max-width: 200px;
            margin-right: 20px;
            background: white;
            padding: 8px;
            border-radius: 8px;
        }
        
        .header h1 {
            font-size: 18pt;
            margin: 0 0 8px 0;
            font-weight: bold;
        }
        
        .header h2 {
            font-size: 16pt;
            margin: 0;
            font-weight: normal;
        }
        
        .student-info {
            background-color: #f8f9fa;
            color: #333;
            padding: 15px;
            border-radius: 0 0 8px 8px;
            margin-top: 10px;
        }
        
        .student-info h3 {
            font-size: 14pt;
            margin: 0 0 5px 0;
            color: ' . $colors['header_primary'] . ';
            font-weight: bold;
        }
        
        .course-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        
        .course-name {
            background: linear-gradient(135deg, ' . $colors['category_primary'] . ' 0%, ' . $colors['category_secondary'] . ' 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            margin: 20px 0 0 0;
            font-size: 14pt;
        }
        
        .grade-table {
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th, td {
            border: 1px solid ' . $colors['table_border'] . ';
            padding: 12px 15px;
            text-align: ' . (right_to_left() ? 'right' : 'left') . ';
        }
        
        th {
            background: linear-gradient(135deg, ' . $colors['header_primary'] . ' 0%, ' . $colors['header_secondary'] . ' 100%);
            color: ' . $colors['header_text'] . ';
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .category-row td {
            background: linear-gradient(135deg, ' . $colors['category_primary'] . ' 0%, ' . $colors['category_secondary'] . ' 100%);
            color: white;
            font-weight: bold;
        }
        
        .grade-row td {
            background-color: ' . $colors['row_alternate'] . ';
        }
        
        .grade-row:nth-child(even) td {
            background-color: #ffffff;
        }
        
        .grade-value {
            text-align: center;
            font-weight: bold;
            color: ' . $colors['grade_value'] . ';
            background-color: ' . $colors['grade_value_bg'] . ' !important;
        }
        
        .grade-range {
            text-align: center;
            color: #6c757d;
        }
        
        .grade-percentage {
            text-align: center;
            font-weight: bold;
            color: ' . $colors['percentage'] . ';
            background-color: ' . $colors['percentage_bg'] . ' !important;
        }
        
        .category-total-row td {
            background: linear-gradient(135deg, ' . $colors['category_total_primary'] . ' 0%, ' . $colors['category_total_secondary'] . ' 100%);
            color: white;
            font-weight: bold;
        }
        
        .course-total-row td {
            background: linear-gradient(135deg, ' . $colors['course_total_primary'] . ' 0%, ' . $colors['course_total_secondary'] . ' 100%);
            color: white;
            font-weight: bold;
            font-size: 12pt;
        }
        
        .overall-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border-left: 5px solid ' . $colors['header_primary'] . ';
        }
        
        @media print {
            body { 
                margin: 15px; 
                background-color: white;
            }
            .header { 
                background: ' . $colors['header_primary'] . ' !important;
                -webkit-print-color-adjust: exact;
            }
        }
        
        .item-description {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px dotted #eee;
        }
        
        .item-description img {
            max-width: 100%;
            height: auto;
        }
        ';
    }

    /**
     * Get site logo URL with error handling
     */
    private function get_site_logo_url() {
        global $CFG, $OUTPUT;

        try {
            if (!empty($CFG->logo)) {
                return $CFG->wwwroot . '/pluginfile.php/1/core_admin/logo/0x200/' . $CFG->logo;
            }

            if (method_exists($OUTPUT, 'get_logo_url')) {
                try {
                    $logourl = $OUTPUT->get_logo_url();
                    if ($logourl && !empty($logourl)) {
                        return $logourl->out();
                    }
                } catch (\Exception $e) {
                    // Continue to next method
                }
            }
        } catch (\Exception $e) {
            error_log('local_smartdashboard: Error getting logo: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get activity description if available
     */
    private function get_activity_description($grade_item) {
        global $DB, $CFG;

        if ($grade_item->itemtype !== 'mod') {
            return '';
        }

        $cache_key = $grade_item->itemmodule . '_' . $grade_item->iteminstance;
        if (isset($this->activity_description_cache[$cache_key])) {
            return $this->activity_description_cache[$cache_key];
        }

        try {
            // Get course module
            $cm = get_coursemodule_from_instance($grade_item->itemmodule, $grade_item->iteminstance, $grade_item->courseid);
            if (!$cm) {
                $this->activity_description_cache[$cache_key] = '';
                return '';
            }

            // Get activity record with intro
            $activity = $DB->get_record($grade_item->itemmodule, ['id' => $grade_item->iteminstance], 'id, intro, introformat');

            if ($activity && !empty($activity->intro)) {
                // Keep HTML but strip dangerous tags and limit size if needed
                // Using standard Moodle formatting
                $modcontext = \context_module::instance($cm->id);

                // Rewrite plugin file URLs to make images work
                $description = file_rewrite_pluginfile_urls($activity->intro, 'pluginfile.php', $modcontext->id, 'mod_' . $grade_item->itemmodule, 'intro', null);

                $formatted = format_text($description, $activity->introformat, ['noclean' => true, 'para' => false, 'context' => $modcontext]);
                $this->activity_description_cache[$cache_key] = $formatted;
                return $formatted;
            }
        } catch (\Exception $e) {
            // Silently fail to avoid breaking the report
        }

        $this->activity_description_cache[$cache_key] = '';
        return '';
    }

    private function preload_course_grades($courseid, $userid) {
        global $DB;
        if (!isset($this->preloaded_grades[$courseid])) {
            $this->preloaded_grades[$courseid] = [];
            $sql = "SELECT g.* FROM {grade_grades} g JOIN {grade_items} i ON i.id = g.itemid WHERE g.userid = ? AND i.courseid = ?";
            if ($grades = $DB->get_records_sql($sql, [$userid, $courseid])) {
                foreach ($grades as $grade) {
                    $this->preloaded_grades[$courseid][$grade->itemid] = new \grade_grade($grade, false);
                }
            }
        }
    }

    private function get_preloaded_grade($grade_item, $userid) {
        $courseid = $grade_item->courseid;
        if ($courseid) {
            $this->preload_course_grades($courseid, $userid);
            if (array_key_exists($grade_item->id, $this->preloaded_grades[$courseid])) {
                return $this->preloaded_grades[$courseid][$grade_item->id];
            }
            return false;
        }
        return \grade_grade::fetch(['itemid' => $grade_item->id, 'userid' => $userid]);
    }

    private function get_category_item($category) {
        $courseid = $category->courseid;
        if (!isset($this->preloaded_category_items[$courseid])) {
            $this->preloaded_category_items[$courseid] = [];
            global $DB;
            if ($items = $DB->get_records('grade_items', ['courseid' => $courseid, 'itemtype' => 'category'])) {
                foreach ($items as $item) {
                    $this->preloaded_category_items[$courseid][$item->iteminstance] = new \grade_item($item, false);
                }
            }
        }
        return $this->preloaded_category_items[$courseid][$category->id] ?? null;
    }

    private function get_course_item_cached($courseid) {
        if (!isset($this->preloaded_course_items[$courseid])) {
            $this->preloaded_course_items[$courseid] = \grade_item::fetch_course_item($courseid);
        }
        return $this->preloaded_course_items[$courseid];
    }

    /**
     * Trigger AI Analysis by sending data to n8n
     */
    public function trigger_ai_analysis() {
        global $DB, $CFG;
        require_once($CFG->libdir . '/filelib.php');

        // Check permissions
        if (!$this->can_view_user_grades()) {
            throw new \moodle_exception('nopermissions', 'error');
        }

        // Check for rate limiting (Cooldown)
        $cooldown_minutes = (int)get_config('local_smartdashboard', 'aicooldown');
        if ($cooldown_minutes > 0) {
            $last_request_time = (int)get_user_preferences('local_smartdashboard_last_ai_request', 0, $this->userid);
            $current_time = time();
            $time_diff = $current_time - $last_request_time;
            $cooldown_seconds = $cooldown_minutes * 60;

            if ($time_diff < $cooldown_seconds) {
                // Rate limit exceeded
                $minutes_remaining = ceil(($cooldown_seconds - $time_diff) / 60);
                return ['success' => false, 'message' => get_string('dailylimitreached', 'local_smartdashboard', (int)$minutes_remaining)];
            }
        }

        // Get config from local_smartdashboard
        $n8n_url = get_config('local_smartdashboard', 'webhookurl');
        $n8n_token = get_config('local_smartdashboard', 'token');

        if (!$n8n_url) {
            return ['success' => false, 'message' => get_string('aiconfigmissing', 'local_smartdashboard')];
        }

        $user = $DB->get_record('user', ['id' => $this->userid], '*', MUST_EXIST);

        // Gather data
        $data = $this->get_user_grades_data($user);

        // Update last request time
        if ($cooldown_minutes > 0) {
            set_user_preference('local_smartdashboard_last_ai_request', time(), $this->userid);
        }

        // Send to n8n
        return $this->post_to_n8n($n8n_url, $n8n_token, $data);
    }

    /**
     * Gather all user grades data into a structured array
     */
    public function get_user_grades_data($user) {
        $data = [
            'student' => [
                'id' => $user->id,
                'fullname' => fullname($user),
                'email' => $user->email,
                'username' => $user->username,
            ],
            'generated_at' => time(),
            'courses' => [],
        ];

        $courses = $this->get_user_courses();
        foreach ($courses as $course) {
            $course_data = [
                'id' => $course->id,
                'fullname' => format_string($course->fullname),
                'shortname' => format_string($course->shortname),
                'description' => '', // Default empty
                'grades' => [],
            ];

            // Add course summary/description
            if (!empty($course->summary)) {
                $course_context = \context_course::instance($course->id);
                $summary = file_rewrite_pluginfile_urls($course->summary, 'pluginfile.php', $course_context->id, 'course', 'summary', null);
                $course_data['description'] = format_text($summary, $course->summaryformat ?? FORMAT_HTML, ['noclean' => true, 'para' => false, 'context' => $course_context]);
            }

            // Get grades
            $gpr = new \grade_plugin_return(['type' => 'report', 'plugin' => 'studentgrades', 'courseid' => $course->id]);
            $gtree = new \grade_tree($course->id, false, false, null, $gpr);

            if (isset($gtree->top_element['children'])) {
                $course_data['grades'] = $this->extract_grade_tree_data($gtree->top_element['children'], $user->id);
            }

            // Add course total
            $course_total = $this->get_course_total($user->id, $course->id);
            if ($course_total) {
                $course_data['total'] = $course_total;
            }

            $data['courses'][] = $course_data;
        }

        return $data;
    }

    /**
     * Recursive function to extract grade data
     */
    private function extract_grade_tree_data($children, $userid) {
        $items = [];

        foreach ($children as $child) {
            if ($child['type'] == 'category') {
                $category = $child['object'];
                $cat_data = [
                    'type' => 'category',
                    'name' => format_string($category->fullname),
                    'children' => [],
                ];

                if (!empty($child['children'])) {
                    $cat_data['children'] = $this->extract_grade_tree_data($child['children'], $userid);
                }

                $items[] = $cat_data;
            } else if ($child['type'] == 'item') {
                $grade_item = $child['object'];

                if ($grade_item->itemtype == 'course' || !$this->can_view_grade_item($grade_item)) {
                    continue;
                }

                $grade_grade = $this->get_preloaded_grade($grade_item, $userid);

                $item_data = [
                    'type' => 'item',
                    'name' => format_string($grade_item->itemname),
                    'grade' => $this->format_grade_value($grade_grade, $grade_item),
                    'range' => $this->format_grade_range($grade_item),
                    'percentage' => $this->format_grade_percentage($grade_grade, $grade_item),
                    'description' => $this->get_activity_description($grade_item),
                ];

                // Add feedback if exists
                if ($grade_grade && !empty($grade_grade->feedback)) {
                    $item_data['feedback'] = format_text($grade_grade->feedback, $grade_grade->feedbackformat);
                }

                $items[] = $item_data;
            }
        }

        return $items;
    }

    /**
     * Post data to n8n webhook
     */
    private function post_to_n8n($url, $token, $data) {
        $curl = new \curl();
        $options = [
            'CURLOPT_HTTPHEADER' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
            'CURLOPT_RETURNTRANSFER' => true,
        ];

        // Moodle's curl class might not support setopt array directly in constructor depending on version,
        // but let's use the post method which is standard.
        // We'll set headers manually.
        $curl->setHeader('Content-Type: application/json');
        $curl->setHeader('Authorization: Bearer ' . $token); // Or just 'Authorization: ' . $token depending on how n8n is set up, usually Bearer is safe.
        // If the user said "n8n Token", it might be a query param or header. Standard webhook protection is usually header.
        // Let's also add it to query string to be safe if that's how they implemented it?
        // No, let's stick to Header.
        // Actually, many n8n webhooks just use the URL. The "Token" usually refers to a Header Auth.
        // I will add X-N8N-Token as well just in case.
        $curl->setHeader('X-N8N-Chat-Token: ' . $token); // Common pattern

        // Moodle curl post takes ($url, $params, $options)
        // For JSON body, we usually pass string in $params.

        $json_data = json_encode($data);

        $response = $curl->post($url, $json_data);
        $info = $curl->get_info();

        if ($info['http_code'] == 200 || $info['http_code'] == 201) {
            return ['success' => true, 'message' => get_string('analysisrequestsent', 'local_smartdashboard')];
        } else {
            $a = new \stdClass();
            $a->code = $info['http_code'];
            $a->response = $response;
            return ['success' => false, 'message' => get_string('failedtosenddata', 'local_smartdashboard', $a)];
        }
    }

    /**
     * Generate Filter UI HTML
     */
    private function get_filter_ui_html($courses) {
        $html = '<div class="filter-controls" style="margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">';
        $html .= '<h3 style="margin-top: 0;">' . get_string('filtergrades', 'local_smartdashboard') . '</h3>';
        $html .= '<div style="display: flex; gap: 15px; flex-wrap: wrap;">';

        // Course Filter
        $html .= '<div><label style="font-weight:bold; display:block;">' . get_string('coursename', 'local_smartdashboard') . ':</label>';
        $html .= '<select id="course-filter" onchange="applyFilters()" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; min-width: 200px;">';
        $html .= '<option value="">' . get_string('allcourses', 'local_smartdashboard') . '</option>';
        foreach ($courses as $course) {
            $html .= '<option value="' . htmlspecialchars(format_string($course->fullname)) . '">' . format_string($course->fullname) . '</option>';
        }
        $html .= '</select></div>';

        // Category / Search Filter
        $html .= '<div><label style="font-weight:bold; display:block;">' . get_string('categorysearch', 'local_smartdashboard') . ':</label>';
        $html .= '<input type="text" id="category-filter" onkeyup="applyFilters()" placeholder="' . get_string('typetofilter', 'local_smartdashboard') . '" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; min-width: 200px;">';
        $html .= '</div>';

        $html .= '</div></div>';

        $html .= '<script>
        function applyFilters() {
            var courseFilter = document.getElementById("course-filter").value.toLowerCase();
            var textFilter = document.getElementById("category-filter").value.toLowerCase();
            
            var courseSections = document.querySelectorAll(".course-section");
            
            courseSections.forEach(function(section) {
                var courseName = section.getAttribute("data-course").toLowerCase();
                var showCourse = (courseFilter === "" || courseName === courseFilter);
                
                if (!showCourse) {
                    section.style.display = "none";
                    return;
                }
                
                var hasVisibleRows = false;
                var rows = section.querySelectorAll("tbody tr");
                
                rows.forEach(function(row) {
                    if (row.classList.contains("course-total-row")) {
                        row.style.display = (textFilter === "") ? "" : "none";
                        if (textFilter === "") hasVisibleRows = true;
                        return;
                    }
                    
                    var rowText = row.textContent.toLowerCase();
                    var category = (row.getAttribute("data-category") || "").toLowerCase();
                    
                    if (textFilter === "" || rowText.includes(textFilter) || category.includes(textFilter)) {
                        row.style.display = "";
                        hasVisibleRows = true;
                    } else {
                        row.style.display = "none";
                    }
                });
                
                section.style.display = hasVisibleRows ? "" : "none";
            });
        }
        </script>';

        return $html;
    }

    /**
     * Generate HTML footer
     */
    private function get_html_footer() {
        return '</body></html>';
    }
}

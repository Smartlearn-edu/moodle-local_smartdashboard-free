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
 * Main entry point for the Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/lib/enrollib.php');

require_login();

// Define the page context and properties.
$context = context_system::instance();

// We rely on require_login() and internal logic for access control.
require_capability('local/smartdashboard:view', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartdashboard/index.php'));
$PAGE->set_title(get_string('pluginname', 'local_smartdashboard'));
$PAGE->set_heading(fullname($USER));
$PAGE->set_pagelayout('report');
$PAGE->blocks->add_region('content');

echo $OUTPUT->header();

// Fetch courses based on role & filter.
$courses = [];
$categoriesoptions = [];
$selectedcategory = optional_param('categoryid', 0, PARAM_INT);
$showclicked = optional_param('show', false, PARAM_BOOL);
$viewuserid = optional_param('viewuser', 0, PARAM_INT);
$requestedrole = optional_param('role', '', PARAM_ALPHA);

// Check for Admin/Manager privileges (System level).
$isprivileged = has_capability('moodle/site:config', $context) || has_capability('moodle/course:create', $context) || is_siteadmin();

require_once($CFG->dirroot . '/local/smartdashboard/lib.php');

// 1. Determine available roles.
$availableroles = [];

// Check if they are a student or teacher anywhere.
$mycourses = enrol_get_my_courses('id, visible');
$has_student = false;
$has_teacher = false;
foreach ($mycourses as $course) {
    $cctx = context_course::instance($course->id);
    if (has_capability('moodle/course:update', $cctx) || has_capability('moodle/grade:viewall', $cctx)) {
        $has_teacher = true;
    } else if (has_capability('mod/assign:submit', $cctx) || has_capability('mod/quiz:attempt', $cctx)) {
        $has_student = true;
    }
}

// Check mentees
$mentees = local_smartdashboard_get_mentees($USER->id);
$has_parent = !empty($mentees);

if ($has_student || (empty($mycourses) && !$has_teacher && !$has_parent && !$isprivileged)) {
    $availableroles['student'] = true;
}
if ($has_teacher || $isprivileged) {
    $availableroles['teacher'] = true;
}
if ($has_parent) {
    $availableroles['parent'] = true;
}

// Determine active role
if (empty($requestedrole) || !isset($availableroles[$requestedrole])) {
    // Default priority: student -> teacher -> parent
    if (isset($availableroles['student'])) {
        $activerole = 'student';
    } else if (isset($availableroles['teacher'])) {
        $activerole = 'teacher';
    } else if (isset($availableroles['parent'])) {
        $activerole = 'parent';
    } else {
        $activerole = 'student'; // Fallback
    }
} else {
    $activerole = $requestedrole;
}

// Ensure the page URL includes the active role.
$PAGE->set_url(new moodle_url('/local/smartdashboard/index.php', ['role' => $activerole]));

// Handle Target User logic based on Active Role
if ($activerole == 'parent') {
    if ($viewuserid && $viewuserid != $USER->id) {
        if (!local_smartdashboard_can_access_user($viewuserid, $USER->id)) {
            throw new \moodle_exception('nopermissions', 'error');
        }
    }
    // If no viewuser is provided, we set it to 0 so the template can show a "select a mentee" state.
    $targetuserid = $viewuserid ?: 0;
} else {
    $targetuserid = $USER->id;
}

// Ensure teacher logic doesn't override if role is not teacher.
$is_teacher_mode = ($activerole == 'teacher');

if ($is_teacher_mode && $isprivileged) {
    // Admin Mode: Fetch Category Dropdown Data
    // We use a flat list with indentation for simplicity in select box.
    if (class_exists('core_course_category')) {
        $cats = core_course_category::make_categories_list();
    } else {
        require_once($CFG->libdir . '/coursecatlib.php');
        $cats = coursecat::make_categories_list();
    }

    foreach ($cats as $id => $name) {
        $categoriesoptions[] = [
            'id' => $id,
            'name' => $name,
            'selected' => ($id == $selectedcategory),
        ];
    }

    // Only fetch courses if "Show" is clicked, or if we want to show everything by default (User requested OFF by default).
    if ($showclicked) {
        // 1. Calculate Stats (Recursive: All subcategories)
        if ($selectedcategory > 0) {
            $category = null;
            if (class_exists('core_course_category')) {
                $category = core_course_category::get($selectedcategory, IGNORE_MISSING);
            } else {
                $category = coursecat::get($selectedcategory, IGNORE_MISSING);
            }

            if ($category) {
                // Get all children IDs recursively using the path.
                $subcatids = $DB->get_fieldset_sql("SELECT id FROM {course_categories} WHERE path LIKE ?", [$category->path . '/%']);
                $allcatids = array_merge([$selectedcategory], $subcatids);

                [$insql, $inparams] = $DB->get_in_or_equal($allcatids, SQL_PARAMS_NAMED);

                // Get course IDs for these categories to calculate stats.
                $statcourseids = $DB->get_fieldset_sql("SELECT id FROM {course} WHERE category $insql", $inparams);

                // Issue 9 & 12: Use a single query with a recordset to calculate all stats (parent and children) in one pass.
                $uniquestudents = 0;
                $totalenrollments = 0;
                $directchildren = $category->get_children();

                $childstats = [];
                foreach ($directchildren as $child) {
                    $childstats[$child->id] = ['unique' => [], 'total' => 0];
                }

                if (!empty($statcourseids)) {
                    [$courseinsql, $courseinparams] = $DB->get_in_or_equal($statcourseids, SQL_PARAMS_NAMED);

                    $coursecats = $DB->get_records_sql("SELECT id, category FROM {course} WHERE id $courseinsql", $courseinparams);
                    $allcats = $DB->get_records_list('course_categories', 'id', $allcatids, '', 'id, path');

                    $sql = "SELECT ra.id, ra.userid, ctx.instanceid as courseid
                              FROM {role_assignments} ra
                              JOIN {context} ctx ON ctx.id = ra.contextid
                              JOIN {role} r ON r.id = ra.roleid
                             WHERE ctx.contextlevel = 50
                               AND ctx.instanceid $courseinsql
                               AND r.shortname = 'student'";

                    $rs = $DB->get_recordset_sql($sql, $courseinparams);
                    $uniquestudentsoverall = [];

                    foreach ($rs as $record) {
                        $userid = $record->userid;
                        $courseid = $record->courseid;

                        $uniquestudentsoverall[$userid] = true;
                        $totalenrollments++;

                        if (isset($coursecats[$courseid]) && isset($allcats[$coursecats[$courseid]->category])) {
                            $catpath = $allcats[$coursecats[$courseid]->category]->path;
                            foreach ($directchildren as $child) {
                                if (strpos($catpath . '/', $child->path . '/') === 0) {
                                    $childstats[$child->id]['unique'][$userid] = true;
                                    $childstats[$child->id]['total']++;
                                    break;
                                }
                            }
                        }
                    }
                    $rs->close();
                    $uniquestudents = count($uniquestudentsoverall);
                }

                foreach ($directchildren as $child) {
                    $subcategories[] = [
                        'id' => $child->id,
                        'name' => $child->get_formatted_name(),
                        'totalenrollments' => $childstats[$child->id]['total'],
                        'uniquestudents' => count($childstats[$child->id]['unique']),
                        'url' => (new moodle_url('/local/smartdashboard/index.php', ['categoryid' => $child->id, 'show' => 1]))->out(),
                    ];
                }
            }
        }

        // 3. Fetch Display Courses (Direct children only)
        $params = [];
        $sql = "SELECT c.id, c.fullname, c.shortname, c.visible, c.category, c.summary, c.summaryformat
                  FROM {course} c
                 WHERE c.id != 1"; // Exclude site course.

        if ($selectedcategory > 0) {
            $sql .= " AND c.category = :categoryid";
            $params['categoryid'] = $selectedcategory;
        }

        $sql .= " ORDER BY c.fullname ASC";
        $courses = $DB->get_records_sql($sql, $params, 0, 500);
    }
} else if ($is_teacher_mode) {
    // Teacher Mode: Existing behavior (include non-editing teachers).
    $allcourses = enrol_get_my_courses('id, fullname, shortname, summary, visible, category', 'visible DESC, sortorder ASC');
    foreach ($allcourses as $course) {
        $cctx = context_course::instance($course->id);
        if (has_capability('moodle/course:update', $cctx) || has_capability('moodle/grade:viewall', $cctx)) {
            $courses[] = $course;
        }
    }
}

// Create renderable.
$dashboard = new \local_smartdashboard\output\dashboard(
    $courses,
    $isprivileged,
    $categoriesoptions,
    $selectedcategory,
    $showclicked,
    $totalenrollments ?? 0,
    $uniquestudents ?? 0,
    $subcategories ?? [],
    $targetuserid,
    $activerole,
    array_keys($availableroles)
);

// Render the template.
echo $OUTPUT->render_from_template('local_smartdashboard/dashboard', $dashboard->export_for_template($OUTPUT));

echo $OUTPUT->footer();

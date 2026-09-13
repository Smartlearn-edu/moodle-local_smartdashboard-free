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
 * Dashboard output class.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartdashboard\output;


use renderable;
use templatable;
use renderer_base;
use stdClass;
use context_course;
use core_course\external\course_summary_exporter;
use moodle_url;
use coursecat;
use core_course_category;

/**
 * Dashboard class
 */
class dashboard implements renderable, templatable
{
    /** @var array $courses List of courses data */
    protected $coursesinput;

    /** @var bool $isprivileged Whether user is Admin/Manager */
    protected $isprivileged;

    /** @var array $categories List of all categories for filter */
    protected $categories;

    /** @var int $selectedcategory Selected category ID */
    protected $selectedcategory;

    /** @var bool $showclicked Whether the show button was clicked */
    protected $showclicked;

    /** @var int $totalenrollments Total enrollments (sum of all students in courses) */
    protected $totalenrollments;

    /** @var int $uniquestudents Unique students count */
    protected $uniquestudents;

    /** @var array $subcategories List of direct subcategories with stats */
    protected $subcategories;

    /** @var int $targetuserid Target user ID for the dashboard view */
    protected $targetuserid;

    /**
     * Constructor.
     *
     * @param array $courses Raw course objects
     * @param bool $isprivileged
     * @param array $categories List of categories (for admins)
     * @param int $selectedcategory Selected category ID
     * @param bool $showclicked Whether the show button was clicked
     * @param int $totalenrollments
     * @param int $uniquestudents
     * @param array $subcategories
     * @param int $targetuserid
     */
    /** @var string Active role */
    protected $activerole;

    /** @var array List of available roles */
    protected $availableroles;

    public function __construct(
        $courses,
        $isprivileged = false,
        $categories = [],
        $selectedcategory = 0,
        $showclicked = false,
        $totalenrollments = 0,
        $uniquestudents = 0,
        $subcategories = [],
        $targetuserid = null,
        $activerole = 'student',
        $availableroles = []
    ) {
        $this->coursesinput = $courses;
        $this->isprivileged = $isprivileged;
        $this->categories = $categories;
        $this->selectedcategory = $selectedcategory;
        $this->showclicked = $showclicked;
        $this->totalenrollments = $totalenrollments;
        $this->uniquestudents = $uniquestudents;
        $this->subcategories = $subcategories;
        $this->activerole = $activerole;
        $this->availableroles = $availableroles;

        global $USER;
        $this->targetuserid = $targetuserid ?: $USER->id;
    }

    /**
     * Export data for the template.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->courses = [];
        $data->isprivileged = $this->isprivileged;
        $data->categories = isset($this->categories) ? array_values($this->categories) : [];
        $data->selectedcategory = $this->selectedcategory;
        $data->showclicked = $this->showclicked;

        // Stats.
        $data->totalenrollments = $this->totalenrollments;
        $data->uniquestudents = $this->uniquestudents;
        $data->hasstats = ($this->totalenrollments > 0);

        // Subcategories.
        $data->subcategories = array_values($this->subcategories);
        $data->hassubcategories = !empty($this->subcategories);
        global $USER, $PAGE, $DB;
        require_once(__DIR__ . '/../../lib.php');
        $data->userfullname = fullname($USER);

        // Handle roles
        $data->activerole = $this->activerole;
        $data->hasmultipleroles = count($this->availableroles) > 1;

        if ($data->hasmultipleroles) {
            $data->roleswitcher = [];
            foreach (['student', 'teacher', 'parent'] as $r) {
                if (in_array($r, $this->availableroles)) {
                    if ($r == 'parent') {
                        $term = get_config('local_smartdashboard', 'parent_terminology') ?: 'parent';
                        $rolename = get_string('term_' . $term, 'local_smartdashboard');
                    } else {
                        $rolename = get_string('role_' . $r, 'local_smartdashboard') ?: ucfirst($r);
                    }

                    $data->roleswitcher[] = [
                        'role' => $r,
                        'name' => $rolename,
                        'isactive' => ($r == $this->activerole),
                        'url' => (new moodle_url('/local/smartdashboard/index.php', ['role' => $r]))->out(false),
                    ];
                }
            }
        }

        $data->has_target_mentee = ($this->targetuserid != 0 && $this->targetuserid != $USER->id);
        $data->isstudent = ($this->activerole == 'student' || ($this->activerole == 'parent' && $data->has_target_mentee));
        $data->isparent = ($this->activerole == 'parent');
        $data->isteacher = ($this->activerole == 'teacher');

        // Mentee Selection.
        $all_mentees = local_smartdashboard_get_mentees($USER->id);
        $filtered_mentee_ids = [];

        if (!empty($all_mentees)) {
            $data->menteeprograms = [];
            $program_list = [];
            $mentee_ids = array_keys($all_mentees);
            $filtered_mentee_ids = $mentee_ids; // default to all

            [$insql, $inparams] = $DB->get_in_or_equal($mentee_ids);

            // 1. Fetch from tool_muprog
            if ($DB->get_manager()->table_exists('tool_muprog_program') && $DB->get_manager()->table_exists('tool_muprog_allocation')) {
                $sql_muprog = "SELECT DISTINCT p.id, p.fullname, 'muprog' as sourceplugin
                                 FROM {tool_muprog_program} p
                                 JOIN {tool_muprog_allocation} a ON a.programid = p.id
                                WHERE a.userid $insql AND a.archived = 0";
                if ($muprogs = $DB->get_records_sql($sql_muprog, $inparams)) {
                    foreach ($muprogs as $prog) {
                        $program_list[$prog->id . '_muprog'] = [
                            'id' => $prog->id,
                            'fullname' => format_string($prog->fullname),
                            'plugin' => 'muprog',
                        ];
                    }
                }
            }

            // 2. Fetch from enrol_programs
            if ($DB->get_manager()->table_exists('enrol_programs_programs') && $DB->get_manager()->table_exists('enrol_programs_allocations')) {
                $sql_enrolprog = "SELECT DISTINCT p.id, p.fullname, 'enrol_programs' as sourceplugin
                                    FROM {enrol_programs_programs} p
                                    JOIN {enrol_programs_allocations} a ON a.programid = p.id
                                   WHERE a.userid $insql";
                if ($enrolprogs = $DB->get_records_sql($sql_enrolprog, $inparams)) {
                    foreach ($enrolprogs as $prog) {
                        $program_list[$prog->id . '_enrol_programs'] = [
                            'id' => $prog->id,
                            'fullname' => format_string($prog->fullname),
                            'plugin' => 'enrol_programs',
                        ];
                    }
                }
            }

            $selectedprogram = optional_param('program', '', PARAM_ALPHANUMEXT);

            if (!empty($program_list)) {
                // Sort alphabetically
                usort($program_list, function ($a, $b) {
                    return strcmp($a['fullname'], $b['fullname']);
                });

                foreach ($program_list as &$prog) {
                    $progid_with_plugin = $prog['id'] . '_' . $prog['plugin'];
                    $prog['selected'] = ($selectedprogram === $progid_with_plugin);
                    if ($prog['selected']) {
                        $data->selectedprogramname = $prog['fullname'];
                    }

                    $urlparams = ['role' => 'parent', 'program' => $progid_with_plugin];
                    // Clear viewuser here so it defaults back to overview of the selected program
                    $prog['url'] = (new moodle_url('/local/smartdashboard/index.php', $urlparams))->out(false);

                    $data->menteeprograms[] = $prog;
                }
                $data->hasmenteeprograms = true;

                $allprogramsurlparams = ['role' => 'parent'];
                if ($this->targetuserid != $USER->id) {
                    $allprogramsurlparams['viewuser'] = $this->targetuserid;
                }
                $data->allprogramsurl = (new moodle_url('/local/smartdashboard/index.php', $allprogramsurlparams))->out(false);
                $data->programselected = !empty($selectedprogram);

                // --- Step 2: Filter mentees based on selected program ---
                if (!empty($selectedprogram)) {
                    [$progid, $plugin] = explode('_', $selectedprogram, 2);
                    $allowed_mentee_ids = [];

                    if ($plugin === 'muprog' && $DB->get_manager()->table_exists('tool_muprog_allocation')) {
                        $allowed_mentee_ids = $DB->get_fieldset_sql(
                            "
                            SELECT userid FROM {tool_muprog_allocation}
                            WHERE programid = ? AND userid $insql AND archived = 0",
                            array_merge([$progid], $inparams)
                        );
                    } else if ($plugin === 'enrol_programs' && $DB->get_manager()->table_exists('enrol_programs_allocations')) {
                        $allowed_mentee_ids = $DB->get_fieldset_sql(
                            "
                            SELECT userid FROM {enrol_programs_allocations}
                            WHERE programid = ? AND userid $insql",
                            array_merge([$progid], $inparams)
                        );
                    }

                    if (!empty($allowed_mentee_ids)) {
                        $filtered_mentee_ids = $allowed_mentee_ids;
                    } else {
                        $filtered_mentee_ids = []; // No mentees in this program
                    }

                    // --- Step 3: Program Analytics ---
                    if (!empty($filtered_mentee_ids)) {
                        $data->showprogramanalytics = true;
                        $program_course_ids = [];

                        if ($plugin === 'muprog' && $DB->get_manager()->table_exists('tool_muprog_item')) {
                            $program_course_ids = $DB->get_fieldset_sql(
                                "
                                SELECT courseid FROM {tool_muprog_item}
                                WHERE programid = ? AND type = 'course' AND courseid IS NOT NULL",
                                [$progid]
                            );
                        } else if ($plugin === 'enrol_programs' && $DB->get_manager()->table_exists('enrol_programs_items')) {
                            $program_course_ids = $DB->get_fieldset_sql(
                                "
                                SELECT courseid FROM {enrol_programs_items}
                                WHERE programid = ? AND courseid IS NOT NULL",
                                [$progid]
                            );
                        }

                        foreach ($program_list as $p) {
                            if ($p['id'] . '_' . $p['plugin'] === $selectedprogram) {
                                $data->program_name = $p['fullname'];
                                break;
                            }
                        }

                        if (!empty($program_course_ids)) {
                            [$cinsql, $cinparams] = $DB->get_in_or_equal($program_course_ids);
                            [$uinsql, $uinparams] = $DB->get_in_or_equal($filtered_mentee_ids);

                            // 1. Program Average Grade
                            $sql_avg = "SELECT AVG((gg.finalgrade / gi.grademax) * 100) AS average
                                          FROM {grade_grades} gg
                                          JOIN {grade_items} gi ON gi.id = gg.itemid
                                         WHERE gg.userid $uinsql
                                           AND gi.courseid $cinsql
                                           AND gi.itemtype = 'course'
                                           AND gg.finalgrade IS NOT NULL
                                           AND gi.grademax > 0";
                            $params_avg = array_merge($uinparams, $cinparams);
                            $program_avg = $DB->get_field_sql($sql_avg, $params_avg);

                            $data->program_average = $program_avg !== false && $program_avg !== null ? round($program_avg) : null;
                            $data->has_program_average = ($data->program_average !== null);

                            // 2. Program Courses Count
                            $data->program_active_courses = count($program_course_ids);
                        } else {
                            $data->program_active_courses = 0;
                            $data->has_program_average = false;
                        }

                        $data->program_mentee_count = count($filtered_mentee_ids);

                        // 3. Mentee Performance Chart Data
                        $chart_labels = [];
                        $chart_data_grades = [];

                        if (!empty($program_course_ids)) {
                            foreach ($filtered_mentee_ids as $uid) {
                                if (isset($all_mentees[$uid])) {
                                    $fullname = fullname($all_mentees[$uid]);
                                    $chart_labels[] = explode(' ', $fullname); // Array for multiline label

                                    // Calculate average just for this mentee in the program's courses
                                    $sql_mentee_avg = "SELECT AVG((gg.finalgrade / gi.grademax) * 100) AS average
                                                  FROM {grade_grades} gg
                                                  JOIN {grade_items} gi ON gi.id = gg.itemid
                                                 WHERE gg.userid = ?
                                                   AND gi.courseid $cinsql
                                                   AND gi.itemtype = 'course'
                                                   AND gg.finalgrade IS NOT NULL
                                                   AND gi.grademax > 0";
                                    $params_mentee_avg = array_merge([$uid], $cinparams);
                                    $mentee_avg = $DB->get_field_sql($sql_mentee_avg, $params_mentee_avg);

                                    $chart_data_grades[] = $mentee_avg !== false && $mentee_avg !== null ? round($mentee_avg) : 0;
                                }
                            }
                        }

                        $data->program_chart_labels = json_encode($chart_labels);
                        $data->program_chart_grades = json_encode($chart_data_grades);
                    }
                }
            }

            // Build the mentee dropdown with the filtered mentees
            $data->mentees = [];
            $data->selectedmenteename = '';
            $allmenteesurlparams = ['role' => 'parent'];
            if (!empty($selectedprogram)) {
                $allmenteesurlparams['program'] = $selectedprogram;
            }
            $data->allmenteesurl = (new moodle_url('/local/smartdashboard/index.php', $allmenteesurlparams))->out(false);

            foreach ($filtered_mentee_ids as $uid) {
                if (isset($all_mentees[$uid])) {
                    $m = $all_mentees[$uid];
                    $urlparams = ['role' => 'parent', 'viewuser' => $m->id];
                    if (!empty($selectedprogram)) {
                        $urlparams['program'] = $selectedprogram;
                    }
                    $selected = ($m->id == $this->targetuserid);
                    if ($selected) {
                        $data->selectedmenteename = fullname($m);
                    }
                    $data->mentees[] = [
                        'id' => $m->id,
                        'fullname' => fullname($m),
                        'selected' => $selected,
                        'url' => (new moodle_url('/local/smartdashboard/index.php', $urlparams))->out(false),
                    ];
                }
            }
            $data->hasmentees = !empty($data->mentees);
        }

        // Dynamic title.
        $data->dashboardtitle = $this->isprivileged
            ? 'Admin / Manager Dashboard'
            : $data->userfullname;

        // Check for specific student view.
        if ($data->isparent && !$data->has_target_mentee) {
            $data->showparentoverview = true;
            $data->overviewmentees = [];
            // Fetch mentees
            if (!empty($filtered_mentee_ids)) {
                [$insql2, $inparams2] = $DB->get_in_or_equal($filtered_mentee_ids);
                $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.picture, u.imagealt
                          FROM {user} u
                          JOIN {context} ctx ON ctx.instanceid = u.id AND ctx.contextlevel = ?
                          JOIN {role_assignments} ra ON ra.contextid = ctx.id
                          JOIN {role} r ON r.id = ra.roleid
                         WHERE ra.userid = ?
                           AND u.id $insql2
                           AND r.shortname = 'parent'
                           AND u.deleted = 0
                           AND u.suspended = 0";

                $params = array_merge([
                    CONTEXT_USER,
                    $USER->id,
                ], $inparams2);

                $mentees = $DB->get_records_sql($sql, $params);
            } else {
                $mentees = [];
            }

            foreach ($mentees as $mentee) {
                $menteeuser = \core_user::get_user($mentee->id);
                if ($menteeuser) {
                    $userpicture = new \user_picture($menteeuser);
                    $userpicture->size = 1; // Large size
                    // 1. Overall Average
                    $sql_avg = "SELECT AVG((gg.finalgrade / gi.grademax) * 100) AS average
                                  FROM {grade_grades} gg
                                  JOIN {grade_items} gi ON gi.id = gg.itemid
                                  JOIN {user_enrolments} ue ON ue.userid = gg.userid
                                  JOIN {enrol} e ON e.id = ue.enrolid AND e.courseid = gi.courseid
                                 WHERE gg.userid = :userid
                                   AND gi.itemtype = 'course'
                                   AND gg.finalgrade IS NOT NULL
                                   AND gi.grademax > 0";
                    $average = $DB->get_field_sql($sql_avg, ['userid' => $mentee->id]);
                    $overall_average = $average !== false && $average !== null ? round($average) : null;

                    // 2. Upcoming Deadlines
                    $now = time();
                    $sql_events = "SELECT e.id, e.name, e.timestart, e.courseid, c.shortname as courseshortname
                                     FROM {event} e
                                     JOIN {course} c ON c.id = e.courseid
                                     JOIN {enrol} en ON en.courseid = c.id
                                     JOIN {user_enrolments} ue ON ue.enrolid = en.id
                                    WHERE ue.userid = :userid
                                      AND e.timestart > :now
                                      AND e.eventtype IN ('due', 'close') 
                                 ORDER BY e.timestart ASC";
                    $upcomingevents = $DB->get_records_sql($sql_events, ['userid' => $mentee->id, 'now' => $now], 0, 2);
                    $deadlines = [];
                    foreach ($upcomingevents as $ev) {
                        $deadlines[] = [
                            'name' => format_string($ev->name),
                            'coursename' => format_string($ev->courseshortname),
                            'formattedtime' => userdate($ev->timestart, get_string('strftimedateshort', 'langconfig')),
                        ];
                    }

                    // 3. Recent Results
                    $sql_results = "SELECT gg.id, gi.itemname, gi.courseid, c.shortname as courseshortname, gg.finalgrade, gi.grademax, gg.timemodified
                                      FROM {grade_grades} gg
                                      JOIN {grade_items} gi ON gi.id = gg.itemid
                                      JOIN {course} c ON c.id = gi.courseid
                                     WHERE gg.userid = :userid
                                       AND gi.itemtype = 'mod'
                                       AND gg.finalgrade IS NOT NULL
                                       AND gi.hidden = 0
                                       AND gg.hidden = 0
                                  ORDER BY gg.timemodified DESC";
                    $recentgrades = $DB->get_records_sql($sql_results, ['userid' => $mentee->id], 0, 2);
                    $results = [];
                    foreach ($recentgrades as $rg) {
                        if ($rg->grademax > 0) {
                            $percent = round(($rg->finalgrade / $rg->grademax) * 100);
                            $results[] = [
                                'name' => format_string($rg->itemname),
                                'coursename' => format_string($rg->courseshortname),
                                'grade' => $percent . '%',
                            ];
                        }
                    }

                    $data->overviewmentees[] = [
                        'id' => $mentee->id,
                        'fullname' => fullname($menteeuser),
                        'profileurl' => $userpicture->get_url($PAGE)->out(false),
                        'has_average' => $overall_average !== null,
                        'average' => $overall_average,
                        'has_deadlines' => !empty($deadlines),
                        'deadlines' => array_values($deadlines),
                        'has_results' => !empty($results),
                        'results' => array_values($results),
                        'overviewurl' => (new moodle_url('/local/smartdashboard/index.php', ['role' => 'parent', 'viewuser' => $mentee->id]))->out(false),
                    ];
                }
            }
            $data->hasoverviewmentees = !empty($data->overviewmentees);
        } else if ($data->isparent && $data->has_target_mentee) {
            // Generate Grade Progression Data for the specific mentee
            $sql_prog = "SELECT gg.id, gg.timemodified, gg.finalgrade, gi.grademax
                      FROM {grade_grades} gg
                      JOIN {grade_items} gi ON gi.id = gg.itemid
                     WHERE gg.userid = ?
                       AND gg.finalgrade IS NOT NULL
                       AND gi.grademax > 0
                     ORDER BY gg.timemodified ASC";
            $grades = $DB->get_records_sql($sql_prog, [$this->targetuserid]);

            $progression_data = [];
            foreach ($grades as $g) {
                if ($g->timemodified > 0) {
                    $month_year = userdate($g->timemodified, '%b %Y'); // e.g. "Jul 2026"
                    if (!isset($progression_data[$month_year])) {
                        $progression_data[$month_year] = ['sum' => 0, 'count' => 0];
                    }
                    $percentage = ($g->finalgrade / $g->grademax) * 100;
                    $progression_data[$month_year]['sum'] += $percentage;
                    $progression_data[$month_year]['count']++;
                }
            }

            $labels = [];
            $data_points = [];
            foreach ($progression_data as $my => $d) {
                $labels[] = $my;
                $data_points[] = round($d['sum'] / $d['count']);
            }

            $data->mentee_progression_labels = json_encode($labels);
            $data->mentee_progression_grades = json_encode($data_points);
            $data->has_mentee_progression = !empty($labels);

            // Generate Subject Mastery (Radar Chart) Data
            $sql_radar = "SELECT cc.id, cc.name, AVG((gg.finalgrade / gi.grademax) * 100) AS average
                          FROM {grade_grades} gg
                          JOIN {grade_items} gi ON gi.id = gg.itemid
                          JOIN {course} c ON c.id = gi.courseid
                          JOIN {course_categories} cc ON cc.id = c.category
                         WHERE gg.userid = ?
                           AND gg.finalgrade IS NOT NULL
                           AND gi.grademax > 0
                         GROUP BY cc.id, cc.name";
            $radar_data = $DB->get_records_sql($sql_radar, [$this->targetuserid]);

            $radar_labels = [];
            $radar_grades = [];
            foreach ($radar_data as $r) {
                $radar_labels[] = format_string($r->name);
                $radar_grades[] = round($r->average);
            }

            $data->mentee_radar_labels = json_encode($radar_labels);
            $data->mentee_radar_grades = json_encode($radar_grades);
            $data->has_mentee_radar = !empty($radar_labels);
        }

        // --- Fetch announcements ---
        global $DB, $USER;
        $activeannouncements = [];
        $data->hasannouncements = false;

        $courseids = [SITEID]; // Include site news
        $usercourses = enrol_get_users_courses($this->targetuserid, true);
        if ($usercourses) {
            foreach ($usercourses as $c) {
                $courseids[] = $c->id;
            }
        }
        if (!empty($this->coursesinput)) {
            foreach ($this->coursesinput as $c) {
                $courseids[] = $c->id;
            }
        }
        $courseids = array_unique($courseids);

        if (!empty($courseids)) {
            [$insql, $params] = $DB->get_in_or_equal($courseids);

            // Get past 30 days to exclude outdated
            $recent = time() - (30 * 86400);
            $params[] = $recent;

            $sql = "SELECT d.id, d.name AS discussion_name, d.course, p.created, p.message, c.fullname AS coursename, f.id AS forumid
                      FROM {forum_discussions} d
                      JOIN {forum} f ON f.id = d.forum
                      JOIN {forum_posts} p ON p.discussion = d.id
                      JOIN {course} c ON c.id = d.course
                     WHERE f.type = 'news'
                       AND d.course $insql
                       AND p.parent = 0
                       AND p.created > ?
                  ORDER BY p.created DESC";

            try {
                $announcements = $DB->get_records_sql($sql, $params);

                // Get dismissed IDs from user preference
                $dismissedpref = get_user_preferences('local_smartdashboard_dismissed_announcements', '');
                $dismissedids = $dismissedpref ? explode(',', $dismissedpref) : [];
                $data->dismissed_pref = $dismissedpref;

                foreach ($announcements as $ann) {
                    if (!in_array($ann->id, $dismissedids)) {
                        $ann->formatteddate = userdate($ann->created, get_string('strftimedate', 'langconfig'));

                        // We must format message for display
                        $ann->message = format_text($ann->message, FORMAT_HTML);

                        $activeannouncements[] = $ann;
                    }
                }
            } catch (\Throwable $e) {
                debugging("Error fetching announcements: " . $e->getMessage());
            }
        }

        $data->announcements = array_values($activeannouncements);
        $data->hasannouncements = !empty($activeannouncements);
        // --- End of announcements ---

        if ($data->isstudent) {
            // Get user profile for welcome banner.
            $userpicture = new \user_picture($USER);
            $userpicture->size = 1; // Large size (100px).
            $data->userprofileurl = $userpicture->get_url($PAGE)->out(false);
            $data->userfullname = fullname($USER);
            $data->welcomebackstudent = \get_string('welcomebackstudent', 'local_smartdashboard', $data->userfullname);

            // Get configured icons.
            $studenticons = [];
            for ($i = 1; $i <= 10; $i++) {
                $name = \get_config('local_smartdashboard', 'icon_name_' . $i);
                $class = \get_config('local_smartdashboard', 'icon_class_' . $i);
                $url = \get_config('local_smartdashboard', 'icon_url_' . $i);

                if (!empty($name)) {
                    $studenticons[] = [
                        'name' => $name,
                        'iconclass' => $class ?: 'fa-circle-o',
                        'url' => $url ?: '#',
                    ];
                }
            }
            $data->studenticons = $studenticons;
            $data->hasstudenticons = !empty($studenticons);

            // --- Student Overview: My Courses with Progress ---
            $studentcourses = enrol_get_users_courses($this->targetuserid, true, 'id, fullname, shortname, summary, visible, category');
            $data->studentcourses = [];

            foreach ($studentcourses as $sc) {
                $coursecontext = \context_course::instance($sc->id);

                // Ensure completionlib is loaded before instantiating completion_info
                global $CFG;
                require_once($CFG->libdir . '/completionlib.php');

                // Get course completion info.
                $completioninfo = new \completion_info(get_course($sc->id));
                $progresspercent = null;

                if ($completioninfo->is_enabled()) {
                    $progresspercent = \core_completion\progress::get_course_progress_percentage(
                        get_course($sc->id),
                        $this->targetuserid
                    );
                    $progresspercent = $progresspercent !== null ? floor($progresspercent) : 0;
                }

                // Get course image.
                $imageurl = '';
                $fs = \get_file_storage();
                $files = $fs->get_area_files(
                    $coursecontext->id,
                    'course',
                    'overviewfiles',
                    0,
                    'sortorder, itemid, filepath, filename',
                    false
                );
                foreach ($files as $file) {
                    if ($file->is_valid_image()) {
                        $imageurl = moodle_url::make_pluginfile_url(
                            $file->get_contextid(),
                            $file->get_component(),
                            $file->get_filearea(),
                            $file->get_itemid(),
                            $file->get_filepath(),
                            $file->get_filename()
                        )->out(false);
                        break;
                    }
                }

                // Progress bar color class.
                $progressclass = 'bg-danger';
                $progresstextclass = 'text-danger';
                if ($progresspercent !== null && $progresspercent >= 70) {
                    $progressclass = 'bg-success';
                    $progresstextclass = 'text-success';
                } else if ($progresspercent !== null && $progresspercent >= 40) {
                    $progressclass = 'bg-warning';
                    $progresstextclass = 'text-warning';
                }

                // Get next deadline for this specific course.
                $now = time();
                $nextdeadline = $DB->get_record_sql("
                    SELECT id, name, timestart 
                      FROM {event} 
                     WHERE courseid = :courseid 
                       AND timestart > :now 
                       AND eventtype IN ('due', 'close', 'expectcompletionon')
                  ORDER BY timestart ASC", ['courseid' => $sc->id, 'now' => $now], IGNORE_MULTIPLE);

                $nextduetext = '';
                if ($nextdeadline) {
                    $daysuntil = ceil(($nextdeadline->timestart - $now) / DAYSECS);
                    if ($daysuntil == 0) {
                        $nextduetext = \get_string('due_today', 'local_smartdashboard');
                    } else {
                        $nextduetext = $daysuntil . ' days left';
                    }
                    $nextduetext = format_string($nextdeadline->name) . ' - ' . $nextduetext;
                }

                $data->studentcourses[] = [
                    'id' => $sc->id,
                    'fullname' => format_string($sc->fullname),
                    'shortname' => format_string($sc->shortname),
                    'viewurl' => (new moodle_url('/course/view.php', ['id' => $sc->id]))->out(false),
                    'hasprogress' => ($progresspercent !== null),
                    'progresspercent' => $progresspercent ?? 0,
                    'progressclass' => $progressclass,
                    'progresstextclass' => $progresstextclass,
                    'nextduetext' => $nextduetext,
                    'hasnextdue' => !empty($nextduetext),
                ];
            }
            $data->hasstudentcourses = !empty($data->studentcourses);

            // If no enrolled courses, fetch site categories and top courses as a simple catalog
            if (!$data->hasstudentcourses) {
                $data->showsitecatalog = true;
                $catalog = [];

                // Fetch all visible courses for client-side filtering.
                $sql = "SELECT c.* 
                          FROM {course} c 
                         WHERE c.id != :siteid AND c.visible = 1 
                      ORDER BY c.timemodified DESC";
                $courses = $DB->get_records_sql($sql, ['siteid' => SITEID]);
                $allcategories = $DB->get_records('course_categories', ['visible' => 1], 'sortorder ASC', 'id, name, parent');
                $catpaths = [];
                foreach ($allcategories as $cat) {
                    $path = '/' . $cat->id . '/';
                    $current = $cat;
                    while ($current->parent != 0 && isset($allcategories[$current->parent])) {
                        $current = $allcategories[$current->parent];
                        $path = '/' . $current->id . $path;
                    }
                    $catpaths[$cat->id] = $path;
                }

                $topcategories = [];
                $json_categories = [];
                foreach ($allcategories as $cat) {
                    if ($cat->parent == 0) {
                        $topcategories[] = ['id' => $cat->id, 'name' => format_string($cat->name)];
                    }
                    $json_categories[] = [
                        'id' => $cat->id,
                        'name' => format_string($cat->name),
                        'parent' => $cat->parent,
                    ];
                }
                $data->categories_json = json_encode($json_categories);
                $data->topcategories = $topcategories;
                $sitedata_teachers = [];
                $sitedata_programs = [];
                if (!empty($courses)) {
                    $hasdeletion = $DB->get_manager()->field_exists('course_modules', 'deletioninprogress');

                    foreach ($courses as $course) {
                        $coursecontext = \context_course::instance($course->id);

                        $imageurl = '';
                        $courseobj = new \core_course_list_element($course);
                        foreach ($courseobj->get_course_overviewfiles() as $file) {
                            if ($file->is_valid_image()) {
                                $imageurl = \moodle_url::make_pluginfile_url(
                                    $file->get_contextid(),
                                    $file->get_component(),
                                    $file->get_filearea(),
                                    null,
                                    $file->get_filepath(),
                                    $file->get_filename()
                                )->out(false);
                                break;
                            }
                        }
                        $isfallback = false;
                        if (empty($imageurl)) {
                            global $OUTPUT;
                            $imageurl = $OUTPUT->image_url('i/course')->out(false);
                            $isfallback = true;
                        }

                        $enrolledcount = \count_enrolled_users($coursecontext);

                        $cmsql = "SELECT COUNT(cm.id) FROM {course_modules} cm WHERE cm.course = :courseid";
                        if ($hasdeletion) {
                            $cmsql .= " AND cm.deletioninprogress = 0";
                        }
                        $activitycount = $DB->count_records_sql($cmsql, ['courseid' => $course->id]);

                        $categoryname = '';
                        $categorypath = '';
                        $categoryid = 0;
                        if (!empty($course->category)) {
                            $categoryid = $course->category;
                            if (isset($catpaths[$categoryid])) {
                                $categorypath = $catpaths[$categoryid];
                            }
                            if (isset($allcategories[$categoryid])) {
                                $categoryname = format_string($allcategories[$categoryid]->name);
                            }
                        }

                        $lastupdated = userdate($course->timemodified, '%d %b %Y');

                        $skillitems = [];
                        $hasskills = false;
                        if (class_exists('\\core_customfield\\handler')) {
                            try {
                                $handler = \core_customfield\handler::get_handler('core_course', 'course');
                                $datas = $handler->get_instance_data($course->id);
                                foreach ($datas as $cdata) {
                                    $field = $cdata->get_field();
                                    $shortname = strtolower($field->get('shortname'));
                                    if (strpos($shortname, 'skill') !== false || strpos($shortname, 'learn') !== false || strpos($shortname, 'objective') !== false) {
                                        $value = $cdata->get_value();
                                        if (empty($value)) {
                                            $value = (string) $cdata->export_value();
                                        }
                                        $plainvalue = trim(strip_tags((string)$value));
                                        if (!empty($plainvalue)) {
                                            $rawhtml = $value;
                                            if (preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $rawhtml, $matches)) {
                                                foreach ($matches[1] as $item) {
                                                    $clean = trim(strip_tags($item));
                                                    if (!empty($clean)) {
                                                        $skillitems[] = ['text' => $clean];
                                                    }
                                                }
                                            } else {
                                                $lines = preg_split('/(<br\s*\/?>|\n|\r\n)/', strip_tags($rawhtml, '<br>'), -1, PREG_SPLIT_NO_EMPTY);
                                                foreach ($lines as $line) {
                                                    $clean = trim(strip_tags($line));
                                                    $clean = ltrim($clean, '•·\-\*– ');
                                                    $clean = trim($clean);
                                                    if (!empty($clean)) {
                                                        $skillitems[] = ['text' => $clean];
                                                    }
                                                }
                                            }
                                            $hasskills = !empty($skillitems);
                                            break;
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                            }
                        }

                        $popupcontent = '';
                        if (!$hasskills) {
                            $popupcontent = \format_text($course->summary, \FORMAT_HTML, ['context' => $coursecontext]);
                        }

                        $tsql = "SELECT u.*
                                FROM {user} u
                                JOIN {role_assignments} ra ON ra.userid = u.id
                                JOIN {role} r ON r.id = ra.roleid
                                WHERE ra.contextid = :contextid
                                AND r.shortname IN ('editingteacher', 'teacher')
                                AND u.deleted = 0 AND u.suspended = 0
                                ORDER BY r.sortorder ASC, u.lastname ASC, u.firstname ASC";

                        $courseteachers = [];
                        $teacherids = [];
                        if ($teacherrecords = $DB->get_records_sql($tsql, ['contextid' => $coursecontext->id], 0, 3)) {
                            foreach ($teacherrecords as $tr) {
                                $upic = new \user_picture($tr);
                                $upic->size = 100;
                                $courseteachers[] = [
                                    'id' => $tr->id,
                                    'name' => fullname($tr),
                                    'imageurl' => $upic->get_url($PAGE)->out(false),
                                ];
                                $sitedata_teachers[$tr->id] = ['id' => $tr->id, 'name' => fullname($tr)];
                                $teacherids[] = $tr->id;
                            }
                        }

                        $programids = [];
                        if ($DB->get_manager()->table_exists('tool_muprog_program') && $DB->get_manager()->table_exists('tool_muprog_item')) {
                            try {
                                $psql = "SELECT p.id, p.fullname FROM {tool_muprog_program} p
                                         JOIN {tool_muprog_item} pi ON pi.programid = p.id
                                         WHERE pi.type = 'course' AND pi.courseid = :courseid AND p.archived = 0";
                                if ($course_programs = $DB->get_records_sql($psql, ['courseid' => $course->id])) {
                                    foreach ($course_programs as $cp) {
                                        $sitedata_programs[$cp->id] = ['id' => $cp->id, 'name' => format_string($cp->fullname)];
                                        $programids[] = $cp->id;
                                    }
                                }
                            } catch (\Exception $e) {
                            }
                        }

                        $catalog[] = [
                            'id' => $course->id,
                            'name' => \format_string($course->fullname, true, ['context' => $coursecontext]),
                            'description' => \format_text($course->summary, \FORMAT_HTML, ['context' => $coursecontext]),
                            'imageurl' => $imageurl,
                            'teacherids' => implode(',', $teacherids),
                            'programids' => implode(',', $programids),
                            'isfallback' => $isfallback,
                            'enrolledcount' => $enrolledcount,
                            'lastupdated' => $lastupdated,
                            'activitycount' => $activitycount,
                            'categoryid' => $categoryid,
                            'categorypath' => $categorypath,
                            'categoryname' => $categoryname,
                            'hasskills' => $hasskills,
                            'skillitems' => $skillitems,
                            'popupcontent' => $popupcontent,
                            'teachers' => $courseteachers,
                        ];
                    }
                }

                usort($sitedata_teachers, function ($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                $data->siteteachers = array_values($sitedata_teachers);
                if ($DB->get_manager()->table_exists('tool_muprog_item')) {
                    usort($sitedata_programs, function ($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    });
                    $data->siteprograms = array_values($sitedata_programs);
                    $data->hasprograms = !empty($sitedata_programs);
                } else {
                    $data->hasprograms = false;
                }

                $data->sitecatalog = $catalog;
                $data->hassitecatalog = !empty($catalog);
            }

            // --- Student Overview: Upcoming Deadlines ---
            $now = time();
            $startofday = strtotime('today midnight');
            $twoweeks = $now + (14 * DAYSECS);

            $sql = "SELECT e.id, e.name, e.timestart, e.courseid, e.modulename,
                           c.shortname AS courseshortname, c.fullname AS coursefullname
                      FROM {event} e
                      JOIN {course} c ON c.id = e.courseid
                      JOIN {enrol} en ON en.courseid = c.id
                      JOIN {user_enrolments} ue ON ue.enrolid = en.id
                     WHERE ue.userid = :userid
                       AND e.timestart >= :startofday
                       AND e.timestart < :twoweeks
                       AND e.eventtype IN ('due', 'close', 'expectcompletionon')
                  ORDER BY e.timestart ASC";
            $events = $DB->get_records_sql($sql, [
                'userid' => $this->targetuserid,
                'startofday' => $startofday,
                'twoweeks' => $twoweeks,
            ], 0, 7);

            $data->studentdeadlines = [];
            foreach ($events as $ev) {
                $daysuntil = ceil(($ev->timestart - $now) / DAYSECS);

                // Urgency classification.
                if ($daysuntil <= 1) {
                    $urgencyclass = 'danger';
                    $urgencylabel = \get_string('due_today', 'local_smartdashboard');
                } else if ($daysuntil <= 3) {
                    $urgencyclass = 'warning';
                    $urgencylabel = \get_string('student_due_soon', 'local_smartdashboard', $daysuntil);
                } else {
                    $urgencyclass = 'secondary';
                    $urgencylabel = userdate($ev->timestart, \get_string('strftimedateshort', 'langconfig'));
                }

                $data->studentdeadlines[] = [
                    'name' => format_string($ev->name),
                    'coursename' => format_string($ev->courseshortname),
                    'urgencyclass' => $urgencyclass,
                    'urgencylabel' => $urgencylabel,
                    'daysuntil' => $daysuntil,
                    'isurgent' => ($daysuntil <= 1),
                    'formatteddate' => userdate($ev->timestart, \get_string('strftimedateshort', 'langconfig')),
                ];
            }
            $data->hasstudentdeadlines = !empty($data->studentdeadlines);

            // --- Student Overview: My Grades ---
            $sql = "SELECT gi.courseid, c.shortname AS courseshortname, c.fullname AS coursefullname,
                           gg.finalgrade, gi.grademax, gi.grademin
                      FROM {grade_grades} gg
                      JOIN {grade_items} gi ON gi.id = gg.itemid
                      JOIN {course} c ON c.id = gi.courseid
                     WHERE gg.userid = :userid
                       AND gi.itemtype = 'course'
                       AND gg.finalgrade IS NOT NULL
                       AND gi.hidden = 0
                       AND gg.hidden = 0
                       AND gi.grademax > 0
                  ORDER BY c.fullname ASC";
            $grades = $DB->get_records_sql($sql, ['userid' => $this->targetuserid]);

            $data->studentgrades = [];
            $totalpercentage = 0;
            $gradecount = 0;
            $failing_courses = 0;

            foreach ($grades as $g) {
                $percent = round(($g->finalgrade / $g->grademax) * 100);
                $gradeclass = 'text-danger';
                $lettergrade = 'F';

                if ($percent >= 90) {
                    $gradeclass = 'text-success';
                    $lettergrade = 'A';
                } else if ($percent >= 85) {
                    $gradeclass = 'text-success';
                    $lettergrade = 'A-';
                } else if ($percent >= 80) {
                    $gradeclass = 'text-primary';
                    $lettergrade = 'B+';
                } else if ($percent >= 75) {
                    $gradeclass = 'text-primary';
                    $lettergrade = 'B';
                } else if ($percent >= 70) {
                    $gradeclass = 'text-primary';
                    $lettergrade = 'B-';
                } else if ($percent >= 65) {
                    $gradeclass = 'text-warning';
                    $lettergrade = 'C+';
                } else if ($percent >= 60) {
                    $gradeclass = 'text-warning';
                    $lettergrade = 'C';
                } else if ($percent >= 50) {
                    $gradeclass = 'text-warning';
                    $lettergrade = 'D';
                } else {
                    $failing_courses++;
                }

                $data->studentgrades[] = [
                    'coursename' => format_string($g->courseshortname),
                    'coursefullname' => format_string($g->coursefullname),
                    'percent' => $percent,
                    'lettergrade' => $lettergrade,
                    'gradeclass' => $gradeclass,
                ];

                $totalpercentage += $percent;
                $gradecount++;
            }
            $data->hasstudentgrades = !empty($data->studentgrades);
            $data->studentoverall = $gradecount > 0 ? round($totalpercentage / $gradecount) : null;
            $data->hasoverall = ($data->studentoverall !== null);

            // --- Student Overview: Recent Feedback ---
            $sql = "SELECT gg.id, gg.finalgrade, gg.feedback, gg.timemodified,
                           gi.itemname, gi.itemmodule, gi.grademax,
                           c.shortname AS courseshortname
                      FROM {grade_grades} gg
                      JOIN {grade_items} gi ON gi.id = gg.itemid
                      JOIN {course} c ON c.id = gi.courseid
                     WHERE gg.userid = :userid
                       AND gg.finalgrade IS NOT NULL
                       AND gi.hidden = 0
                       AND gg.hidden = 0
                       AND gi.itemtype = 'mod'
                  ORDER BY gg.timemodified DESC";
            $recentfeedback = $DB->get_records_sql($sql, ['userid' => $this->targetuserid], 0, 4);

            $data->studentfeedback = [];
            foreach ($recentfeedback as $rf) {
                $itemname = !empty($rf->itemname) ? $rf->itemname : \get_string('modulename', $rf->itemmodule);
                $percent = 0;
                if ($rf->grademax > 0) {
                    $percent = round(($rf->finalgrade / $rf->grademax) * 100);
                }

                $gradeclass = 'text-primary';
                if ($percent >= 80) {
                    $gradeclass = 'text-success';
                } else if ($percent < 50) {
                    $gradeclass = 'text-danger';
                }

                $feedbacktext = '';
                if (!empty(trim($rf->feedback ?? ''))) {
                    $feedbacktext = format_text(strip_tags($rf->feedback), FORMAT_PLAIN);
                }

                $data->studentfeedback[] = [
                    'itemname' => format_string($itemname),
                    'coursename' => format_string($rf->courseshortname),
                    'percent' => $percent,
                    'gradeclass' => $gradeclass,
                    'hasfeedback' => !empty($feedbacktext),
                    'feedback' => $feedbacktext,
                ];
            }
            $data->hasstudentfeedback = !empty($data->studentfeedback);

            // KPI Data for student overview
            $data->studentkpicourses = count($data->studentcourses);
            $data->hasurgentdeadline = false;
            $data->urgentdeadlinetext = \get_string('student_none', 'local_smartdashboard');
            if (!empty($data->studentdeadlines)) {
                $firstdeadline = $data->studentdeadlines[0];
                $data->hasurgentdeadline = true;
                $data->urgentdeadlinetext = $firstdeadline['isurgent'] ? \get_string('due_today', 'local_smartdashboard') : \get_string('student_due_soon', 'local_smartdashboard', $firstdeadline['daysuntil']);
            }

            // --- Student Overview: Grade Details (from report_studentgrades) ---
            $data->enableinstantanalysis = true; // Temporary default, later fetch from config if needed.
            $data->userid = $this->targetuserid;

            // Check if AI grades table exists before querying to prevent error during first load before install
            $dbman = $DB->get_manager();
            $history = [];
            if ($dbman->table_exists('local_smartdashboard_ai_grades')) {
                $past_analyses = $DB->get_records('local_smartdashboard_ai_grades', ['userid' => $this->targetuserid], 'timecreated DESC');
                if ($past_analyses) {
                    $index = 0;
                    foreach ($past_analyses as $pa) {
                        $history[] = [
                            'id' => $pa->id,
                            'date' => userdate($pa->timecreated),
                            'content' => $pa->report_html,
                            'expanded' => ($index === 0) ? 'true' : 'false',
                            'show' => ($index === 0) ? 'show' : '',
                        ];
                        $index++;
                    }
                }
            }
            $data->history = $history;
            $data->hashistory = !empty($history);

            require_once(__DIR__ . '/../grades_exporter.php');
            $exporter = new \local_smartdashboard\grades_exporter($this->targetuserid, false);
            $data->inlinegrades = $exporter->get_inline_grades_html();
        }

        // --- User Profile Header Data (For all users) ---
        $target_user_obj = ($this->targetuserid != $USER->id) ? $DB->get_record('user', ['id' => $this->targetuserid]) : $USER;
        $userpicture = new \user_picture($target_user_obj);
        $userpicture->size = 1;
        $data->studentfirstname = $target_user_obj->firstname;
        $data->studentprofileurl = $userpicture->get_url($PAGE)->out(false);
        $data->studentcurrentdate = date('M j, Y');

        // Streak and Gamification Data
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $last_streak_date = get_user_preferences('local_smartdashboard_last_streak_date', '', $this->targetuserid);
        $streak_count = (int) get_user_preferences('local_smartdashboard_streak_count', 0, $this->targetuserid);

        if ($last_streak_date !== $today) {
            if ($last_streak_date === $yesterday) {
                $streak_count++;
            } else {
                $streak_count = 1;
            }
            // Only update the preference if the user is viewing their own dashboard
            if ($this->targetuserid == $USER->id) {
                set_user_preference('local_smartdashboard_last_streak_date', $today);
                set_user_preference('local_smartdashboard_streak_count', $streak_count);
            }
        }

        $data->studentstreak = $streak_count;

        // Generate 7-day heatmap data using actual Moodle log data
        global $DB;
        $now = time();
        $start_of_today = strtotime('today', $now);
        $six_days_ago = $start_of_today - (6 * DAYSECS); // Get past 7 days including today

        // Initialize array with 0 actions for last 7 days
        $activity_counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $day_start = $start_of_today - ($i * DAYSECS);
            $day_key = date('Y-m-d', $day_start);
            $activity_counts[$day_key] = [
                'day_name' => date('D', $day_start),
                'date_label' => date('M j', $day_start),
                'count' => 0,
            ];
        }

        // Fetch logs if standard log store is available
        if ($DB->get_manager()->table_exists('logstore_standard_log')) {
            $sql = "SELECT id, timecreated FROM {logstore_standard_log} 
                     WHERE userid = :userid AND timecreated >= :starttime";
            try {
                $logs = $DB->get_recordset_sql($sql, ['userid' => $this->targetuserid, 'starttime' => $six_days_ago]);
                foreach ($logs as $log) {
                    $day_key = date('Y-m-d', $log->timecreated);
                    if (isset($activity_counts[$day_key])) {
                        $activity_counts[$day_key]['count']++;
                    }
                }
                $logs->close();
            } catch (\Exception $e) {
                // Ignore if log store not readable
            }
        }

        $max_count = 0;
        foreach ($activity_counts as $ac) {
            if ($ac['count'] > $max_count) {
                $max_count = $ac['count'];
            }
        }

        $data->studentheatmap = [];
        $total_interactions = 0;

        foreach ($activity_counts as $day_key => $ac) {
            $total_interactions += $ac['count'];
            $count = $ac['count'];

            // Gradient from pale yellow to strong red
            $textcolor = '#333';
            if ($count == 0) {
                $color = '#fffde7'; // extremely pale yellow / off-white
            } else {
                $ratio = $max_count > 0 ? ($count / $max_count) : 0;
                if ($ratio <= 0.25) {
                    $color = '#fff59d'; // light yellow
                } else if ($ratio <= 0.50) {
                    $color = '#ffb74d'; // orange-yellow
                } else if ($ratio <= 0.75) {
                    $color = '#ff7043'; // orange-red
                } else {
                    $color = '#d32f2f'; // strong red
                    $textcolor = '#fff';
                }
            }

            $act_label = ($count == 1) ? 'activity' : 'activities';
            $tooltip = "{$ac['day_name']} ({$ac['date_label']}): {$count} {$act_label}";

            $data->studentheatmap[] = [
                'day' => $ac['day_name'],
                'date_label' => $ac['date_label'],
                'tooltip' => $tooltip,
                'color' => $color,
                'textcolor' => $textcolor,
                'count' => $count,
                'opacity' => 1, // Fully opaque, using color changes instead
            ];
        }
        $data->studenttotalinteractions = $total_interactions;

        // Ensure studentkpicourses and overall are set for non-students
        if (!isset($data->studentkpicourses)) {
            $data->studentkpicourses = $this->totalenrollments ?? 0;
        }

        // --- Gamification (Badges) for all users ---
        global $CFG;
        require_once($CFG->libdir . '/badgeslib.php');

        $userbadges = badges_get_user_badges($this->targetuserid);
        $data->studentbadges = [];
        $badgecount = 0;

        foreach ($userbadges as $badge) {
            if ($badgecount >= 6) {
                break;
            }

            $badgeid = $badge->badgeid ?? ($badge->id ?? 0);

            // Determine context ID safely without instantiating the badge class
            $contextid = $badge->badgecontextid ?? ($badge->contextid ?? 0);
            if (!$contextid) {
                if (isset($badge->type) && $badge->type == 1) { // 1 = BADGE_TYPE_SITE
                    $contextid = \context_system::instance()->id;
                } else if (!empty($badge->courseid)) {
                    $cctx = \context_course::instance($badge->courseid, IGNORE_MISSING);
                    if ($cctx) {
                        $contextid = $cctx->id;
                    }
                }
            }

            $name = $badge->name ?? '';
            $dateissued = $badge->dateissued ?? time();

            $imageurl = '';
            if ($contextid && $badgeid) {
                $imageurl = \moodle_url::make_pluginfile_url($contextid, 'badges', 'badgeimage', $badgeid, '/', 'f1', false)->out(false);
            }

            $data->studentbadges[] = [
                'name' => format_string($name),
                'imageurl' => $imageurl,
                'dateissued' => userdate($dateissued, \get_string('strftimedateshort', 'langconfig')),
            ];
            $badgecount++;
        }
        $data->hasstudentbadges = !empty($data->studentbadges);

        foreach ($this->coursesinput as $course) {
            $coursecontext = context_course::instance($course->id);

            // Double check capability just in case.
            if (!\has_capability('moodle/course:update', $coursecontext) && !\has_capability('moodle/grade:viewall', $coursecontext)) {
                continue;
            }

            // Get course image.
            $imageurl = '';

            // Robust way to get course image: check the file area directly.
            $fs = \get_file_storage();
            $files = $fs->get_area_files(
                $coursecontext->id,
                'course',
                'overviewfiles',
                0,
                'sortorder, itemid, filepath, filename',
                false // Exclude directories.
            );

            if ($files) {
                foreach ($files as $file) {
                    if ($file->is_valid_image()) {
                        $imageurl = moodle_url::make_pluginfile_url(
                            $file->get_contextid(),
                            $file->get_component(),
                            $file->get_filearea(),
                            $file->get_itemid(),
                            $file->get_filepath(),
                            $file->get_filename()
                        )->out(false);
                        break;
                    }
                }
            }

            // Get category name.
            $categoryname = '';
            if (class_exists('core_course_category')) {
                $category = \core_course_category::get($course->category, \IGNORE_MISSING);
                $categoryname = $category ? $category->get_formatted_name() : '';
            } else {
                // Fallback.
                require_once($GLOBALS['CFG']->libdir . '/coursecatlib.php');
                $category = \coursecat::get($course->category, \IGNORE_MISSING);
                $categoryname = $category ? $category->get_formatted_name() : '';
            }

            // Count students
            // Count students (users with 'student' role).
            global $DB;
            $studentcount = $DB->count_records_sql(
                "
                SELECT COUNT(DISTINCT ra.userid)
                  FROM {role_assignments} ra
                  JOIN {context} ctx ON ctx.id = ra.contextid
                  JOIN {role} r ON r.id = ra.roleid
                 WHERE ctx.contextlevel = 50
                   AND ctx.instanceid = :courseid
                   AND r.shortname = 'student'",
                ['courseid' => $course->id]
            );

            // Count submissions needing grading
            // We look for submissions that are submitted, latest, and do not have a grade (or grade < 0).
            $sql = "SELECT COUNT(s.id)
                      FROM {assign_submission} s
                      JOIN {assign} a ON a.id = s.assignment
                     WHERE a.course = :courseid
                       AND s.status = :status
                       AND s.latest = 1
                       AND NOT EXISTS (
                           SELECT 1
                             FROM {assign_grades} g
                            WHERE g.assignment = a.id
                              AND g.userid = s.userid
                              AND g.attemptnumber = s.attemptnumber
                              AND g.grade >= 0
                       )";

            $gradingcount = 0;
            try {
                global $DB; // Ensure $DB is available.
                $gradingcount = $DB->count_records_sql($sql, [
                    'courseid' => $course->id,
                    'status' => 'submitted',
                ]);
            } catch (\Exception $e) {
                // If tables don't exist (e.g. mod_assign disabled), ignore.
                debugging('Assign module may be disabled: ' . $e->getMessage());
            }

            $courseurl = new moodle_url('/course/view.php', ['id' => $course->id]);

            $data->courses[] = [
                'id' => $course->id,
                'fullname' => $course->fullname,
                'viewurl' => $courseurl->out(false),
                'imageurl' => $imageurl,
                'categoryname' => $categoryname,
                'studentcount' => $studentcount,
                'gradingcount' => $gradingcount,
                'hasgrading' => ($gradingcount > 0),
            ];
        }

        // Determine sidebar items visibility
        $data->showsidebar = true;
        $data->showgradedetails = false;

        $hasteachingcourses = !empty($data->courses);

        if ($this->isprivileged) {
            $data->showoverview = true;
            $data->showagenda = true;
            $data->showprogress = true;
            $data->showgrading = true;
            $data->showanalytics = true;
            $data->showsettings = true;
        } else if ($hasteachingcourses) {
            $iseditingteacher = false;
            foreach ($data->courses as $c) {
                if (\has_capability('moodle/course:update', \context_course::instance($c['id']))) {
                    $iseditingteacher = true;
                    break;
                }
            }

            if ($iseditingteacher) {
                // Teacher
                $data->showoverview = true;
                $data->showagenda = true;
                $data->showprogress = true;
                $data->showgrading = true;
                $data->showanalytics = true;
                $data->showsettings = true;
            } else {
                // Non-editing teacher
                $data->showoverview = true;
                $data->showagenda = false;
                $data->showprogress = true;
                $data->showgrading = true;
                $data->showanalytics = false;
                $data->showsettings = false;
            }
        } else {
            // Student
            $data->showoverview = true;
            $data->showagenda = true;
            $data->showprogress = false;
            $data->showgrading = false;
            $data->showanalytics = false;
            $data->showsettings = false;
            $data->showgradedetails = true;
        }

        // Payments and Magic reports are exclusive to Smart Dashboard Pro.
        $data->showpayment = false;
        $data->showmagic = false;

        // Theme mode (dark/light).
        $thememode = \get_config('local_smartdashboard', 'thememode') ?: 'dark';
        $data->thememode = $thememode;
        $data->isdarkmode = ($thememode === 'dark');

        // --- Calculate At-Risk Alerts and KPIs for Parent ---
        $failing = isset($failing_courses) ? $failing_courses : 0;
        $interactions = isset($total_interactions) ? $total_interactions : 0;

        $data->mentee_interactions_this_week = $interactions;
        $data->mentee_failing_courses = $failing;

        $at_risk_level = 0; // 0 = Good, 1 = Warning, 2 = Critical
        $at_risk_reasons = [];

        if ($failing > 0) {
            $at_risk_level = 2;
            $at_risk_reasons[] = $failing . ' Failing Course' . ($failing > 1 ? 's' : '');
        }

        if ($interactions == 0) {
            $at_risk_level = max($at_risk_level, 2);
            $at_risk_reasons[] = '0 Interactions This Week';
        } else if ($interactions < 5) {
            $at_risk_level = max($at_risk_level, 1);
            $at_risk_reasons[] = 'Low Weekly Engagement';
        }

        $data->mentee_at_risk_critical = ($at_risk_level == 2);
        $data->mentee_at_risk_warning = ($at_risk_level == 1);
        $data->mentee_at_risk_good = ($at_risk_level == 0);
        $data->mentee_at_risk_reason = !empty($at_risk_reasons) ? implode(', ', $at_risk_reasons) : 'On Track';

        // Get blocks for the main content region.
        $data->blocks_main = $output->blocks_for_region('content');

        return $data;
    }
}

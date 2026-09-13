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
 * Student progress tracking section module.
 *
 * @module      local_smartdashboard/sections/progress
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/ajax', 'core/notification', 'local_smartdashboard/core/utils'], function($, Ajax, Notification, Utils) {
    var ProgressTracker = {
        init: function() {
            this.container = $('#section-progress');
            this.selectedStudents = new Set();
            var self = this;
            Utils.LoadPrompt.show(this.container, 'Student Progress', 'users', function() {
                self.loadData();
            });
        },

        loadData: function() {
            var self = this;

            // Show loading
            this.container.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            // Fire all requests in parallel.
            var calls = Ajax.call([
                {methodname: 'local_smartdashboard_get_cross_course_progress', args: {}},
                {methodname: 'local_smartdashboard_get_programs', args: {}},
                {methodname: 'local_smartdashboard_get_risk_data', args: {}}
            ]);

            // Wrap programs call so failure is treated as "no programs" (graceful degradation).
            var safePrograms = $.Deferred();
            calls[1].done(function(progResponse) {
                var programs = (progResponse && progResponse.programs) ? progResponse.programs : [];
                safePrograms.resolve(programs);
            }).fail(function() {
                // Programs plugin not available — silently skip.
                safePrograms.resolve([]);
            });

            // Wrap risk call so failure is treated as "no risk data" (graceful degradation).
            var safeRisk = $.Deferred();
            calls[2].done(function(riskResponse) {
                safeRisk.resolve(riskResponse || {students: [], summary: {total: 0, high: 0, medium: 0, low: 0}});
            }).fail(function() {
                safeRisk.resolve({students: [], summary: {total: 0, high: 0, medium: 0, low: 0}});
            });

            // Wait for ALL calls before rendering anything.
            return $.when(calls[0], safePrograms.promise(), safeRisk.promise()).then(function(response, programs, riskData) {
                // Remove spinner
                self.container.find('.fa-spinner').parent().remove();

                self.allData = response;
                self.lastFilteredData = response;
                self.selectedStudents.clear();

                // Store programs and build lookup map.
                self.programs = programs || [];
                self.courseProgramMap = {};
                self.programs.forEach(function(p) {
                    if (p.courseids) {
                        p.courseids.forEach(function(cid) {
                            if (!self.courseProgramMap[cid]) {
                                self.courseProgramMap[cid] = [];
                            }
                            self.courseProgramMap[cid].push(p.id);
                        });
                    }
                });

                // Store risk data and build lookup map: userid -> highest risk record.
                self.riskData = riskData;
                self.riskMap = {};
                if (riskData && riskData.students) {
                    riskData.students.forEach(function(r) {
                        var key = r.userid;
                        if (!self.riskMap[key] || r.riskscore > self.riskMap[key].riskscore) {
                            self.riskMap[key] = r;
                        }
                    });
                }

                try {
                    self.renderFilters();
                    self.render(response);
                } catch (e) {
                    self.container.html('<div class="alert alert-danger">Render Error: ' + e.message + '</div>');
                }
            }, function(ex) {
                self.container.html('<div class="alert alert-danger">Error loading data: ' + ex.message + '</div>');
                Notification.exception(ex);
            });
        },

        /**
         * Render filter controls
         */
        renderFilters: function() {
            var self = this;
            var courses = this.allData.courses || [];
            var programs = this.programs || [];

            // Extract unique categories
            var categories = {};
            courses.forEach(function(c) {
                if (c.category && c.categoryname) {
                    categories[c.category] = c.categoryname;
                }
            });

            var html = '<div class="row mb-4 animate__animated animate__fadeIn">';

            // --- Program Filter (only shown when programs exist) ---
            if (programs.length > 0) {
                // Preserve current selection across re-renders.
                var currentProgramVal = this.container.find('#filter-program').val() || '';
                html += '<div class="col-md-6 col-lg-3 mb-2">';
                html += '<select id="filter-program" class="form-select border-0 shadow-sm">';
                html += '<option value="">All Programs</option>';
                programs.forEach(function(p) {
                    var selected = (String(p.id) === currentProgramVal) ? ' selected' : '';
                    html += '<option value="' + p.id + '"' + selected + '>' + p.fullname + '</option>';
                });
                html += '</select></div>';
            }

            // Course Filter
            var courseColClass = programs.length > 0 ? 'col-md-6 col-lg-3' : 'col-md-6 col-lg-4';
            html += '<div class="' + courseColClass + ' mb-2">';
            html += '<select id="filter-course" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Courses</option>';
            courses.forEach(function(c) {
                html += '<option value="' + c.id + '">' + c.name + '</option>';
            });
            html += '</select></div>';

            // Category Filter
            var catColClass = programs.length > 0 ? 'col-md-6 col-lg-3' : 'col-md-6 col-lg-4';
            html += '<div class="' + catColClass + ' mb-2">';
            html += '<select id="filter-category" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Categories</option>';
            for (var catId in categories) {
                html += '<option value="' + catId + '">' + categories[catId] + '</option>';
            }
            html += '</select></div>';

            // Status Filter
            var statusColClass = programs.length > 0 ? 'col-md-6 col-lg-3' : 'col-md-6 col-lg-4';
            html += '<div class="' + statusColClass + ' mb-2">';
            html += '<select id="filter-status" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Statuses</option>';
            html += '<option value="not_completed">Not Completed</option>';
            html += '<option value="completed">Completed</option>';
            html += '<option value="enrolled">Enrolled</option>';
            html += '</select></div>';

            // Risk Level Filter
            html += '<div class="col-md-6 col-lg-2 mb-2">';
            html += '<select id="filter-risk" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Risk Levels</option>';
            html += '<option value="high">🔴 At Risk</option>';
            html += '<option value="medium">🟡 Monitor</option>';
            html += '<option value="low">🟢 On Track</option>';
            html += '</select></div>';

            // Sub-category options container
            html += '<div id="subcategory-options" class="mt-2 text-muted small" style="display:none;">';
            html += '<div class="form-check form-switch">';
            html += '<input class="form-check-input" type="checkbox" id="include-subcats">';
            html += '<label class="form-check-label" for="include-subcats">Include sub-categories</label>';
            html += '</div>';
            html += '<div id="subcategory-list" class="mt-2 ms-3 border-start ps-2" style="display:none;">';
            html += '<!-- Subcategories will be populated here -->';
            html += '</div>'; // End subcategory options

            html += '</div>'; // End col

            html += '</div>'; // End row

            // Clear existing filters if re-rendering filters
            this.container.find('.row.mb-4.animate__animated.animate__fadeIn').remove();
            this.container.prepend(html);

            // Add event listeners
            this.container.find('#filter-program').on('change', function() {
                self.applyFilters();
            });

            this.container.find('#filter-course').on('change', function() {
                self.applyFilters();
            });

            this.container.find('#filter-category').on('change', function() {
                self.updateSubCategories();
                self.applyFilters();
            });

            this.container.find('#include-subcats').on('change', function() {
                self.container.find('#subcategory-list').toggle(this.checked);
                self.applyFilters();
            });

            this.container.find('#filter-status').on('change', function() {
                self.applyFilters();
            });

            this.container.find('#filter-risk').on('change', function() {
                self.applyFilters();
            });

            // Event delegation for dynamic subcategory checkboxes
            this.container.on('change', '.subcat-custom-checkbox', function() {
                self.applyFilters();
            });

            // Export Button Listener (Delegated because button is now re-rendered in render())
            this.container.off('click', '#btn-export-csv').on('click', '#btn-export-csv', function() {
                self.exportToCSV();
            });

            // --- Bulk Action Listeners ---

            // Textarea auto-resize for the modal
            $('body').on('input', '#bulk-message-body', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // 1. Select All Checkbox
            this.container.on('change', '#select-all-students', function() {
                var isChecked = $(this).is(':checked');
                var visibleStudentCheckboxes = self.container.find('.student-select-checkbox');

                visibleStudentCheckboxes.prop('checked', isChecked);

                if (isChecked) {
                    visibleStudentCheckboxes.each(function() {
                        self.selectedStudents.add($(this).val());
                    });
                } else {
                    visibleStudentCheckboxes.each(function() {
                        self.selectedStudents.delete($(this).val());
                    });
                }
                self.updateActionBar();
            });

            // 2. Individual Student Checkbox
            this.container.on('change', '.student-select-checkbox', function() {
                var studentId = $(this).val();
                if ($(this).is(':checked')) {
                    self.selectedStudents.add(studentId);
                } else {
                    self.selectedStudents.delete(studentId);
                    // Uncheck "select all" if one is unchecked
                    $('#select-all-students').prop('checked', false);
                }
                self.updateActionBar();
            });

            // 3. Send Message Button
            this.container.on('click', '#btn-bulk-message', function() {
                self.openMessageModal();
            });
        },

        updateSubCategories: function() {
            var selectedCatId = this.container.find('#filter-category').val();
            var $subOpts = this.container.find('#subcategory-options');
            var $subList = this.container.find('#subcategory-list');

            if (!selectedCatId) {
                $subOpts.hide();
                $subList.empty();
                return;
            }

            // Find potential subcategories in the dataset
            var subCats = {}; // Id -> name
            var hasSubCats = false;

            this.allData.courses.forEach(function(c) {
                // Check if course belongs to a subcategory of selectedCatId
                // Path format is /parent/child/grandchild
                // So search for '/selectedCatId/'
                if (c.categorypath && c.category != selectedCatId && c.categorypath.indexOf('/' + selectedCatId + '/') !== -1) {
                    subCats[c.category] = c.categoryname;
                    hasSubCats = true;
                }
            });

            if (hasSubCats) {
                $subOpts.show();
                var listHtml = '<h6 class="mb-1">Select Sub-categories:</h6>';
                for (var id in subCats) {
                    listHtml += '<div class="form-check">';
                    listHtml += '<input class="form-check-input subcat-custom-checkbox" type="checkbox" ';
                    listHtml += 'value="' + id + '" id="subcat-' + id + '" checked>';
                    listHtml += '<label class="form-check-label" for="subcat-' + id + '">' + subCats[id] + '</label>';
                    listHtml += '</div>';
                }
                $subList.html(listHtml);

                // Ensure visibility matches checkbox state
                var isChecked = this.container.find('#include-subcats').is(':checked');
                $subList.toggle(isChecked);

            } else {
                $subOpts.hide();
                $subList.empty();
            }
        },

        /**
         * Apply filters and re-render the content area
         */
        applyFilters: function() {
            var programId = this.container.find('#filter-program').val();
            var courseId = this.container.find('#filter-course').val();
            var catId = this.container.find('#filter-category').val();
            var status = this.container.find('#filter-status').val();
            var riskLevel = this.container.find('#filter-risk').val();
            var includeSubcats = this.container.find('#include-subcats').is(':checked');

            // Determine the set of course IDs allowed by the selected program.
            var programCourseIds = null; // Null means "no program filter"
            if (programId !== '' && this.programs && this.programs.length > 0) {
                var selectedProgram = null;
                this.programs.forEach(function(p) {
                    if (String(p.id) === String(programId)) {
                        selectedProgram = p;
                    }
                });
                if (selectedProgram) {
                    programCourseIds = {};
                    selectedProgram.courseids.forEach(function(cid) {
                        programCourseIds[cid] = true;
                    });
                }
            }

            // Get selected subcategories
            var selectedSubIds = [];
            if (includeSubcats) {
                this.container.find('.subcat-custom-checkbox:checked').each(function() {
                    selectedSubIds.push($(this).val());
                });
            }

            var filteredCourses = this.allData.courses.filter(function(c) {
                // LAYER 0: Program filter — course must belong to the selected program.
                if (programCourseIds !== null && !programCourseIds[c.id]) {
                    return false;
                }

                var matchCourse = courseId === "" || c.id == courseId;

                var matchCat = true;
                if (catId !== "") {
                    if (c.category == catId) {
                        matchCat = true; // Exact match to main category
                    } else if (includeSubcats) {
                        // Check if it matches one of the selected subcategories
                        matchCat = selectedSubIds.includes(String(c.category));
                    } else {
                        matchCat = false;
                    }
                }

                return matchCourse && matchCat;
            });

            // Helper for status filtering
            var getCompletion = function(student, courseId) {
                if (!student.completions) {
                    return null;
                }
                return student.completions.find(function(c) {
                    return c.courseid == courseId;
                });
            };

            // Filter Students based on Status in Visible Courses
            var filteredStudents = this.allData.students;
            if (status !== "") {
                filteredStudents = filteredStudents.filter(function(student) {
                    var hasMatch = false;
                    // Check if student matches status in ANY of the filtered courses
                    // Include the student if they match the criteria for AT LEAST ONE visible course.
                    filteredCourses.forEach(function(course) {
                        var comp = getCompletion(student, course.id);
                        if (comp && comp.enrolled) {
                            if (status === 'completed' && comp.completed) {
                                hasMatch = true;
                            }
                            // "Not Completed": Enrolled but NOT completed
                            if (status === 'not_completed' && !comp.completed) {
                                hasMatch = true;
                            }
                            if (status === 'enrolled') {
                                hasMatch = true;
                            }
                        }
                    });
                    return hasMatch;
                });
            }

            // Risk Level Filter
            if (riskLevel !== '' && riskLevel) {
                var riskMap = this.riskMap || {};
                filteredStudents = filteredStudents.filter(function(student) {
                    var risk = riskMap[student.id];
                    if (!risk) {
                        return riskLevel === 'low'; // No risk data = treated as low risk.
                    }
                    return risk.risklevel === riskLevel;
                });
            }

            // Pass filtered courses AND filtered students
            var filteredData = {
                courses: filteredCourses,
                students: filteredStudents
            };

            this.lastFilteredData = filteredData; // Store for export
            this.render(filteredData);
        },

        exportToCSV: function() {
            var data = this.lastFilteredData;
            if (!data || !data.courses || data.courses.length === 0) {
                Notification.alert('No Data', 'There is no data to export.');
                return;
            }

            var csv = [];

            // Header
            var header = ['Student Name', 'Email'];
            data.courses.forEach(function(c) {
                // Remove commas from course name to avoid CSV breakages
                header.push('Course: ' + c.name.replace(/,/g, ''));
            });
            header.push('Completed Count');
            header.push('Enrolled Count');
            csv.push(header.join(','));

            // Helper
            var getCompletion = function(student, courseId) {
                if (!student.completions) {
                    return null;
                }
                return student.completions.find(function(c) {
                    return c.courseid == courseId;
                });
            };

            data.students.forEach(function(student) {
                var row = [];
                // Escape quotes and wrap in quotes
                row.push('"' + (student.name || '').replace(/"/g, '""') + '"');
                row.push('"' + (student.email || '').replace(/"/g, '""') + '"');

                var completedCount = 0;
                var enrolledCount = 0;

                data.courses.forEach(function(course) {
                    var comp = getCompletion(student, course.id);
                    if (comp) {
                        if (comp.enrolled) {
                            enrolledCount++;
                            row.push(comp.completed ? 'Completed' : 'Enrolled');
                            if (comp.completed) {
                                completedCount++;
                            }
                        } else {
                            row.push('Not Enrolled');
                        }
                    } else {
                        row.push('N/A');
                    }
                });

                row.push(completedCount);
                row.push(enrolledCount);
                csv.push(row.join(','));
            });

            var csvString = csv.join('\n');
            var blob = new Blob([csvString], {type: 'text/csv;charset=utf-8;'});
            var url = URL.createObjectURL(blob);
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "student_progress_export.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        render: function(data) {
            try {
                // If no students, display message and return
                if (!data || !data.students || data.students.length === 0) {
                    // Ensure content wrapper exists before trying to update it
                    if (this.container.find('#dashboard-content-wrapper').length === 0) {
                        this.container.append('<div id="dashboard-content-wrapper"></div>');
                    }
                    this.container.find('#dashboard-content-wrapper')
                        .html('<div class="alert alert-info">No progress data available.</div>');
                    return;
                }

                var html = '<div id="dashboard-content" class="animate__animated animate__fadeIn">';
                var self = this;

                // Helper to find completion for a specific course ID
                var getCompletion = function(student, courseId) {
                    if (!student.completions) {
                        return null;
                    }
                    return student.completions.find(function(c) {
                        return c.courseid == courseId;
                    });
                };

                // Calculate stats based on visible courses
                var totalStudents = data.students.length;
                var visibleCourses = data.courses; // These are the courses after filtering
                var allCompletedCount = 0;

                // Calculate completion counts per visible course
                var courseStats = {}; // Map courseId -> stats
                visibleCourses.forEach(function(c) {
                    courseStats[c.id] = {completed: 0, enrolled: 0};
                });

                data.students.forEach(function(student) {
                    var studentEnrolledCount = 0;
                    var studentCompletedCount = 0;

                    visibleCourses.forEach(function(course) {
                        var comp = getCompletion(student, course.id);
                        if (comp && comp.enrolled) {
                            studentEnrolledCount++;
                            if (courseStats[course.id]) {
                                courseStats[course.id].enrolled++;
                            }

                            if (comp.completed) {
                                if (courseStats[course.id]) {
                                    courseStats[course.id].completed++;
                                }
                                studentCompletedCount++;
                            }
                        }
                    });

                    // Consider "Program Complete" if they completed all *visible* courses they are enrolled in
                    if (studentEnrolledCount > 0 && studentEnrolledCount === studentCompletedCount) {
                        allCompletedCount++;
                    }
                });

                // 1. Stats Cards
                var riskSummary = this.riskData && this.riskData.summary ? this.riskData.summary : {high: 0, medium: 0, low: 0};

                html += '<div class="row mb-4">';
                html += this.renderStatCard('Total Students', totalStudents, 'users', 'bg-dark text-white');

                visibleCourses.forEach(function(course) {
                    var stats = courseStats[course.id];
                    html += self.renderStatCard(
                        course.name,
                        stats.completed + ' / ' + stats.enrolled + ' <span class="fs-6 fw-normal">completed</span>',
                        'check-circle',
                        'bg-primary text-white'
                    );
                });

                var pc = allCompletedCount;
                pc += ' (' + (totalStudents > 0 ? ((allCompletedCount / totalStudents) * 100).toFixed(1) : '0.0') + '%)';
                html += this.renderStatCard('Program Complete', pc, 'trophy', 'bg-success text-white');

                // Risk Summary Cards
                html += this.renderStatCard('At Risk', riskSummary.high || 0, 'exclamation-triangle', 'bg-danger text-white');
                html += this.renderStatCard('Monitor', riskSummary.medium || 0, 'eye', 'bg-warning text-dark');

                html += '</div>'; // End stats row

                // 2. Main Table
                html += '<div class="card shadow-sm border-0 animate__animated animate__fadeInUp">';
                html += '<div class="card-body p-0">';
                html += '<div class="table-responsive">';
                html += '<table class="table table-hover align-middle mb-0">';

                // Header
                html += '<thead class="bg-light"><tr>';
                // Checkbox Column Header
                html += '<th class="border-0 px-4 py-3" style="width: 40px;">';
                html += '<div class="form-check">';
                html += '<input class="form-check-input" type="checkbox" id="select-all-students">';
                html += '</div></th>';

                html += '<th class="border-0 px-4 py-3">Student Name</th>';
                html += '<th class="text-center border-0 px-4 py-3">Risk</th>';
                html += '<th class="text-center border-0 px-4 py-3">Engagement</th>';

                visibleCourses.forEach(function(course) {
                    var displayName = 'Course';
                    if (course.name) {
                        displayName = course.name.substring(0, 20) + (course.name.length > 20 ? '...' : '');
                    }
                    html += '<th class="text-center border-0 px-4 py-3" title="' + course.name + '">' +
                        displayName + '</th>';
                });
                html += '<th class="text-center border-0 px-4 py-3">Progress</th>';
                html += '</tr></thead>';

                // Body
                html += '<tbody>';
                data.students.forEach(function(student) {
                    var completedCount = 0;
                    var enrolledCount = 0;
                    var rowHtml = '<tr>';
                    // Checkbox Column
                    var isSelected = self.selectedStudents.has(String(student.id)) ? 'checked' : '';
                    rowHtml += '<td class="px-4 py-3">';
                    rowHtml += '<div class="form-check">';
                    rowHtml += '<input class="form-check-input student-select-checkbox" type="checkbox" ';
                    rowHtml += 'value="' + student.id + '" ' + isSelected + '>';
                    rowHtml += '</div></td>';

                    rowHtml += '<td class="px-4 py-3">';
                    rowHtml += '<div class="fw-bold text-dark">' + (student.name || 'Unknown') + '</div>';
                    rowHtml += '<div class="small text-muted">' + (student.email || '') + '</div>';
                    rowHtml += '</td>';

                    // Risk Level Column
                    var riskInfo = self.riskMap ? self.riskMap[student.id] : null;
                    rowHtml += '<td class="text-center px-4 py-3">';
                    if (riskInfo) {
                        var riskBadgeClass = 'bg-success';
                        var riskLabel = 'On Track';
                        var riskIcon = 'check-circle';
                        if (riskInfo.risklevel === 'high') {
                            riskBadgeClass = 'bg-danger';
                            riskLabel = 'At Risk';
                            riskIcon = 'exclamation-triangle';
                        } else if (riskInfo.risklevel === 'medium') {
                            riskBadgeClass = 'bg-warning text-dark';
                            riskLabel = 'Monitor';
                            riskIcon = 'eye';
                        }
                        rowHtml += '<span class="badge rounded-pill ' + riskBadgeClass + '" ';
                        rowHtml += 'title="Risk Score: ' + riskInfo.riskscore + '%" ';
                        rowHtml += 'style="cursor:help;">';
                        rowHtml += '<i class="fa fa-' + riskIcon + ' me-1"></i>' + riskLabel;
                        rowHtml += '</span>';
                    } else {
                        rowHtml += '<span class="badge bg-secondary rounded-pill">N/A</span>';
                    }
                    rowHtml += '</td>';

                    // Engagement Score Column
                    var score = student.engagement_score !== undefined ? student.engagement_score : 0;
                    var badgeClass = 'bg-danger';
                    if (score >= 70) {
                        badgeClass = 'bg-success';
                    } else if (score >= 40) {
                        badgeClass = 'bg-warning text-dark';
                    }

                    rowHtml += '<td class="text-center px-4 py-3">';
                    rowHtml += '<span class="badge rounded-pill ' + badgeClass + '">' + score + '</span>';
                    rowHtml += '</td>';

                    visibleCourses.forEach(function(course) {
                        var comp = getCompletion(student, course.id);
                        if (comp) {
                            if (!comp.enrolled) {
                                // Not Enrolled
                                rowHtml += '<td class="text-center"><i class="fa fa-circle-thin text-muted ';
                                rowHtml += 'opacity-75" title="Not Enrolled"></i></td>';
                            } else {
                                enrolledCount++;
                                if (comp.completed) {
                                    completedCount++;
                                    rowHtml += '<td class="text-center"><i class="fa fa-check-circle text-success fa-lg" ';
                                    rowHtml += 'title="Completed"></i></td>';
                                } else {
                                    // Enrolled, Pending
                                    rowHtml += '<td class="text-center"><i class="fa fa-circle text-muted ';
                                    rowHtml += 'opacity-75" title="Enrolled, Not Completed"></i></td>';
                                }
                            }
                        } else {
                            // Should not happen if data integrity is good, but fallback for courses not in student's completions
                            rowHtml += '<td class="text-center"><i class="fa fa-minus text-muted opacity-75" ';
                            rowHtml += 'title="No data for this course"></i></td>';
                        }
                    });

                    // Progress Bar
                    var percentage = enrolledCount > 0 ? (completedCount / enrolledCount) * 100 : 0;
                    var colorClass = 'bg-warning';
                    if (percentage === 100) {
                        colorClass = 'bg-success';
                    } else if (percentage > 50) {
                        colorClass = 'bg-info';
                    }

                    rowHtml += '<td class="px-4 py-3" style="min-width: 150px">';
                    rowHtml += '<div class="d-flex align-items-center">';
                    rowHtml += '<div class="progress flex-grow-1" style="height: 6px;">';
                    rowHtml += '<div class="progress-bar ' + colorClass + '" ';
                    rowHtml += 'role="progressbar" style="width: ' + percentage + '%"></div>';
                    rowHtml += '</div>';
                    rowHtml += '<span class="ms-2 small fw-bold text-muted">' + completedCount + '/' + enrolledCount + '</span>';
                    rowHtml += '</div></td>';

                    rowHtml += '</tr>';
                    html += rowHtml;
                });
                html += '</tbody></table></div></div></div>';

                // Export Button
                html += '<div class="d-flex justify-content-end mt-3 mb-4">';
                html += '<button id="btn-export-csv" class="btn btn-outline-secondary">';
                html += '<i class="fa fa-download me-1"></i> Export Data to CSV</button>';
                html += '</div>';

                html += '</div>'; // End dashboard content

                // Create a content wrapper if it doesn't exist, then update its HTML
                if (this.container.find('#dashboard-content-wrapper').length === 0) {
                    this.container.append('<div id="dashboard-content-wrapper"></div>');
                }
                this.container.find('#dashboard-content-wrapper').html(html);
            } catch (e) {
                //
                // If an error occurs during rendering, clear the content wrapper and show error
                if (this.container.find('#dashboard-content-wrapper').length === 0) {
                    this.container.append('<div id="dashboard-content-wrapper"></div>');
                }
                this.container.find('#dashboard-content-wrapper')
                    .html('<div class="alert alert-danger">Error rendering student progress: '
                        + e.message + '</div>');
            }
        },

        renderStatCard: function(title, value, icon, bgClass) {
            return '<div class="col-6 col-md-3 mb-3">' +
                '<div class="card border-0 shadow-sm h-100 ' + bgClass + '">' +
                '<div class="card-body">' +
                '<div class="d-flex justify-content-between align-items-center">' +
                '<div><h6 class="text-uppercase small opacity-75 mb-1">' + title + '</h6>' +
                '<div class="fs-4 fw-bold">' + value + '</div></div>' +
                '<i class="fa fa-' + icon + ' fa-2x opacity-50"></i>' +
                '</div></div></div></div>';
        },

        updateActionBar: function() {
            var count = this.selectedStudents.size;
            var $bar = $('#bulk-action-bar');
            var $countSpan = $('#selected-count');

            $countSpan.text(count);

            if (count > 0) {
                $bar.removeClass('d-none');
            } else {
                $bar.addClass('d-none');
            }
        },

        openMessageModal: function() {
            var self = this;
            var count = this.selectedStudents.size;

            if (count === 0) {
                return;
            }

            $('#smartdashboard-bulk-modal').remove();

            var html = '<div class="modal fade" id="smartdashboard-bulk-modal" tabindex="-1">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h5 class="modal-title">Message ' + count + ' Students</h5>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                '</div>' +
                '<div class="modal-body">' +
                '<div class="mb-3">' +
                '<label for="bulk-message-body" class="form-label">Message</label>' +
                '<textarea class="form-control" id="bulk-message-body" rows="4" placeholder="Type your message here..."></textarea>' +
                '</div>' +
                '<div class="alert alert-info small"><i class="fa fa-info-circle me-1"></i> Messages will be sent individually.</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>' +
                '<button type="button" class="btn btn-primary" id="btn-bulk-send">Send</button>' +
                '</div></div></div></div>';

            $('body').append(html);

            var modalEl = document.getElementById('smartdashboard-bulk-modal');
            var modal = new bootstrap.Modal(modalEl);

            var self = this;
            $('#btn-bulk-send').on('click', function() {
                var messageText = $('#bulk-message-body').val();
                if (!messageText.trim()) {
                    Notification.alert('Error', 'Please enter a message.', 'OK');
                    return;
                }
                self.sendBulkMessage(messageText, modal);
            });

            modal.show();
        },

        sendBulkMessage: function(text, modal) {
            var self = this;
            var recipientIds = Array.from(this.selectedStudents);
            var messages = recipientIds.map(function(id) {
                return {
                    touserid: id,
                    text: text,
                    textformat: 1 // HTML
                };
            });

            // Moodle Web Service: core_message_send_instant_messages
            Ajax.call([{
                methodname: 'core_message_send_instant_messages',
                args: {messages: messages}
            }])[0].done(function(response) {
                // Response is a list of message IDs or errors
                // We generally assume success if no error thrown, but let's check
                modal.hide();
                Notification.addNotification({
                    message: 'Successfully sent messages to ' + recipientIds.length + ' students.',
                    type: 'success'
                });

                // Optional: Clear selection after send
                self.selectedStudents.clear();
                self.render(self.lastFilteredData); // Re-render to clear checkboxes

            }).fail(function(ex) {
                modal.hide();
                Notification.exception(ex);
            });
        },

        /**
         * DETAILED PROGRESS SECTION
         */
        initDetailed: function() {
            var self = this;
            this.detailedContainer = $('#section-progress-detailed');
            this.detailedContent = $('#detailed-progress-content');

            // Populate Student Select if data exists
            if (this.allData && this.allData.students) {
                this.populateStudentSelect(this.allData.students);
            } else {
                // If accessed directly without loading main data first
                this.loadData().then(function() {
                    self.populateStudentSelect(self.allData.students);
                });
            }

            // Event Listeners
            this.detailedContainer.find('#detailed-student-select').off('change').on('change', function() {
                var studentId = $(this).val();
                if (studentId) {
                    self.loadDetailedData(studentId);
                } else {
                    self.detailedContent.html('<p class="text-muted text-center py-5">Select a student to view details.</p>');
                }
            });

            this.detailedContainer.find('#detailed-activity-filter').off('change').on('change', function() {
                self.renderDetailed(); // Re-render with existing detailedData
            });
        },

        populateStudentSelect: function(students) {
            var $select = this.detailedContainer.find('#detailed-student-select');
            $select.empty();
            $select.append('<option value="">Choose a student...</option>');

            // Sort by name
            var sorted = students.slice().sort(function(a, b) {
                return (a.name || '').localeCompare(b.name || '');
            });

            sorted.forEach(function(s) {
                $select.append('<option value="' + s.id + '">' + s.name + '</option>');
            });
        },

        loadDetailedData: function(studentId) {
            var self = this;
            this.detailedContent.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            Ajax.call([{
                methodname: 'local_smartdashboard_get_student_detailed_progress',
                args: {studentid: studentId}
            }])[0].done(function(response) {
                self.detailedData = response;
                self.renderDetailed();
            }).fail(function(ex) {
                self.detailedContent.html('<div class="alert alert-danger">Error: ' + ex.message + '</div>');
            });
        },

        renderDetailed: function() {
            if (!this.detailedData) {
                return;
            }
            var data = this.detailedData;
            var filterType = this.detailedContainer.find('#detailed-activity-filter').val();

            var html = '';

            if (data.courses.length === 0) {
                html = '<div class="alert alert-warning">No shared courses found for this student.</div>';
                this.detailedContent.html(html);
                return;
            }

            var hasActivities = false;

            data.courses.forEach(function(course) {
                // Filter activities
                var activities = course.activities;
                if (filterType) {
                    activities = activities.filter(function(a) {
 return a.type === filterType;
});
                }

                if (activities.length === 0) {
                    return; // Skip empty courses if filtered
                }
                hasActivities = true;

                html += '<div class="card mb-4 shadow-sm animate__animated animate__fadeIn">';
                html += '<div class="card-header bg-light fw-bold">' + course.fullname + '</div>';
                html += '<div class="card-body p-0 table-responsive">';
                html += '<table class="table table-hover mb-0">';
                html += '<thead class="bg-light"><tr><th>Activity</th><th>Type</th><th>Status</th><th>Grade</th></tr></thead>';
                html += '<tbody>';

                activities.forEach(function(act) {
                    var statusBadge = '';
                    if (act.status === 'Completed') {
                        statusBadge = '<span class="badge bg-success">Completed</span>';
                    } else if (act.status === 'Passed') {
                        statusBadge = '<span class="badge bg-success">Passed</span>';
                    } else if (act.status === 'Failed') {
                        statusBadge = '<span class="badge bg-danger">Failed</span>';
                    } else if (act.status === 'Pending') {
                        statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                    } else {
                        statusBadge = '<span class="badge bg-secondary text-white">' + act.status + '</span>';
                    }

                    html += '<tr>';
                    html += '<td class="fw-bold">' + act.name + '</td>';
                    html += '<td><small class="text-muted">' + act.type + '</small></td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '<td>' + (act.grade ? act.grade : '-') + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div></div>';
            });

            if (!hasActivities) {
                html = '<div class="alert alert-info">No activities found matching the filter.</div>';
            }

            this.detailedContent.html(html);
        }

    };


    return ProgressTracker;
});
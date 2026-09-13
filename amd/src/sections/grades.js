define(['jquery', 'core/ajax', 'core/notification', 'local_smartdashboard/core/utils'], function($, Ajax, Notification, Utils) {
    var GradesTracker = {
        init: function() {
            this.container = $('#section-progress-grades');
            var self = this;
            Utils.LoadPrompt.show(this.container, 'Grades Overview', 'graduation-cap', function() {
                self.loadData();
            });
        },

        loadData: function() {
            var self = this;
            this.container.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            return Ajax.call([{methodname: 'local_smartdashboard_get_cross_course_grades', args: {}}])[0].done(function(response) {
                self.container.find('.fa-spinner').parent().remove();
                self.allData = response;
                self.lastFilteredData = response;
                try {
                    self.renderFilters();
                    self.applyFilters();
                } catch (e) {
                    self.container.html('<div class="alert alert-danger">Render Error: ' + e.message + '</div>');
                }
            }).fail(function(ex) {
                self.container.html('<div class="alert alert-danger">Error loading data: ' + ex.message + '</div>');
                Notification.exception(ex);
            });
        },

        renderFilters: function() {
            var self = this;
            var courses = this.allData.courses || [];

            var categories = {};
            courses.forEach(function(c) {
                if (c.category && c.categoryname) {
                    categories[c.category] = c.categoryname;
                }
            });

            var html = '<div class="row mb-4 animate__animated animate__fadeIn">';

            html += '<div class="col-6 col-md-4 mb-2">';
            html += '<select id="grades-filter-course" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Courses</option>';
            courses.forEach(function(c) {
                html += '<option value="' + c.id + '">' + c.name + '</option>';
            });
            html += '</select></div>';

            html += '<div class="col-6 col-md-4 mb-2">';
            html += '<select id="grades-filter-category" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Categories</option>';
            for (var catId in categories) {
                html += '<option value="' + catId + '">' + categories[catId] + '</option>';
            }
            html += '</select></div>';

            html += '<div class="col-6 col-md-4 mb-2">';
            html += '<select id="grades-filter-status" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Statuses</option>';
            html += '<option value="enrolled" selected>Enrolled</option>';
            html += '</select></div>';

            html += '</div>';

            this.container.find('.row.mb-4.animate__animated.animate__fadeIn').remove();
            this.container.prepend(html);

            this.container.find('#grades-filter-course, #grades-filter-category, #grades-filter-status').on('change', function() {
                self.applyFilters();
            });

            this.container.off('click', '#btn-grades-export-csv').on('click', '#btn-grades-export-csv', function() {
                self.exportToCSV();
            });
        },

        applyFilters: function() {
            var courseId = this.container.find('#grades-filter-course').val();
            var catId = this.container.find('#grades-filter-category').val();
            var status = this.container.find('#grades-filter-status').val();

            var filteredCourses = this.allData.courses.filter(function(c) {
                var matchCourse = courseId === "" || c.id == courseId;
                var matchCat = catId === "" || c.category == catId;
                return matchCourse && matchCat;
            });

            var filteredStudents = this.allData.students;
            if (status !== "") {
                filteredStudents = filteredStudents.filter(function(student) {
                    var hasMatch = false;
                    filteredCourses.forEach(function(course) {
                        var gradeInfo = null;
                        if (student.grades) {
                            gradeInfo = student.grades.find(function(g) {
 return g.courseid == course.id;
});
                        }
                        if (gradeInfo && gradeInfo.enrolled) {
                            if (status === 'enrolled') {
                                hasMatch = true;
                            }
                        }
                    });
                    return hasMatch;
                });
            }

            var filteredData = {
                courses: filteredCourses,
                students: filteredStudents
            };

            this.lastFilteredData = filteredData;
            this.render(filteredData);
        },

        exportToCSV: function() {
            var data = this.lastFilteredData;
            if (!data || !data.courses || data.courses.length === 0) {
                Notification.alert('No Data', 'There is no data to export.');
                return;
            }

            var csv = [];
            var header = ['Student Name', 'Email'];
            data.courses.forEach(function(c) {
                header.push('Course: ' + c.name.replace(/,/g, ''));
            });
            csv.push(header.join(','));

            var getGrade = function(student, courseId) {
                if (!student.grades) {
 return null;
}
                return student.grades.find(function(g) {
 return g.courseid == courseId;
});
            };

            data.students.forEach(function(student) {
                var row = [];
                row.push('"' + (student.name || '').replace(/"/g, '""') + '"');
                row.push('"' + (student.email || '').replace(/"/g, '""') + '"');

                data.courses.forEach(function(course) {
                    var gradeInfo = getGrade(student, course.id);
                    if (gradeInfo) {
                        if (gradeInfo.enrolled) {
                            row.push(gradeInfo.grade !== '-' ? gradeInfo.grade : 'No Grade');
                        } else {
                            row.push('Not Enrolled');
                        }
                    } else {
                        row.push('N/A');
                    }
                });
                csv.push(row.join(','));
            });

            var csvString = csv.join('\n');
            var blob = new Blob([csvString], {type: 'text/csv;charset=utf-8;'});
            var url = URL.createObjectURL(blob);
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "student_grades_export.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        render: function(data) {
            try {
                if (!data || !data.students || data.students.length === 0) {
                    if (this.container.find('#dashboard-grades-wrapper').length === 0) {
                        this.container.append('<div id="dashboard-grades-wrapper"></div>');
                    }
                    this.container.find('#dashboard-grades-wrapper')
                        .html('<div class="alert alert-info">No grades data available.</div>');
                    return;
                }

                var html = '<div id="dashboard-grades-content" class="animate__animated animate__fadeIn">';
                var self = this;

                var getGrade = function(student, courseId) {
                    if (!student.grades) {
 return null;
}
                    return student.grades.find(function(g) {
 return g.courseid == courseId;
});
                };

                html += '<div class="card shadow-sm border-0 animate__animated animate__fadeInUp">';
                html += '<div class="card-body p-0">';
                html += '<div class="table-responsive">';
                html += '<table class="table table-hover align-middle mb-0">';
                html += '<thead class="bg-light"><tr>';
                html += '<th class="border-0 px-4 py-3">Student Name</th>';

                data.courses.forEach(function(course) {
                    var displayName = course.name.substring(0, 20) + (course.name.length > 20 ? '...' : '');
                    html += '<th class="text-center border-0 px-4 py-3" title="' + course.name + '">' + displayName + '</th>';
                });
                html += '</tr></thead><tbody>';

                data.students.forEach(function(student) {
                    var rowHtml = '<tr>';
                    rowHtml += '<td class="px-4 py-3">';
                    rowHtml += '<div class="fw-bold text-dark">' + (student.name || 'Unknown') + '</div>';
                    rowHtml += '<div class="small text-muted">' + (student.email || '') + '</div>';
                    rowHtml += '</td>';

                    data.courses.forEach(function(course) {
                        var gradeInfo = getGrade(student, course.id);
                        if (gradeInfo) {
                            if (!gradeInfo.enrolled) {
                                rowHtml += '<td class="text-center"><i class="fa fa-circle-thin text-muted opacity-75" title="Not Enrolled"></i></td>';
                            } else {
                                if (gradeInfo.grade === '-') {
                                    rowHtml += '<td class="text-center text-muted">-</td>';
                                } else {
                                    rowHtml += '<td class="text-center fw-bold">' + gradeInfo.grade + '</td>';
                                }
                            }
                        } else {
                            rowHtml += '<td class="text-center"><i class="fa fa-minus text-muted opacity-75"></i></td>';
                        }
                    });

                    rowHtml += '</tr>';
                    html += rowHtml;
                });

                html += '</tbody></table></div></div></div>';

                html += '<div class="d-flex justify-content-end mt-3 mb-4">';
                html += '<button id="btn-grades-export-csv" class="btn btn-outline-secondary">';
                html += '<i class="fa fa-download me-1"></i> Export Data to CSV</button>';
                html += '</div></div>';

                if (this.container.find('#dashboard-grades-wrapper').length === 0) {
                    this.container.append('<div id="dashboard-grades-wrapper"></div>');
                }
                this.container.find('#dashboard-grades-wrapper').html(html);
            } catch (e) {
                if (this.container.find('#dashboard-grades-wrapper').length === 0) {
                    this.container.append('<div id="dashboard-grades-wrapper"></div>');
                }
                this.container.find('#dashboard-grades-wrapper')
                    .html('<div class="alert alert-danger">Error rendering grades: ' + e.message + '</div>');
            }
        }
    };


    return GradesTracker;
});
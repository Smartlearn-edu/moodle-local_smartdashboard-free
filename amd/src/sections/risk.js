define(['jquery', 'core/ajax', 'core/notification'], function($, Ajax, Notification) {
    return {
        init: function() {
            this.container = $('#risk-details-content');
            this.allData = null;
            this.loadData();
        },

        loadData: function() {
            var self = this;
            this.container.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x text-muted"></i></div>');

            var request = {
                methodname: 'local_smartdashboard_get_risk_data',
                args: {
                    courseid: 0
                }
            };

            Ajax.call([request])[0].done(function(response) {
                self.allData = response.students || [];
                self.renderFilters();
                self.applyFilters();
            }).fail(function(ex) {
                self.container.html('<div class="alert alert-danger">Error loading risk data: ' + ex.message + '</div>');
                Notification.exception(ex);
            });
        },

        renderFilters: function() {
            var self = this;
            var categories = {};
            var courses = {};

            this.allData.forEach(function(s) {
                if (s.categoryid) {
 categories[s.categoryid] = s.categoryname || 'Unknown';
}
                if (s.courseid) {
 courses[s.courseid] = s.coursename || 'Unknown';
}
            });

            var html = '<div class="row mb-4 animate__animated animate__fadeIn">';

            // Category Filter
            html += '<div class="col-6 col-md-3 mb-2">';
            html += '<label class="form-label small text-muted">Category</label>';
            html += '<select id="risk-filter-category" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Categories</option>';
            for (var catId in categories) {
                html += '<option value="' + catId + '">' + categories[catId] + '</option>';
            }
            html += '</select></div>';

            // Course Filter
            html += '<div class="col-6 col-md-3 mb-2">';
            html += '<label class="form-label small text-muted">Course</label>';
            html += '<select id="risk-filter-course" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Courses</option>';
            for (var cId in courses) {
                html += '<option value="' + cId + '">' + courses[cId] + '</option>';
            }
            html += '</select></div>';

            // Rule/Risk Filter
            html += '<div class="col-6 col-md-3 mb-2">';
            html += '<label class="form-label small text-muted">Risk Factor</label>';
            html += '<select id="risk-filter-rule" class="form-select border-0 shadow-sm">';
            html += '<option value="">Any Risk Level</option>';
            html += '<option value="overall_high">High Overall Risk</option>';
            html += '<option value="login_high">High Login Risk</option>';
            html += '<option value="completion_high">High Completion Risk</option>';
            html += '<option value="grades_high">High Grades Risk</option>';
            html += '<option value="overdue_high">High Overdue Risk</option>';
            html += '<option value="adaptive_high">High Adaptive Plan Risk</option>';
            html += '</select></div>';

            // Student Search
            html += '<div class="col-6 col-md-3 mb-2">';
            html += '<label class="form-label small text-muted">Student Search</label>';
            html += '<input type="text" id="risk-filter-student" class="form-control border-0 shadow-sm" ' +
                'placeholder="Search name or email...">';
            html += '</div>';

            // N8n Button
            html += '<div class="col-md-12 mb-2 text-end">';
            html += '<button id="btn-send-n8n" class="btn btn-outline-primary btn-sm">' +
                '<i class="fa fa-paper-plane me-1"></i>Send to n8n</button>';
            html += '</div>';

            html += '</div>';
            html += '<div id="risk-table-container"></div>';

            this.container.html(html);

            // Bind events
            $('#risk-filter-category, #risk-filter-course, #risk-filter-rule').on('change', function() {
                self.applyFilters();
            });

            var searchTimeout;
            $('#risk-filter-student').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    self.applyFilters();
                }, 300);
            });

            $('#btn-send-n8n').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i>Sending...');

                var payload = {
                    students: self.lastFilteredData || self.allData
                };

                var request = {
                    methodname: 'local_smartdashboard_send_n8n_data',
                    args: {
                        payload: JSON.stringify(payload)
                    }
                };

                Ajax.call([request])[0].done(function(response) {
                    if (response.success) {
                        Notification.addNotification({
                            message: response.message || 'Successfully pushed ' + 
                                payload.students.length + ' students to n8n.',
                            type: 'success'
                        });
                    } else {
                        Notification.addNotification({
                            message: 'Failed to push to n8n: ' + (response.message || 'Unknown error'),
                            type: 'error'
                        });
                    }
                }).fail(function(ex) {
                    Notification.addNotification({
                        message: 'Request failed: ' + ex.message,
                        type: 'error'
                    });
                }).always(function() {
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-1"></i>Send to n8n');
                });
            });
        },

        applyFilters: function() {
            var catId = $('#risk-filter-category').val();
            var courseId = $('#risk-filter-course').val();
            var rule = $('#risk-filter-rule').val();
            var studentSearch = $('#risk-filter-student').val().toLowerCase().trim();

            var filtered = this.allData.filter(function(s) {
                if (catId && String(s.categoryid) !== catId) {
 return false;
}
                if (courseId && String(s.courseid) !== courseId) {
 return false;
}

                if (studentSearch) {
                    var name = (s.fullname || '').toLowerCase();
                    var email = (s.email || '').toLowerCase();
                    if (name.indexOf(studentSearch) === -1 && email.indexOf(studentSearch) === -1) {
                        return false;
                    }
                }

                if (rule) {
                    if (rule === 'overall_high' && s.risklevel !== 'high') {
 return false;
}
                    if (rule === 'login_high' && (s.score_login === null || s.score_login < 60)) {
 return false;
}
                    if (rule === 'completion_high' && (s.score_completion === null || s.score_completion < 60)) {
 return false;
}
                    if (rule === 'grades_high' && (s.score_grade === null || s.score_grade < 60)) {
 return false;
}
                    if (rule === 'overdue_high' && (s.score_overdue === null || s.score_overdue < 60)) {
 return false;
}
                    if (rule === 'adaptive_high' && (s.score_adaptiveplan === null || s.score_adaptiveplan < 60)) {
 return false;
}
                }

                return true;
            });

            this.lastFilteredData = filtered;
            this.renderTable(filtered);
        },

        renderTable: function(students) {
            var $tableContainer = $('#risk-table-container');

            if (students.length === 0) {
                $tableContainer.html('<div class="alert alert-info">No students match the current filters.</div>');
                return;
            }

            var html = '<div class="table-responsive"><table class="table table-hover ' +
                'align-middle animate__animated animate__fadeIn">';
            html += '<thead class="bg-light"><tr>';
            html += '<th>Student</th>';
            html += '<th>Course</th>';
            html += '<th class="text-center">Overall Risk</th>';
            html += '<th class="text-center" title="Login Recency">Login</th>';
            html += '<th class="text-center" title="Course Completion">Completion</th>';
            html += '<th class="text-center" title="Grades">Grades</th>';
            html += '<th class="text-center" title="Overdue Activities">Overdue</th>';
            html += '<th class="text-center" title="Adaptive Plan">Adaptive Plan</th>';
            html += '<th class="text-end">Last Updated</th>';
            html += '</tr></thead><tbody>';

            students.forEach(function(student) {
                var badgeClass = 'bg-success';
                var riskLabel = 'On Track';
                var icon = 'check-circle';

                if (student.risklevel === 'high') {
                    badgeClass = 'bg-danger';
                    riskLabel = 'At Risk';
                    icon = 'exclamation-triangle';
                } else if (student.risklevel === 'medium') {
                    badgeClass = 'bg-warning text-dark';
                    riskLabel = 'Monitor';
                    icon = 'eye';
                }

                html += '<tr>';
                html += '<td>';
                html += '<div class="fw-bold text-dark">' + student.fullname + '</div>';
                html += '<div class="small text-muted">' + student.email + '</div>';
                html += '</td>';

                var categoryName = student.categoryname ? '<br><small class="text-muted">' + student.categoryname + '</small>' : '';
                html += '<td><div class="text-truncate" style="max-width:200px;" title="' + 
                    student.coursename + '">' + student.coursename + categoryName + '</div></td>';

                html += '<td class="text-center">';
                html += '<span class="badge rounded-pill ' + badgeClass + '"><i class="fa fa-' + 
                    icon + ' me-1"></i>' + riskLabel + ' (' + student.riskscore + '%)</span>';
                html += '</td>';

                // Helper to render subscores
                var renderSubscore = function(score) {
                    if (score === null || score === undefined) {
 return '<span class="text-muted small">-</span>';
}
                    var c = 'text-success';
                    if (score >= 60) {
 c = 'text-danger fw-bold';
} else if (score >= 30) {
 c = 'text-warning fw-bold';
}
                    return '<span class="' + c + '">' + score + '%</span>';
                };

                html += '<td class="text-center">' + renderSubscore(student.score_login) + '</td>';
                html += '<td class="text-center">' + renderSubscore(student.score_completion) + '</td>';
                html += '<td class="text-center">' + renderSubscore(student.score_grade) + '</td>';
                html += '<td class="text-center">' + renderSubscore(student.score_overdue) + '</td>';
                html += '<td class="text-center">' + renderSubscore(student.score_adaptiveplan) + '</td>';

                var d = new Date(student.timecreated * 1000);
                var dStr = d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
                html += '<td class="text-end small text-muted">' + dStr + '</td>';

                html += '</tr>';
            });

            html += '</tbody></table></div>';
            $tableContainer.html(html);
        }
    };
});

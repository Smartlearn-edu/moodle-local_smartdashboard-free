define(['jquery', 'core/ajax', 'core/notification', 'local_smartdashboard/core/utils'], function($, Ajax, Notification, Utils) {
    var GradingTracker = {
        init: function() {
            this.container = $('#section-grading');
            this.content = $('#grading-content');
            var self = this;
            Utils.LoadPrompt.show(this.container, 'Grading Overview', 'pencil', function() {
                self.loadData();
            });
        },

        loadData: function() {
            var self = this;
            this.content.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            return Ajax.call([{
                methodname: 'local_smartdashboard_get_grading_overview',
                args: {}
            }])[0].done(function(response) {
                self.allData = response;
                self.courses = response.courses || [];
                self.renderFilters();
                self.render(self.courses);
            }).fail(function(ex) {
                self.content.html('<div class="alert alert-danger">Error loading grading data: ' + ex.message + '</div>');
                Notification.exception(ex);
            });
        },

        renderFilters: function() {
            var self = this;
            // Remove existing filters if any
            this.container.find('.grading-filters').remove();

            var html = '<div class="row mb-4 grading-filters animate__animated animate__fadeIn">';
            html += '<div class="col-md-4">';
            html += '<select id="grading-filter-course" class="form-select border-0 shadow-sm">';
            html += '<option value="">All Courses</option>';

            // Collect unique courses from the data
            this.courses.forEach(function(c) {
                html += '<option value="' + c.id + '">' + c.fullname + '</option>';
            });

            html += '</select></div></div>';

            this.container.find('.card-body').prepend(html);

            this.container.find('#grading-filter-course').off('change').on('change', function() {
                self.applyFilters();
            });
        },

        applyFilters: function() {
            var courseId = this.container.find('#grading-filter-course').val();
            var filtered = this.courses;

            if (courseId) {
                filtered = this.courses.filter(function(c) {
                    return c.id == courseId;
                });
            }
            this.render(filtered);
        },

        render: function(courses) {
            if (!courses || courses.length === 0) {
                if (this.courses && this.courses.length > 0) {
                    this.content.html('<div class="alert alert-info">No assignments found for this filter.</div>');
                } else {
                    this.content.html('<div class="alert alert-success">No assignments need grading!</div>');
                }
                return;
            }

            var html = '';

            courses.forEach(function(course) {
                html += '<div class="card mb-3 border-0 shadow-sm animate__animated animate__fadeIn">';
                html += '<div class="card-header bg-transparent fw-bold border-bottom-0">';
                html += '<i class="fa fa-graduation-cap me-2 text-primary"></i>' + course.fullname + '</div>';
                html += '<div class="card-body p-0">';
                html += '<div class="list-group list-group-flush">';

                var assignments = course.assignments;
                if (assignments && assignments.length > 0) {
                    assignments.forEach(function(assign) {
                        var gradeUrl = M.cfg.wwwroot + '/mod/assign/view.php?id=' + assign.cmid + '&action=grading';

                        html += '<div class="list-group-item d-flex justify-content-between align-items-center p-3">';
                        html += '<div>';
                        html += '<h6 class="mb-1"><a href="' + gradeUrl + '" class="text-decoration-none fw-bold">';
                        html += assign.name + '</a></h6>';
                        html += '<small class="text-muted"><i class="fa fa-clock-o me-1"></i> ';
                        html += 'Due: ' + assign.duedatestr + '</small>';
                        html += '</div>';
                        html += '<div class="text-end">';
                        html += '<span class="badge bg-danger rounded-pill fs-6 mb-1">';
                        html += assign.needsgrading + ' to grade</span><br>';
                        html += '<a href="' + gradeUrl + '" class="btn btn-sm btn-outline-primary mt-1">';
                        html += 'Grade Now <i class="fa fa-arrow-right ms-1"></i></a>';
                        
                        // NEW: AI Review Drafts button (only if pending reviews exist)
                        if (assign.pendingaireviews > 0) {
                            var trackUrl = M.cfg.wwwroot + '/local/smartgradeai/track.php?id=' + assign.id;
                            html += '<a href="' + trackUrl + '" class="btn btn-sm btn-outline-info mt-1 ms-1">';
                            html += '<i class="fa fa-robot me-1"></i>';
                            html += assign.pendingaireviews + ' AI Review';
                            if (assign.pendingaireviews > 1) {
                                html += 's';
                            }
                            html += ' <i class="fa fa-arrow-right ms-1"></i></a>';
                        }
                        
                        html += '</div>';
                        html += '</div>';
                    });
                } else {
                    html += '<div class="p-3 text-muted small">No assignments to grade.</div>';
                }

                html += '</div></div></div>';
            });

            this.content.html(html);
        }
    };


    return GradingTracker;
});
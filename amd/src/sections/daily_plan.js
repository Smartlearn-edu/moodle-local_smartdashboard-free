define(['jquery', 'core/ajax', 'core/notification', 'local_smartdashboard/core/utils'], function($, Ajax, Notification, Utils) {
    var DailyPlanTracker = {
        init: function() {
            this.container = $('#section-daily-plan');
            this.content = $('#daily-plan-content');
            var self = this;
            Utils.LoadPrompt.show(this.container, 'Today\'s Agenda', 'calendar-check-o', function() {
                self.loadData();
            });
        },

        loadData: function() {
            var self = this;
            this.content.html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            var viewuser = new URLSearchParams(window.location.search).get('viewuser');
            var args = {};
            if (viewuser) {
                args.userid = parseInt(viewuser, 10);
            }

            return Ajax.call([{
                methodname: 'local_smartdashboard_get_daily_plan',
                args: args
            }])[0].done(function(response) {
                if (!response.is_installed) {
                    self.content.html('<div class="alert alert-warning animate__animated animate__fadeIn"><i class="fa fa-exclamation-triangle me-2"></i> The Adaptive Study Plan module is not installed or enabled. Please install mod_adaptiveplan to use this feature.</div>');
                    return;
                }
                self.render(response.courses);
            }).fail(function(ex) {
                self.content.html('<div class="alert alert-danger animate__animated animate__fadeIn"><i class="fa fa-exclamation-circle me-2"></i> Error loading daily plan: ' + ex.message + '</div>');
                Notification.exception(ex);
            });
        },

        render: function(courses) {
            if (!courses || courses.length === 0) {
                this.content.html(`
                    <div class="text-center p-5 bg-light rounded shadow-sm border border-light animate__animated animate__fadeIn">
                        <i class="fa fa-coffee fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">You're all caught up!</h4>
                        <p class="text-muted">You have no pending tasks or adaptive study plans for today.</p>
                    </div>
                `);
                return;
            }

            var html = '<div class="row animate__animated animate__fadeIn">';

            courses.forEach(function(course) {
                if ((!course.overdue_items || course.overdue_items.length === 0) &&
                    (!course.today_items || course.today_items.length === 0)) {
                    return; // Skip if no tasks
                }

                html += '<div class="col-12 mb-4">';
                html += '<div class="card shadow-sm border-0">';
                html += '<div class="card-header bg-primary text-white fw-bold"><i class="fa fa-graduation-cap me-2"></i> ' + course.coursename + '</div>';
                html += '<div class="card-body p-0">';
                html += '<ul class="list-group list-group-flush">';

                // Render Overdue Items First
                if (course.overdue_items && course.overdue_items.length > 0) {
                    course.overdue_items.forEach(function(item) {
                        html += '<li class="list-group-item bg-danger bg-opacity-10 border-start border-danger border-4 p-3">';
                        html += '<div class="d-flex justify-content-between align-items-center mb-2">';
                        html += '<h6 class="mb-0 fw-bold text-danger"><i class="fa fa-exclamation-triangle me-1"></i> ' + item.title + '</h6>';
                        html += '<span class="badge bg-danger">Overdue: ' + item.due_date_str + '</span>';
                        html += '</div>';

                        if (item.activities && item.activities.length > 0) {
                            html += '<ul class="list-unstyled ms-3 mb-0 small text-dark">';
                            item.activities.forEach(function(act) {
                                html += '<li class="mb-1"><i class="fa fa-square-o me-2 text-muted"></i>' + act.name;
                                if (act.estimated_time) {
                                    html += ' <span class="badge bg-secondary ms-1"><i class="fa fa-clock-o"></i> ' + act.estimated_time + '</span>';
                                }
                                html += '</li>';
                            });
                            html += '</ul>';
                        }
                        html += '</li>';
                    });
                }

                // Render Today's Items
                if (course.today_items && course.today_items.length > 0) {
                    course.today_items.forEach(function(item) {
                        html += '<li class="list-group-item border-start border-primary border-4 p-3">';
                        html += '<div class="d-flex justify-content-between align-items-center mb-2">';
                        html += '<h6 class="mb-0 fw-bold text-dark"><i class="fa fa-calendar-check-o me-1 text-primary"></i> ' + item.title + '</h6>';
                        html += '<span class="badge bg-primary">Due Today</span>';
                        html += '</div>';

                        if (item.activities && item.activities.length > 0) {
                            html += '<ul class="list-unstyled ms-3 mb-0 small text-dark">';
                            item.activities.forEach(function(act) {
                                html += '<li class="mb-1"><i class="fa fa-square-o me-2 text-muted"></i>' + act.name;
                                if (act.estimated_time) {
                                    html += ' <span class="badge bg-light text-dark border ms-1"><i class="fa fa-clock-o"></i> ' + act.estimated_time + '</span>';
                                }
                                html += '</li>';
                            });
                            html += '</ul>';
                        }
                        html += '</li>';
                    });
                }

                html += '</ul>';
                html += '<div class="card-footer bg-light text-end p-2">';
                html += '<a href="' + M.cfg.wwwroot + '/course/view.php?id=' + course.courseid + '" class="btn btn-sm btn-outline-primary">Go to Course <i class="fa fa-arrow-right ms-1"></i></a>';
                html += '</div>';
                html += '</div></div></div>';
            });

            html += '</div>';
            this.content.html(html);
        }
    };


    return DailyPlanTracker;
});
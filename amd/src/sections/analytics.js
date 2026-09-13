define(['jquery', 'core/ajax', 'core/notification', 'local_smartdashboard/core/utils'], function($, Ajax, Notification, Utils) {
    var AdminAnalytics = {
        init: function() {
            this.container = $('#section-analytics');
            this.currentFilters = {
                categoryid: 0,
                // We keep course filter as per existing logic, but primary filter is now hierarchical
                courseid: 0,
                includesubcategories: true
            };
            this.filtersRendered = false;
            this.allCategories = []; // Store for hierarchy
            var self = this;
            Utils.LoadPrompt.show(this.container, 'System Analytics', 'bar-chart', function() {
                self.loadData();
            });
        },

        loadData: function() {
            var self = this;


            return Ajax.call([{
                methodname: 'local_smartdashboard_get_system_analytics',
                args: this.currentFilters
            }])[0].done(function(response) {
                self.render(response);
            }).fail(function(ex) {

                self.container.find('.card-body').prepend('<div class="alert alert-danger">Error:'
                    + ex.message + '</div>');
            });
        },

        render: function(data) {

            this.lastData = data; // Store for export

            if (!this.filtersRendered) {
                this.renderFilters(data.filter_options);
                this.filtersRendered = true;
            }

            this.renderStats(data);
            this.renderTable(data.categories);
            this.renderCharts(data);

            // Bind export button
            var self = this;
            $('#btn-admin-export').off('click').on('click', function() {
                self.exportToCSV();
            });
        },

        renderFilters: function(options) {
            var self = this;
            this.filterOptions = options; // Store for dependencies
            this.allCategories = options.categories || [];

            var html = '<div class="row mb-4 animate__animated animate__fadeIn">';


            // Hierarchical Category Filters (Matching Payment Section style)
            // Level 1: Category
            html += '<div class="col-md-3 mb-2">';
            html += '<label class="form-label small text-muted">Category</label>';
            html += '<select id="admin-filter-category" class="form-select border-0 shadow-sm">';
            html += '<option value="0">All Categories</option>';
            // Only parent categories (parent=0)
            this.allCategories.forEach(function(c) {
                if (c.parent === 0) {
                    html += '<option value="' + c.id + '">' + c.name + '</option>';
                }
            });
            html += '</select></div>';

            // Level 2: Subcategory (Hidden by default)
            html += '<div class="col-md-3 mb-2 d-none" id="admin-subcat-wrapper">';
            html += '<label class="form-label small text-muted">Subcategory</label>';
            html += '<select id="admin-filter-subcategory" class="form-select border-0 shadow-sm">';
            html += '<option value="0">All</option>';
            html += '</select></div>';

            // Level 3: Sub-subcategory (Hidden by default)
            html += '<div class="col-md-3 mb-2 d-none" id="admin-subsubcat-wrapper">';
            html += '<label class="form-label small text-muted">Sub-subcategory</label>';
            html += '<select id="admin-filter-subsubcategory" class="form-select border-0 shadow-sm">';
            html += '<option value="0">All</option>';
            html += '</select></div>';

            // Include Subcategories Toggle? (Implicitly handled by hierarchy selection, but useful explicit option)
            // Let's keep it but maybe styled differently or just assume true for hierarchical drill down?
            // Use the filter by category same way as Payment.
            // But let's keep the logic simple: Selecting a category automatically includes its children unless specified otherwise.
            // Backend defaults 'includesubcategories' to true.

            html += '</div>'; // End filter row

            this.container.prepend(html);

            // Bind Events
            this.bindFilterEvents();
        },

        bindFilterEvents: function() {
            var self = this;


            // Category Level 1 -> Level 2
            this.container.find('#admin-filter-category').on('change', function() {
                var parentId = parseInt($(this).val());
                self.populateSubcategories(parentId, '#admin-filter-subcategory', '#admin-subcat-wrapper');
                // Reset Level 3
                self.container.find('#admin-subsubcat-wrapper').addClass('d-none');
                self.container.find('#admin-filter-subsubcategory').html('<option value="0">All</option>');

                self.updateCategoryFilter();
            });

            // Category Level 2 -> Level 3
            this.container.find('#admin-filter-subcategory').on('change', function() {
                var parentId = parseInt($(this).val());
                self.populateSubcategories(parentId, '#admin-filter-subsubcategory', '#admin-subsubcat-wrapper');

                self.updateCategoryFilter();
            });

            // Category Level 3 Change
            this.container.find('#admin-filter-subsubcategory').on('change', function() {
                self.updateCategoryFilter();
            });
        },

        populateSubcategories: function(parentId, selectSelector, wrapperSelector) {
            var $select = this.container.find(selectSelector);
            var $wrapper = this.container.find(wrapperSelector);

            $select.html('<option value="0">All</option>');

            if (!parentId || parentId === 0) {
                $wrapper.addClass('d-none');
                return;
            }

            var children = this.allCategories.filter(function(c) {
                return c.parent === parentId;
            });

            if (children.length > 0) {
                children.forEach(function(c) {
                    $select.append('<option value="' + c.id + '">' + c.name + '</option>');
                });
                $wrapper.removeClass('d-none');
            } else {
                $wrapper.addClass('d-none');
            }
        },

        updateCategoryFilter: function() {
            // Determine the deepest selected category
            var cat3 = parseInt(this.container.find('#admin-filter-subsubcategory').val()) || 0;
            var cat2 = parseInt(this.container.find('#admin-filter-subcategory').val()) || 0;
            var cat1 = parseInt(this.container.find('#admin-filter-category').val()) || 0;

            if (cat3 > 0) {
                this.currentFilters.categoryid = cat3;
            } else if (cat2 > 0) {
                this.currentFilters.categoryid = cat2;
            } else {
                this.currentFilters.categoryid = cat1;
            }

            this.currentFilters.courseid = 0;

            this.loadData();
        },

        renderStats: function(data) {
            $('#total-students-count').html(data.total_students);
            $('#active-students-count').html(data.active_students !== undefined ? data.active_students : '-');
            $('#total-enrollments-count').html(data.total_enrollments !== undefined ? data.total_enrollments : '-');
            $('#total-teachers-count').html(data.total_teachers);
            $('#total-courses-count').html(data.total_courses);
            // Categories count removed from UI
        },

        renderCharts: function(data) {
            var self = this;
            require(['core/chartjs'], function(ChartJS) {
                try {
                    self.renderCategoryChart(data.categories, ChartJS);
                    // New Activity Chart
                    if (data.activities_by_type) {
                        self.renderActivityChart(data.activities_by_type, ChartJS);
                    }
                } catch (e) {

                }
            });
        },

        renderCategoryChart: function(categories, ChartJS) {
            var isLight = document.querySelector('.smartdashboard-light') !== null;
            var chartTextColor = isLight ? '#374151' : '#e0e0e0';
            var chartGridColor = isLight ? 'rgba(0, 0, 0, 0.08)' : 'rgba(255, 255, 255, 0.08)';

            var canvasId = 'chart-enrollments-category';
            var $canvasContainer = $('#' + canvasId).parent();
            $('#' + canvasId).remove();
            $canvasContainer.append('<canvas id="' + canvasId + '"></canvas>'); // Recreate

            var ctx = document.getElementById(canvasId);
            if (!ctx) {
                return;
            }

            var sorted = categories.slice().sort(function(a, b) {
 return b.student_count - a.student_count;
});
            var top = sorted.slice(0, 10);

            var labels = top.map(function(c) {
 return c.name;
});
            var students = top.map(function(c) {
 return c.student_count;
});
            var activities = top.map(function(c) {
 return c.activity_count !== undefined ? c.activity_count : 0;
});

            new ChartJS(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Students',
                        data: students,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Activities',
                        data: activities,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {labels: {color: chartTextColor}}
                    },
                    scales: {
                        x: {ticks: {color: chartTextColor}, grid: {color: chartGridColor}},
                        y: {beginAtZero: true, ticks: {color: chartTextColor}, grid: {color: chartGridColor}}
                    }
                }
            });
        },

        renderActivityChart: function(activities, ChartJS) {
            var isLight = document.querySelector('.smartdashboard-light') !== null;
            var chartTextColor = isLight ? '#374151' : '#e0e0e0';
            
            var canvasId = 'chart-activities';
            var $canvasContainer = $('#' + canvasId).parent();
            $('#' + canvasId).remove();
            $canvasContainer.append('<canvas id="' + canvasId + '"></canvas>');

            var ctx = document.getElementById(canvasId);
            if (!ctx) {
                return;
            }

            // Prepare data
            // activities is object: {assessment: X, collaboration: Y, ...}
            var labels = [];
            var data = [];
            var colors = [
                'rgba(255, 99, 132, 0.7)', // Red
                'rgba(54, 162, 235, 0.7)', // Blue
                'rgba(255, 206, 86, 0.7)', // Yellow
                'rgba(75, 192, 192, 0.7)', // Teal
                'rgba(153, 102, 255, 0.7)', // Purple
                'rgba(255, 159, 64, 0.7)' // Orange
            ];

            // Capitalize labels
            for (var key in activities) {
                if (activities.hasOwnProperty(key)) {
                    var label = key.charAt(0).toUpperCase() + key.slice(1);
                    labels.push(label);
                    data.push(activities[key]);
                }
            }

            new ChartJS(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 1,
                        borderColor: isLight ? '#dee2e6' : '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {color: chartTextColor, boxWidth: 15}
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    var value = context.parsed;
                                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    var percentage = Math.round((value / total) * 100) + '%';
                                    return label + value + ' (' + percentage + ')';
                                }
                            }
                        }
                    }
                }
            });
        },

        renderTable: function(categories) {
            var $tbody = $('#admin-analytics-table tbody');
            $tbody.empty();

            if (categories.length === 0) {
                $tbody.append('<tr><td colspan="4" class="text-center text-muted">No data found for this filter.</td></tr>');
                return;
            }

            categories.forEach(function(cat) {
                // Ratio column removed
                var html = '<tr>';
                html += '<td>' + cat.name + '</td>';
                html += '<td class="text-center">' + cat.course_count + '</td>';
                html += '<td class="text-center bg-light fw-bold">' + cat.student_count + '</td>';
                html += '<td class="text-center">' + cat.teacher_count + '</td>';
                html += '</tr>';
                $tbody.append(html);
            });
        },

        exportToCSV: function() {
            var data = this.lastData;
            if (!data || !data.categories) {
                return;
            }

            var csv = [];
            // Updated header - remove Ratio
            csv.push('Category,Courses,Students,Teachers');

            data.categories.forEach(function(cat) {
                var row = [
                    '"' + cat.name.replace(/"/g, '""') + '"',
                    cat.course_count,
                    cat.student_count,
                    cat.teacher_count
                ];
                csv.push(row.join(','));
            });

            var csvString = csv.join('\n');
            var blob = new Blob([csvString], {type: 'text/csv;charset=utf-8;'});
            var url = URL.createObjectURL(blob);
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "system_analytics.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    };


    return AdminAnalytics;
});
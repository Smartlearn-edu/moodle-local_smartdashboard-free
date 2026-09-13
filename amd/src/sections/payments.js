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
 * Payment analytics section module.
 *
 * @module      local_smartdashboard/sections/payments
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/ajax', 'core/notification', 'core/str', 'local_smartdashboard/sections/settings'], function($, Ajax, Notification, Str, DashboardSettings) {
    var PaymentAnalytics = {
        init: function() {
            this.container = $('#section-payments');
            this.allCategories = []; // Store all categories for hierarchy
            this.chartStrings = {};
            var self = this;

            // Pre-load translatable chart title strings.
            Str.get_strings([
                {key: 'chart_revenue_distribution', component: 'local_smartdashboard'},
                {key: 'chart_students_revenue_category', component: 'local_smartdashboard'},
            ]).then(function(strings) {
                self.chartStrings.revenueDistribution = strings[0];
                self.chartStrings.studentsRevenueCategory = strings[1];
                return;
            }).catch(Notification.exception);

            this.filters = {
                categoryid: 0,
                time: 'all',
                gateway: ''
            };
            // Add "Load Data" button in the filter row
            var $filterRow = this.container.find('#btn-refresh-payments').closest('.row');
            var loadCol = $('<div class="col-md-2 d-flex align-items-end" id="load-payments-col">' +
                '<button id="btn-load-payments" class="btn btn-success w-100">' +
                '<i class="fa fa-download me-1"></i> Load Data</button></div>');
            $filterRow.append(loadCol);
            loadCol.find('#btn-load-payments').on('click', function() {
                $('#load-payments-col').remove();
                self.populateFilters();
                self.loadData();
                self.bindEvents();
            });
        },

        bindEvents: function() {
            var self = this;

            // Filter button
            this.container.find('#btn-refresh-payments').on('click', function() {
                self.readFilters();
                self.loadData();
            });

            // Toggle custom date fields when "Custom Range" is selected
            this.container.find('#payment-filter-time').on('change', function() {
                var val = $(this).val();
                if (val === 'custom') {
                    self.container.find('#payment-custom-dates-from').removeClass('d-none');
                    self.container.find('#payment-custom-dates-to').removeClass('d-none');
                } else {
                    self.container.find('#payment-custom-dates-from').addClass('d-none');
                    self.container.find('#payment-custom-dates-to').addClass('d-none');
                }
            });

            // Hierarchical category: Level 1 -> Level 2
            this.container.find('#payment-filter-category').on('change', function() {
                var parentId = parseInt($(this).val());
                self.populateSubcategories(parentId, '#payment-filter-subcategory', '#payment-subcat-wrapper');
                // Reset level 3
                self.container.find('#payment-subsubcat-wrapper').addClass('d-none');
                self.container.find('#payment-filter-subsubcategory').html('<option value="0">All</option>');
            });

            // Hierarchical category: Level 2 -> Level 3
            this.container.find('#payment-filter-subcategory').on('change', function() {
                var parentId = parseInt($(this).val());
                self.populateSubcategories(parentId, '#payment-filter-subsubcategory', '#payment-subsubcat-wrapper');
            });
        },

        populateSubcategories: function(parentId, selectSelector, wrapperSelector) {
            var self = this;
            var $select = this.container.find(selectSelector);
            var $wrapper = this.container.find(wrapperSelector);

            $select.html('<option value="0">All</option>');

            if (!parentId || parentId === 0) {
                $wrapper.addClass('d-none');
                return;
            }

            // Find children of this parent
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

        readFilters: function() {
            // Read the deepest selected category
            var cat3 = parseInt(this.container.find('#payment-filter-subsubcategory').val()) || 0;
            var cat2 = parseInt(this.container.find('#payment-filter-subcategory').val()) || 0;
            var cat1 = parseInt(this.container.find('#payment-filter-category').val()) || 0;

            // Use the most specific (deepest) non-zero category
            if (cat3 > 0) {
                this.filters.categoryid = cat3;
            } else if (cat2 > 0) {
                this.filters.categoryid = cat2;
            } else {
                this.filters.categoryid = cat1;
            }

            this.filters.time = this.container.find('#payment-filter-time').val();
            this.filters.gateway = this.container.find('#payment-filter-gateway').val() || '';
        },

        populateFilters: function() {
            var self = this;
            // Reuse system analytics to get categories structure
            Ajax.call([{
                methodname: 'local_smartdashboard_get_system_analytics',
                args: {categoryid: 0}
            }])[0].done(function(response) {
                if (response.filter_options && response.filter_options.categories) {
                    self.allCategories = response.filter_options.categories;

                    // Only show root (parent = 0) categories in the first dropdown
                    var $select = self.container.find('#payment-filter-category');
                    $select.find('option:not([value="0"])').remove(); // Keep "All"

                    response.filter_options.categories.forEach(function(c) {
                        if (c.parent === 0) {
                            $select.append('<option value="' + c.id + '">' + c.name + '</option>');
                        }
                    });
                }
            });
        },

        loadData: function() {
            var self = this;
            // Calculate timestamps
            var now = Math.floor(Date.now() / 1000);
            var from = 0;
            var to = now;

            switch (this.filters.time) {
                case 'today':
                    var d = new Date();
                    d.setHours(0, 0, 0, 0);
                    from = Math.floor(d.getTime() / 1000);
                    break;
                case 'week':
                    from = now - (7 * 86400);
                    break;
                case 'month':
                    from = now - (30 * 86400);
                    break;
                case 'year':
                    from = now - (365 * 86400);
                    break;
                case 'custom':
                    var fromStr = this.container.find('#payment-date-from').val();
                    var toStr = this.container.find('#payment-date-to').val();
                    if (fromStr) {
                        from = Math.floor(new Date(fromStr).getTime() / 1000);
                    }
                    if (toStr) {
                        // Set to end of day
                        var toDate = new Date(toStr);
                        toDate.setHours(23, 59, 59, 999);
                        to = Math.floor(toDate.getTime() / 1000);
                    }
                    break;
                case 'all':
                    from = 0;
                    break;
            }

            // Show loading state?
            this.container.find('#payment-total-revenue').text('Loading...');

            // Read payment mode from settings
            var paymentMode = DashboardSettings.getPaymentMode();

            return Ajax.call([{
                methodname: 'local_smartdashboard_get_payment_analytics',
                args: {
                    categoryid: this.filters.categoryid,
                    fromdate: from,
                    todate: to,
                    payment_mode: paymentMode,
                    gateway: this.filters.gateway
                }
            }])[0].done(function(response) {
                self.populateGateways(response.gateways || []);
                self.render(response);
            }).fail(function(ex) {
                Notification.exception(ex);
                self.container.find('#payment-total-revenue').text('Error');
            });
        },

        populateGateways: function(gateways) {
            var $select = this.container.find('#payment-filter-gateway');
            var currentVal = $select.val();
            // Only repopulate if empty (first load) to avoid resetting user selection
            if ($select.find('option').length <= 1) {
                $select.html('<option value="">All Gateways</option>');
                gateways.forEach(function(gw) {
                    var name = gw.name;
                    var label = name.charAt(0).toUpperCase() + name.slice(1);
                    $select.append('<option value="' + name + '">' + label + '</option>');
                });
                // Restore previous selection if it still exists
                if (currentVal) {
                    $select.val(currentVal);
                }
            }
        },

        render: function(data) {
            this.lastData = data; // Store for export
            // Metrics
            var hideCurrency = DashboardSettings.getHideCurrency();
            $('#payment-total-students').text(data.total_students);
            var revenueDisplay = hideCurrency
                ? Number(data.total_revenue).toLocaleString(undefined, {minimumFractionDigits: 2})
                : data.currency + ' ' + Number(data.total_revenue).toLocaleString(undefined, {minimumFractionDigits: 2});
            $('#payment-total-revenue').text(revenueDisplay);

            // Render Charts
            this.renderCharts(data);

            // Render Category Table
            this.renderCategoryTable(data.categories, data.total_revenue, data.currency);

            // Render Course Table
            this.renderTable(data.courses, data.currency);

            // Export button
            var self = this;
            this.container.find('#btn-export-payments').remove();
            var exportHtml = '<div class="d-flex justify-content-end mt-3 mb-4" id="btn-export-payments">';
            exportHtml += '<button class="btn btn-outline-secondary">';
            exportHtml += '<i class="fa fa-download me-1"></i> Export Payment Report</button>';
            exportHtml += '</div>';
            this.container.find('#payment-table-body').closest('.card').after(exportHtml);
            this.container.find('#btn-export-payments button').on('click', function() {
                self.exportToCSV();
            });
        },

        renderCharts: function(data) {
            var self = this;
            require(['core/chartjs'], function(ChartJS) {
                // Chart 1: Revenue per Category (Pie)
                self.renderRevenuePie(data.categories, ChartJS);

                // Chart 2: Students vs Revenue per Category (Multi-Axis Bar)
                self.renderCategoryDualAxis(data.categories, ChartJS);
            });
        },

        renderRevenuePie: function(categories, ChartJS) {
            var isLight = document.querySelector('.smartdashboard-light') !== null;
            var chartTextColor = isLight ? '#374151' : '#e0e0e0';
            var chartGridColor = isLight ? 'rgba(0, 0, 0, 0.08)' : 'rgba(255, 255, 255, 0.08)';
            var chartTitleColor = isLight ? '#1e293b' : '#ffffff';

            var canvasId = 'chart-payment-revenue';
            var $container = $('#' + canvasId).parent();
            $('#' + canvasId).remove();
            $container.append('<canvas id="' + canvasId + '"></canvas>');
            var ctx = document.getElementById(canvasId);

            var labels = categories.map(function(c) {
 return c.name;
});
            var data = categories.map(function(c) {
 return c.revenue;
});

            new ChartJS(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {color: chartTextColor}
                        },
                        title: {
                            display: true,
                            text: self.chartStrings.revenueDistribution || 'Revenue Distribution',
                            color: chartTitleColor
                        }
                    }
                }
            });
        },

        renderCategoryDualAxis: function(categories, ChartJS) {
            var isLight = document.querySelector('.smartdashboard-light') !== null;
            var chartTextColor = isLight ? '#374151' : '#e0e0e0';
            var chartGridColor = isLight ? 'rgba(0, 0, 0, 0.08)' : 'rgba(255, 255, 255, 0.08)';
            var chartTitleColor = isLight ? '#1e293b' : '#ffffff';

            var canvasId = 'chart-payment-students';
            var $container = $('#' + canvasId).parent();
            $('#' + canvasId).remove();
            $container.append('<canvas id="' + canvasId + '"></canvas>');
            var ctx = document.getElementById(canvasId);

            var labels = categories.map(function(c) {
 return c.name;
});
            var students = categories.map(function(c) {
 return c.student_count;
});
            var revenue = categories.map(function(c) {
 return c.revenue;
});

            new ChartJS(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Students',
                            data: students,
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            order: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Revenue',
                            data: revenue,
                            borderColor: '#FF6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            type: 'line',
                            order: 0,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {color: chartTextColor}
                        },
                        title: {
                            display: true,
                            text: self.chartStrings.studentsRevenueCategory || 'Students & Revenue per Category',
                            color: chartTitleColor
                        }
                    },
                    scales: {
                        x: {
                            ticks: {color: chartTextColor},
                            grid: {color: chartGridColor}
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {display: true, text: 'Students', color: chartTextColor},
                            ticks: {color: chartTextColor},
                            grid: {color: chartGridColor}
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: {drawOnChartArea: false},
                            title: {display: true, text: 'Revenue', color: chartTextColor},
                            ticks: {color: chartTextColor}
                        }
                    }
                }
            });
        },

        renderCategoryTable: function(categories, totalRevenue, currency) {
            var $tbody = $('#payment-category-table-body');
            $tbody.empty();

            var hideCurrency = DashboardSettings.getHideCurrency();

            if (!categories || categories.length === 0) {
                $tbody.append('<tr><td colspan="5" class="text-center text-muted">No category data found.</td></tr>');
                return;
            }

            categories.forEach(function(c) {
                // Calculate % of Total
                var percent = (totalRevenue > 0) ? ((c.revenue / totalRevenue) * 100).toFixed(1) : '0.0';

                var revenueText = hideCurrency
                    ? Number(c.revenue).toLocaleString(undefined, {minimumFractionDigits: 2})
                    : currency + ' ' + Number(c.revenue).toLocaleString(undefined, {minimumFractionDigits: 2});

                var html = '<tr>';
                html += '<td>' + c.name + '</td>';
                html += '<td class="text-center">' + (c.course_count || 0) + '</td>'; // Use course_count from backend
                html += '<td class="text-center">' + c.student_count + '</td>';
                html += '<td class="text-end fw-bold">' + revenueText + '</td>';

                // Add Sparkline-like bar for %
                var barColor = 'secondary';
                if (percent > 50) {
                    barColor = 'success';
                } else if (percent > 20) {
                    barColor = 'info';
                }
                html += '<td class="text-end">';
                html += '<div class="d-flex align-items-center justify-content-end">';
                html += '<span class="me-2">' + percent + '%</span>';
                html += '<div class="progress" style="width: 50px; height: 6px;">';
                html += '<div class="progress-bar bg-' + barColor + '" role="progressbar" ';
                html += 'style="width: ' + percent + '%"';
                html += ' aria-valuenow="' + percent + '" aria-valuemin="0" aria-valuemax="100"></div>';
                html += '</div>';
                html += '</div>';
                html += '</td>';

                html += '</tr>';
                $tbody.append(html);
            });
        },

        renderTable: function(courses, currency) {
            var $tbody = $('#payment-table-body');
            $tbody.empty();

            var hideCurrency = DashboardSettings.getHideCurrency();

            if (!courses || courses.length === 0) {
                $tbody.append('<tr><td colspan="5" class="text-center text-muted">No paid enrollments found.</td></tr>');
                return;
            }

            courses.forEach(function(c) {
                var html = '<tr>';
                html += '<td>' + c.name + '</td>';
                html += '<td>' + (c.shortname || '') + '</td>';
                html += '<td class="text-center">' + c.student_count + '</td>';

                // Payment breakdown column
                var breakdownHtml = '';
                if (hideCurrency) {
                    // Show the enrollment fee (cost per student), not total revenue
                    if (c.payment_breakdown && c.payment_breakdown.length > 0) {
                        c.payment_breakdown.forEach(function(pb) {
                            var amt = Number(pb.amount).toLocaleString(undefined, {minimumFractionDigits: 2});
                            breakdownHtml += '<div>' + amt + '</div>';
                        });
                    } else if (c.student_count > 0 && c.revenue > 0) {
                        var fee = c.revenue / c.student_count;
                        breakdownHtml = Number(fee).toLocaleString(undefined, {minimumFractionDigits: 2});
                    } else {
                        breakdownHtml = '0.00';
                    }
                } else if (c.payment_breakdown && c.payment_breakdown.length > 0) {
                    c.payment_breakdown.forEach(function(pb) {
                        var amt = Number(pb.amount).toLocaleString(undefined, {minimumFractionDigits: 2});
                        breakdownHtml += '<div>' + pb.count + ' &times; ' + amt + ' ' + pb.currency + '</div>';
                    });
                } else if (c.student_count > 0 && c.revenue > 0) {
                    // Fallback: calculate cost per student from revenue / enrollments
                    var costPerStudent = c.revenue / c.student_count;
                    var amt = Number(costPerStudent).toLocaleString(undefined, {minimumFractionDigits: 2});
                    breakdownHtml = '<div>' + c.student_count + ' &times; ' + amt + ' ' + currency + '</div>';
                } else {
                    var formatted = Number(c.revenue).toLocaleString(undefined, {minimumFractionDigits: 2});
                    breakdownHtml = hideCurrency ? formatted : currency + ' ' + formatted;
                }
                html += '<td>' + breakdownHtml + '</td>';

                // Total revenue column
                var revenueText = hideCurrency
                    ? Number(c.revenue).toLocaleString(undefined, {minimumFractionDigits: 2})
                    : currency + ' ' + Number(c.revenue).toLocaleString(undefined, {minimumFractionDigits: 2});
                html += '<td class="text-end fw-bold">' + revenueText + '</td>';
                html += '</tr>';
                $tbody.append(html);
            });
        },

        exportToCSV: function() {
            var data = this.lastData;
            if (!data || !data.courses || data.courses.length === 0) {
                Notification.alert('No Data', 'There is no payment data to export.', 'OK');
                return;
            }

            var currency = data.currency || '';
            var csv = [];
            var hideCurrency = DashboardSettings.getHideCurrency();

            // Header
            csv.push('Course Name,Short Name,Paid Enrollments,Payment Breakdown,Total Revenue' + (hideCurrency ? '' : ',Currency'));

            data.courses.forEach(function(c) {
                var courseName = '"' + (c.name || '').replace(/"/g, '""') + '"';
                var shortName = '"' + (c.shortname || '').replace(/"/g, '""') + '"';

                // Build breakdown text
                var breakdownText = '';
                if (hideCurrency) {
                    // Show enrollment fee, not total revenue
                    if (c.payment_breakdown && c.payment_breakdown.length > 0) {
                        var fees = [];
                        c.payment_breakdown.forEach(function(pb) {
                            fees.push(Number(pb.amount).toFixed(2));
                        });
                        breakdownText = fees.join(' / ');
                    } else if (c.student_count > 0 && c.revenue > 0) {
                        breakdownText = (c.revenue / c.student_count).toFixed(2);
                    } else {
                        breakdownText = '0.00';
                    }
                } else if (c.payment_breakdown && c.payment_breakdown.length > 0) {
                    var parts = [];
                    c.payment_breakdown.forEach(function(pb) {
                        parts.push(pb.count + ' x ' + Number(pb.amount).toFixed(2) + ' ' + pb.currency);
                    });
                    breakdownText = '"' + parts.join(', ') + '"';
                } else if (c.student_count > 0 && c.revenue > 0) {
                    var cost = (c.revenue / c.student_count).toFixed(2);
                    breakdownText = '"' + c.student_count + ' x ' + cost + ' ' + currency + '"';
                } else {
                    breakdownText = '""';
                }

                var row = [
                    courseName,
                    shortName,
                    c.student_count,
                    breakdownText,
                    Number(c.revenue).toFixed(2)
                ];
                if (!hideCurrency) {
                    row.push(currency);
                }
                csv.push(row.join(','));
            });

            // Summary row
            csv.push('');
            var totalStr = '"TOTAL",,' + data.total_students + ',,' + Number(data.total_revenue).toFixed(2);
            csv.push(totalStr + (hideCurrency ? '' : ',' + currency));

            var csvString = csv.join('\n');
            var BOM = '\uFEFF'; // UTF-8 BOM for Arabic/special characters in Excel
            var blob = new Blob([BOM + csvString], {type: 'text/csv;charset=utf-8;'});
            var url = URL.createObjectURL(blob);
            var link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', 'payment_report.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    };


    return PaymentAnalytics;
});
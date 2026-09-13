define(['jquery', 'core/ajax', 'core/notification'], function($, Ajax, Notification) {
    var MagicReports = {
        chartInstance: null,
        currentReport: null,

        init: function() {
            var self = this;
            this.container = $('#section-magic');

            // Generate Button
            this.container.find('#btn-magic-run').off('click').on('click', function() {
                var prompt = self.container.find('#magic-prompt').val();
                if (prompt && prompt.trim()) {
                    self.runQuery(prompt);
                } else {
                    Notification.addNotification({
                        message: 'Please enter a question first.',
                        type: 'warning'
                    });
                }
            });

            // Save Button
            this.container.find('#btn-save-report').off('click').on('click', function() {
                self.saveReport();
            });

            // Initial load of saved reports
            this.loadSavedReports();
        },

        runQuery: function(prompt) {
            var self = this;
            var $btn = this.container.find('#btn-magic-run');
            var originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Thinking...');
            $('#magic-results-area').hide();

            Ajax.call([{
                methodname: 'local_smartdashboard_get_magic_insight',
                args: {prompt: prompt}
            }])[0].done(function(response) {
                $btn.prop('disabled', false).html(originalText);
                self.renderResults(response);
            }).fail(function(ex) {
                $btn.prop('disabled', false).html(originalText);
                Notification.exception(ex);
            });
        },

        renderResults: function(response) {
            var self = this;
            $('#magic-results-area').fadeIn();

            // Explanation & SQL
            $('#magic-explanation').text(response.explanation);
            $('#magic-sql-code').text(response.sql);

            // Store current report context for saving
            this.currentReport = {
                sql: response.sql,
                chart_type: response.chart_type,
                title: $('#magic-prompt').val().substring(0, 50) + '...'
            };

            // Parse Data
            var data = [];
            try {
                data = JSON.parse(response.data);
            } catch (e) {

            }

            // Render Table
            var $table = $('#magic-table');
            var $thead = $table.find('thead');
            var $tbody = $table.find('tbody');
            $thead.empty();
            $tbody.empty();

            if (data.length > 0) {
                // Generate headers from first row keys
                var keys = Object.keys(data[0]);
                var headerHtml = '<tr>';
                keys.forEach(function(k) {
                    // Capitalize and replace underscores
                    var displayKeys = k.charAt(0).toUpperCase() + k.slice(1).replace(/_/g, ' ');
                    headerHtml += '<th>' + displayKeys + '</th>';
                });
                headerHtml += '</tr>';
                $thead.append(headerHtml);

                // Generate rows
                data.forEach(function(row) {
                    var rowHtml = '<tr>';
                    keys.forEach(function(k) {
                        var val = row[k] !== null ? row[k] : '-';
                        rowHtml += '<td>' + val + '</td>';
                    });
                    rowHtml += '</tr>';
                    $tbody.append(rowHtml);
                });

                // Render Chart based on AI recommendation
                if (response.chart_type && response.chart_type !== 'none') {
                    self.renderChart(data, response.chart_type, response.chart_label_column, response.chart_value_column);
                } else {
                    $('#magic-chart-container').hide();
                }
            } else {
                $tbody.append('<tr><td colspan="5" class="text-center text-muted">No results found.</td></tr>');
                $('#magic-chart-container').hide();
            }
        },

        renderChart: function(data, chartType, labelColumn, valueColumn) {
            var self = this;
            var isLight = document.querySelector('.smartdashboard-light') !== null;
            var chartTextColor = isLight ? '#374151' : '#e0e0e0';
            var chartGridColor = isLight ? 'rgba(0, 0, 0, 0.06)' : 'rgba(255, 255, 255, 0.06)';

            // Fallback: if AI didn't provide columns, try to guess
            if (!labelColumn || !valueColumn) {
                var keys = Object.keys(data[0]);
                labelColumn = labelColumn || keys.find(function(k) {
 return isNaN(data[0][k]);
});
                valueColumn = valueColumn || keys.find(function(k) {
 return !isNaN(data[0][k]);
});
            }

            var container = $('#magic-chart-container');

            if (!labelColumn || !valueColumn) {
                container.hide();
                return;
            }

            container.show();

            // Ensure canvas is fresh
            var canvasParent = container.find('.chart-wrapper');
            if (canvasParent.length === 0) {
                canvasParent = container;
            }
            canvasParent.find('canvas').remove();
            canvasParent.append('<canvas id="magic-chart-canvas" style="max-height:350px;"></canvas>');

            var ctx = document.getElementById('magic-chart-canvas').getContext('2d');

            // Destroy old instance if exists
            if (this.chartInstance) {
                this.chartInstance.destroy();
            }

            var labels = data.map(function(d) {
 return d[labelColumn];
});
            var values = data.map(function(d) {
 return parseFloat(d[valueColumn]) || 0;
});

            // Beautiful color palette
            var palette = [
                'rgba(99, 102, 241, 0.8)', // Indigo
                'rgba(16, 185, 129, 0.8)', // Emerald
                'rgba(245, 158, 11, 0.8)', // Amber
                'rgba(239, 68, 68, 0.8)', // Red
                'rgba(59, 130, 246, 0.8)', // Blue
                'rgba(168, 85, 247, 0.8)', // Purple
                'rgba(236, 72, 153, 0.8)', // Pink
                'rgba(20, 184, 166, 0.8)', // Teal
                'rgba(249, 115, 22, 0.8)', // Orange
                'rgba(34, 197, 94, 0.8)', // Green
                'rgba(6, 182, 212, 0.8)', // Cyan
                'rgba(139, 92, 246, 0.8)', // Violet
            ];
            var borderPalette = palette.map(function(c) {
 return c.replace('0.8', '1');
});

            var isPieType = (chartType === 'pie' || chartType === 'doughnut');

            var datasets;
            if (isPieType) {
                datasets = [{
                    data: values,
                    backgroundColor: palette.slice(0, values.length),
                    borderColor: borderPalette.slice(0, values.length),
                    borderWidth: 2,
                    hoverOffset: 8
                }];
            } else {
                datasets = [{
                    label: valueColumn.replace(/_/g, ' '),
                    data: values,
                    backgroundColor: chartType === 'line' ? 'rgba(99, 102, 241, 0.15)' : 'rgba(99, 102, 241, 0.6)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    borderRadius: chartType === 'bar' ? 6 : 0,
                    fill: chartType === 'line',
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: chartType === 'line' ? 5 : 0,
                    pointHoverRadius: chartType === 'line' ? 7 : 0
                }];
            }

            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: isPieType,
                        position: 'bottom',
                        labels: {
                            color: chartTextColor,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {size: 12}
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 30, 50, 0.95)',
                        titleColor: isLight ? '#1e293b' : '#fff',
                        bodyColor: chartTextColor,
                        borderColor: 'rgba(99, 102, 241, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: true
                    }
                }
            };

            // Add scales only for non-pie charts
            if (!isPieType) {
                chartOptions.scales = {
                    y: {
                        beginAtZero: true,
                        grid: {color: chartGridColor},
                        ticks: {
                            color: chartTextColor,
                            font: {size: 11}
                        }
                    },
                    x: {
                        grid: {display: false},
                        ticks: {
                            color: chartTextColor,
                            font: {size: 11},
                            maxRotation: 45
                        }
                    }
                };
            }

            require(['core/chartjs'], function(ChartJS) {
                self.chartInstance = new ChartJS(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: chartOptions
                });
            });
        },

        saveReport: function() {
            var self = this;
            if (!this.currentReport) {
                return;
            }

            // Simple browser prompt for title
            var title = prompt("Enter a title for this report:", "My Magic Report");

            if (title) {
                Ajax.call([{
                    methodname: 'local_smartdashboard_save_magic_report',
                    args: {
                        title: title,
                        sql_query: this.currentReport.sql,
                        chart_type: this.currentReport.chart_type
                    }
                }])[0].done(function() {
                    Notification.addNotification({
                        message: 'Report saved successfully!',
                        type: 'success'
                    });
                    self.loadSavedReports();
                }).fail(Notification.exception);
            }
        },

        deleteReport: function(id, title) {
            var self = this;
            if (confirm('Are you sure you want to delete report: "' + title + '"?')) {
                Ajax.call([{
                    methodname: 'local_smartdashboard_delete_magic_report',
                    args: {reportid: id}
                }])[0].done(function() {
                    Notification.addNotification({
                        message: 'Report deleted.',
                        type: 'info'
                    });
                    self.loadSavedReports();
                }).fail(Notification.exception);
            }
        },

        loadSavedReports: function() {
            var self = this;
            var $list = $('#saved-reports-list');
            $list.html('<div class="text-center p-3 text-muted small"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

            Ajax.call([{
                methodname: 'local_smartdashboard_get_saved_reports',
                args: {}
            }])[0].done(function(reports) {
                $list.empty();
                if (reports.length === 0) {
                    $list.append('<div class="p-3 text-center small text-muted">No saved reports yet.</div>');
                } else {
                    reports.forEach(function(r) {
                        var itemClass = "list-group-item list-group-item-action border-0 mb-1 rounded d-flex ";
                        itemClass += "justify-content-between align-items-center bg-light";
                        var itemHtml = '<div class="' + itemClass + '" style="cursor: pointer;">';
                        itemHtml += '<div class="text-truncate flex-grow-1 user-select-none report-item-click" ';
                        itemHtml += 'title="' + r.title + '">';
                        itemHtml += '<h6 class="mb-0 text-truncate">' + r.title + '</h6>';
                        itemHtml += '<small class="text-muted"><i class="fa fa-bar-chart me-1"></i> Saved Report</small></div>';

                        itemHtml += '<button class="btn btn-sm btn-link text-danger p-0 delete-report-btn ms-2" ';
                        itemHtml += 'title="Delete Report">';
                        itemHtml += '<i class="fa fa-trash"></i>';
                        itemHtml += '</button>';
                        itemHtml += '</div>';

                        var $item = $(itemHtml);

                        $item.find('.report-item-click').on('click', function(e) {
                            e.preventDefault();
                            $('#magic-prompt').val(r.title);
                            $('#btn-magic-run').click();
                        });

                        $item.find('.delete-report-btn').on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            self.deleteReport(r.id, r.title);
                        });

                        $list.append($item);
                    });
                }
            });
        }
    };


    return MagicReports;
});
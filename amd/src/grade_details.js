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
 * AMD module for AI modal analysis.
 *
 * @module     local_smartdashboard/ai_modal
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/ajax', 'core/str'], function($, Ajax, Str) {

    return {
        init: function() {
            var loadingText = 'Talking to Moodle AI...';
            var generatingText = 'Generating Analysis...';
            var printText = 'Print';
            var downloadPdfText = 'Download PDF';
            var successText = 'Success';
            var unknownErrorText = 'Unknown error occurred';
            var commErrorText = 'Communication Error';

            // Pre-fetch strings
            var stringPromise = Str.get_strings([
                {key: 'talkingtocoreai', component: 'local_smartdashboard'},
                {key: 'generatinganalysis', component: 'local_smartdashboard'},
                {key: 'print', component: 'core'},
                {key: 'downloadpdf', component: 'local_smartdashboard'},
                {key: 'communicationerror', component: 'local_smartdashboard'},
                {key: 'success', component: 'local_smartdashboard'},
                {key: 'unknownerror', component: 'local_smartdashboard'}
            ]);

            stringPromise.done(function(strings) {
                loadingText = strings[0];
                generatingText = strings[1];
                printText = strings[2];
                downloadPdfText = strings[3];
                commErrorText = strings[4];
                successText = strings[5];
                unknownErrorText = strings[6];
            }).fail(function(ex) {
                console.warn('local_smartdashboard: Failed to load language strings. Using defaults.', ex);
            });

            // Event delegation guarantees binding even if the button is rendered late
            $(document).on('click', '#btn-moodle-ai-test', function(e) {
                e.preventDefault();
                var triggerBtn = $(this);
                var userid = triggerBtn.data('userid');
                var resultsContainer = $('#ai-inline-results-container');

                // Update UI to loading state
                triggerBtn.prop('disabled', true);
                triggerBtn.html('<i class="fa fa-spinner fa-spin"></i> ' + generatingText);
                
                resultsContainer.show().html('<div class="text-center" style="padding:20px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw text-primary"></i><p class="mt-3">' + loadingText + '</p></div>');

                Ajax.call([{
                    methodname: 'local_smartdashboard_test_ai',
                    args: {
                        userid: userid
                    },
                    done: function(response) {
                        triggerBtn.prop('disabled', false);
                        triggerBtn.text('Refresh Analysis'); // Keep it simple

                        if (response && response.success) {
                            var aiContent = response.message || successText;
                            
                            // Strip any accidental markdown formatting the AI might add
                            aiContent = aiContent.replace(/^```html\s*/i, '');
                            aiContent = aiContent.replace(/^```\s*/i, '');
                            aiContent = aiContent.replace(/```\s*$/i, '');

                            var contentHtml = '<div id="ai-analysis-content">' + aiContent + '</div>';
                            var controlsHtml = '<div style="margin-top:20px; text-align:right; border-top:1px solid var(--bs-border-color, #dee2e6); padding-top:15px;">' +
                                '<button class="btn btn-secondary me-2" id="btn-print-analysis" style="margin-right:10px;"><i class="fa fa-print"></i> ' + printText + '</button> ' +
                                '<button class="btn btn-primary" id="btn-download-pdf"><i class="fa fa-file-pdf-o"></i> ' + downloadPdfText + '</button>' +
                                '</div>';
                            
                            resultsContainer.html(contentHtml + controlsHtml);

                            setTimeout(function() {
                                $('#btn-print-analysis').on('click', function() {
                                    var printWindow = window.open('', '', 'height=600,width=800');
                                    printWindow.document.write('<html><head><title>AI Analysis</title>');
                                    printWindow.document.write('<style>body{font-family:sans-serif; padding:20px;}</style>');
                                    printWindow.document.write('</head><body>');
                                    printWindow.document.write($('#ai-analysis-content').html());
                                    printWindow.document.write('</body></html>');
                                    printWindow.document.close();
                                    printWindow.print();
                                });

                                $('#btn-download-pdf').on('click', function() {
                                    var form = $('<form action="download_pdf.php" method="post" target="_blank">' +
                                        '<input type="hidden" name="action" value="downloadpdf">' +
                                        '<input type="hidden" name="userid" value="' + userid + '">' +
                                        '<textarea name="html_content" style="display:none;">' + $('#ai-analysis-content').html() + '</textarea>' +
                                        '</form>');
                                    $('body').append(form);
                                    form.submit();
                                    form.remove();
                                });
                            }, 100);
                        } else {
                            var errMsg = (response && response.message) ? response.message : unknownErrorText;
                            resultsContainer.html('<div class="alert alert-danger">' + errMsg + '</div>');
                        }
                    },
                    fail: function(ex) {
                        triggerBtn.prop('disabled', false);
                        triggerBtn.text('Try Again');
                        var errorStr = ex ? (ex.error || ex.message || JSON.stringify(ex)) : 'Unknown error';
                        resultsContainer.html('<div class="alert alert-danger">' + commErrorText + ': ' + errorStr + '</div>');
                    }
                }]);
            });
        }
    };
});

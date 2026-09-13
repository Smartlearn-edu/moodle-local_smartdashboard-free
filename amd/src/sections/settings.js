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
 * Dashboard settings section module.
 *
 * @module      local_smartdashboard/sections/settings
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/ajax', 'core/notification'], function($, Ajax, Notification) {
    var DashboardSettings = {
        paymentMode: 'actual', // Default
        hideCurrency: false, // Default

        init: function() {
            var self = this;
            this.container = $('#section-settings');

            // Show/hide estimated options based on radio selection
            this.container.find('input[name="payment_mode"]').on('change', function() {
                if ($(this).val() === 'estimated') {
                    self.container.find('#estimated-options').show();
                } else {
                    self.container.find('#estimated-options').hide();
                }
            });

            // Load saved settings from server
            Ajax.call([{
                methodname: 'local_smartdashboard_get_dashboard_settings',
                args: {}
            }])[0].done(function(response) {
                self.paymentMode = response.payment_mode || 'actual';
                self.hideCurrency = !!response.hide_currency;
                // Set the radio button
                self.container.find('input[name="payment_mode"][value="' + self.paymentMode + '"]').prop('checked', true);
                // Set the checkbox
                self.container.find('#setting-hide-currency').prop('checked', self.hideCurrency);
                // Show/hide estimated options
                if (self.paymentMode === 'estimated') {
                    self.container.find('#estimated-options').show();
                } else {
                    self.container.find('#estimated-options').hide();
                }
            }).fail(function() {
                // Use defaults if loading fails
                self.paymentMode = 'actual';
                self.hideCurrency = false;
                self.container.find('#estimated-options').hide();
            });

            // Save button
            this.container.find('#btn-save-settings').on('click', function() {
                self.save();
            });
        },

        save: function() {
            var self = this;
            var mode = this.container.find('input[name="payment_mode"]:checked').val() || 'actual';
            var hideCurr = this.container.find('#setting-hide-currency').is(':checked');
            var $status = this.container.find('#settings-save-status');
            var $btn = this.container.find('#btn-save-settings');

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');
            $status.text('');

            Ajax.call([{
                methodname: 'local_smartdashboard_save_dashboard_settings',
                args: {
                    payment_mode: mode,
                    hide_currency: hideCurr
                }
            }])[0].done(function(response) {
                self.paymentMode = response.payment_mode;
                self.hideCurrency = !!response.hide_currency;
                $btn.prop('disabled', false).html('<i class="fa fa-save me-1"></i> Save Settings');
                $status.html('<i class="fa fa-check text-success me-1"></i> Settings saved!');
                $status.removeClass('text-danger').addClass('text-success');

                // Reset PaymentAnalytics loaded state so it re-fetches with new mode
                $('#section-payments').data('loaded', false);

                setTimeout(function() {
                    $status.text('');
                }, 3000);
            }).fail(function(ex) {
                $btn.prop('disabled', false).html('<i class="fa fa-save me-1"></i> Save Settings');
                $status.html('<i class="fa fa-times text-danger me-1"></i> Failed to save.');
                $status.removeClass('text-success').addClass('text-danger');
                Notification.exception(ex);
            });
        },

        getPaymentMode: function() {
            return this.paymentMode;
        },

        getHideCurrency: function() {
            return this.paymentMode === 'estimated' && this.hideCurrency;
        }
    };


    return DashboardSettings;
});
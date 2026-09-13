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
 * Core utility functions for Smart Dashboard.
 *
 * @module      local_smartdashboard/core/utils
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    var LoadPrompt = {
        show: function(container, sectionName, icon, callback) {
            var html = '<div class="load-prompt text-center py-3">';
            html += '<button class="btn btn-primary px-4 load-data-btn">';
            html += '<i class="fa fa-download me-2"></i>Load ' + sectionName + '</button>';
            html += '</div>';
            container.find('.load-prompt').remove();
            container.prepend(html);
            container.find('.load-data-btn').on('click', function() {
                container.find('.load-prompt').remove();
                callback();
            });
        }
    };


    return {LoadPrompt: LoadPrompt};
});
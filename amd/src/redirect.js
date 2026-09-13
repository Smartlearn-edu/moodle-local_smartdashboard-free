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
 * Redirect AMD module for Smart Dashboard.
 *
 * @module      local_smartdashboard/redirect
 * @copyright   2026 SmartLearn
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {
    return {
        init: function(dashboardUrl) {
            document.addEventListener("DOMContentLoaded", function() {
                // 1. Rewrite existing links
                var dashLinks = document.querySelectorAll("a[href*='/my/']");
                dashLinks.forEach(function(link) {
                    try {
                        var linkUrl = new URL(link.href, window.location.origin);
                        if (linkUrl.pathname === "/my/" || linkUrl.pathname === "/my" || linkUrl.pathname === "/my/index.php") {
                            link.href = dashboardUrl;
                        }
                    } catch(e) {}
                });
                
                // 2. Catch any clicks (handles dynamically added links)
                document.addEventListener("click", function(e) {
                    var link = e.target.closest("a");
                    if (link && link.href) {
                        try {
                            var linkUrl = new URL(link.href, window.location.origin);
                            if (linkUrl.pathname === "/my/" || linkUrl.pathname === "/my" || linkUrl.pathname === "/my/index.php") {
                                e.preventDefault();
                                window.location.href = dashboardUrl;
                            }
                        } catch (err) {}
                    }
                });
            });
        }
    };
});

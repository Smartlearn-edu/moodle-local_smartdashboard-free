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
 * Main AMD module for Smart Dashboard.
 *
 * @module      local_smartdashboard/main
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {

    /** Mobile breakpoint in pixels. */
    var MOBILE_BREAKPOINT = 768;

    /** Whether the mobile drawer is currently open. */
    var drawerOpen = false;

    /** Reference to the backdrop element. */
    var $backdrop = null;

    /**
     * Check if we are in mobile viewport.
     * @return {boolean}
     */
    function isMobile() {
        return window.innerWidth < MOBILE_BREAKPOINT;
    }

    /**
     * Open the mobile sidebar drawer.
     */
    function openMobileDrawer() {
        if (drawerOpen) {
            return;
        }
        drawerOpen = true;

        var $sidebar = $('#sidebar-col');

        // Show backdrop.
        if (!$backdrop) {
            $backdrop = $('<div class="smartdashboard-sidebar-backdrop"></div>');
            $('body').append($backdrop);
        }
        // Force reflow before adding active class for CSS transition.
        $backdrop[0].offsetHeight;
        $backdrop.addClass('active');

        // Open drawer.
        $sidebar.addClass('smartdashboard-drawer-open');

        // Body scroll lock.
        document.body.style.overflow = 'hidden';

        // ARIA updates.
        $sidebar.attr('aria-hidden', 'false');

        // Focus the first nav link (initial focus).
        var $firstLink = $sidebar.find('#dashboard-sidebar-nav .nav-link').first();
        if ($firstLink.length) {
            setTimeout(function() {
                $firstLink[0].focus();
            }, 100);
        }

        // Bind backdrop click.
        $backdrop.off('click.smartdashboard').on('click.smartdashboard', function(e) {
            e.stopPropagation();
            closeMobileDrawer();
        });
    }

    /**
     * Close the mobile sidebar drawer and restore focus.
     */
    function closeMobileDrawer() {
        if (!drawerOpen) {
            return;
        }
        drawerOpen = false;

        var $sidebar = $('#sidebar-col');

        // Close drawer.
        $sidebar.removeClass('smartdashboard-drawer-open');

        // Hide backdrop.
        if ($backdrop) {
            $backdrop.removeClass('active');
        }

        // Restore body scroll.
        document.body.style.overflow = '';

        // ARIA updates.
        $sidebar.attr('aria-hidden', 'true');

        // Return focus to the floating mobile toggle button.
        var $mobileToggle = $('.smartdashboard-mobile-toggle');
        if ($mobileToggle.length) {
            $mobileToggle[0].focus();
        }
    }

    return {
        init: function() {
            // Sidebar Toggle Logic (Vanilla JS with capture to bypass Moodle 5.2 event blocking)
            var $dashboardContainer = $('.dashboard-container');

            // Check localStorage (only collapse on desktop, never on mobile)
            if (!isMobile()) {
                var isCollapsed = localStorage.getItem('smartdashboard_sidebar_collapsed') === 'true';
                if (isCollapsed) {
                    $dashboardContainer.addClass('sidebar-collapsed');
                }
            }

            // --- Mobile: Set initial ARIA state ---
            if (isMobile()) {
                $('#sidebar-col').attr('aria-hidden', 'true');
            }

            // --- Mobile: Inject floating toggle button ---
            if ($('.smartdashboard-mobile-toggle').length === 0) {
                var $mobileToggle = $('<button class="smartdashboard-mobile-toggle" ' +
                    'aria-label="Open Dashboard Navigation" ' +
                    'aria-controls="sidebar-col" type="button">' +
                    '<i class="fa fa-bars"></i></button>');
                $dashboardContainer.append($mobileToggle);
            }

            // --- Fallback: Ensure close button exists inside sidebar header ---
            if ($('#sidebar-close-btn').length === 0) {
                var $header = $('#sidebar-col .smartdashboard-sidebar .d-flex').first();
                if ($header.length) {
                    var $closeBtn = $('<button id="sidebar-close-btn" class="btn p-0 border-0 d-md-none" type="button" aria-label="Close Navigation">' +
                        '<i class="fa fa-times fa-lg"></i></button>');
                    $header.append($closeBtn);
                }
            }

            // --- Sidebar toggle button click ---
            window.addEventListener('click', function(e) {
                // Don't intercept native form controls (selects, options, inputs).
                var tag = e.target.tagName;
                if (tag === 'SELECT' || tag === 'OPTION' || tag === 'INPUT' || tag === 'TEXTAREA') {
                    return;
                }
                // Handle header sidebar toggle button.
                if (e.target.closest('#sidebar-toggle-btn')) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (isMobile()) {
                        // Mobile: open/close drawer.
                        if (drawerOpen) {
                            closeMobileDrawer();
                        } else {
                            openMobileDrawer();
                        }
                    } else {
                        // Desktop: collapse/expand sidebar.
                        $dashboardContainer.toggleClass('sidebar-collapsed');
                        var collapsed = $dashboardContainer.hasClass('sidebar-collapsed');
                        localStorage.setItem('smartdashboard_sidebar_collapsed', collapsed);

                        // Trigger window resize to adjust charts after transition.
                        setTimeout(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 300);
                    }
                }

                // Handle floating mobile toggle button.
                if (e.target.closest('.smartdashboard-mobile-toggle')) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileDrawer();
                }

                // Handle mobile close (X) button inside the drawer.
                if (e.target.closest('#sidebar-close-btn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileDrawer();
                }
            }, true);

            // --- Escape key to close drawer ---
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && drawerOpen) {
                    closeMobileDrawer();
                }
            });

            // --- Focus trapping inside mobile drawer ---
            document.addEventListener('keydown', function(e) {
                if (e.key !== 'Tab' || !drawerOpen) {
                    return;
                }
                var $sidebar = $('#sidebar-col');
                var focusables = $sidebar.find(
                    'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])'
                ).filter(':visible');
                if (focusables.length === 0) {
                    return;
                }
                var firstFocusable = focusables[0];
                var lastFocusable = focusables[focusables.length - 1];

                if (e.shiftKey) {
                    // Shift+Tab: if focus is on first element, wrap to last.
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab: if focus is on last element, wrap to first.
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            });

            // --- Navigation link handler with mobile auto-close ---
            window.addEventListener('click', function(e) {
                // Don't intercept native form controls (selects, options, inputs).
                var tag = e.target.tagName;
                if (tag === 'SELECT' || tag === 'OPTION' || tag === 'INPUT' || tag === 'TEXTAREA') {
                    return;
                }
                var navLink = e.target.closest('#dashboard-sidebar-nav .nav-link');
                if (navLink) {
                    var $navLink = $(navLink);
                    var targetId = $navLink.data('section');
                    // Only preventDefault for section-switching links.
                    // Collapse-toggle links need the native event for Bootstrap to work.
                    // Check both BS4 (data-toggle) and BS5 (data-bs-toggle) attributes.
                    var isCollapseToggle = $navLink.attr('data-bs-toggle') || $navLink.attr('data-toggle');
                    if (!isCollapseToggle) {
                        e.preventDefault();
                    }

                    if (targetId) {
                        $('#dashboard-sidebar-nav .nav-link').removeClass('active');
                        $navLink.addClass('active');
                        $('.dashboard-section').addClass('d-none');
                        $('#' + targetId).removeClass('d-none');

                    // Init module if first time view
                    if (targetId === 'section-daily-plan') {
                        if (!$('#section-daily-plan').data('loaded')) {
                            require(['local_smartdashboard/sections/daily_plan'], function(m) { m.init(); });
                            $('#section-daily-plan').data('loaded', true);
                        }
                    } else if (targetId === 'section-progress') {
                        if (!$('#section-progress').data('loaded')) {
                            require(['local_smartdashboard/sections/progress'], function(m) { m.init(); });
                            $('#section-progress').data('loaded', true);
                        }
                    } else if (targetId === 'section-progress-detailed') {
                        // Always init detailed view logic to refetch students if dependent data missing, OR simply check flag
                        // We can just call initDetailed which handles data checking
                        if (!$('#section-progress-detailed').data('loaded')) {
                            require(['local_smartdashboard/sections/progress'], function(m) { m.initDetailed(); });
                            $('#section-progress-detailed').data('loaded', true);
                        }
                    } else if (targetId === 'section-progress-risk') {
                        if (!$('#section-progress-risk').data('loaded')) {
                            require(['local_smartdashboard/sections/risk'], function(m) { m.init(); });
                            $('#section-progress-risk').data('loaded', true);
                        }
                    } else if (targetId === 'section-progress-grades') {
                        if (!$('#section-progress-grades').data('loaded')) {
                            require(['local_smartdashboard/sections/grades'], function(m) { m.init(); });
                            $('#section-progress-grades').data('loaded', true);
                        }
                    } else if (targetId === 'section-grading') {
                        if (!$('#section-grading').data('loaded')) {
                            require(['local_smartdashboard/sections/grading'], function(m) { m.init(); });
                            $('#section-grading').data('loaded', true);
                        }
                    } else if (targetId === 'section-analytics') {
                        if (!$('#section-analytics').data('loaded')) {
                            require(['local_smartdashboard/sections/analytics'], function(m) { m.init(); });
                            $('#section-analytics').data('loaded', true);
                        }
                    } else if (targetId === 'section-payments') {
                        if (!$('#section-payments').data('loaded')) {
                            require(['local_smartdashboard/sections/payments'], function(m) { m.init(); });
                            $('#section-payments').data('loaded', true);
                        }
                    } else if (targetId === 'section-settings') {
                        if (!$('#section-settings').data('loaded')) {
                            require(['local_smartdashboard/sections/settings'], function(m) { m.init(); });
                            $('#section-settings').data('loaded', true);
                        }
                    } else if (targetId === 'section-magic') {
                        if (!$('#section-magic').data('loaded')) {
                            require(['local_smartdashboard/sections/magic_reports'], function(m) { m.init(); });
                            $('#section-magic').data('loaded', true);
                        }
                    } else if (targetId === 'section-grade-details') {
                        if (!$('#section-grade-details').data('loaded')) {
                            require(['local_smartdashboard/grade_details'], function(m) { m.init(); });
                            $('#section-grade-details').data('loaded', true);
                        }
                    }

                    // Auto-close mobile drawer when a section is selected.
                    if (isMobile() && drawerOpen) {
                        closeMobileDrawer();
                    }
                }
                }

                // Handle stats toggle in overview
                var statToggle = e.target.closest('.stat-toggle-btn');
                if (statToggle) {
                    var val = statToggle.getAttribute('data-value');
                    var lbl = statToggle.getAttribute('data-label');
                    var displayVal = document.getElementById('stat-display-value');
                    var displayLbl = document.getElementById('stat-display-label');
                    if (displayVal) {
                        displayVal.innerText = val;
                    }
                    if (displayLbl) {
                        displayLbl.innerText = lbl;
                    }
                }
            }, true);

            // --- Debounced resize handler (150ms) for Chart.js ---
            var resizeTimer = null;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Close mobile drawer if user resizes to desktop.
                    if (!isMobile() && drawerOpen) {
                        closeMobileDrawer();
                    }
                }, 150);
            });
        }
    };
});

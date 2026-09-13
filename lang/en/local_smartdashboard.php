<?php
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
 * Language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Smart Dashboard';
$string['smartdashboard:view'] = 'View the Smart Dashboard';
$string['mycourses'] = 'My Courses';
$string['nocourses'] = 'You are not teaching any courses yet.';
$string['gotocourse'] = 'Go to Course';
$string['students'] = 'students';
$string['enrollments'] = 'Enrollments';
$string['activities'] = 'Activities';
$string['needsgrading'] = 'Submission(s) to grade';
$string['section_overview'] = 'Overview';
$string['section_grading'] = 'Grading';
$string['section_progress'] = 'Student Progress';
$string['section_analytics'] = 'Analytics';
$string['section_settings'] = 'Settings';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Student Dashboard Icons';
$string['student_icons_desc'] = 'Configure the icons displayed on the student dashboard welcome banner.';
$string['icon_heading'] = 'Icon {$a}';
$string['icon_name'] = 'Icon Name';
$string['icon_class'] = 'Icon Class (FontAwesome)';
$string['icon_class_desc'] = 'e.g. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'Link URL';
$string['welcomebackstudent'] = 'Welcome back, {$a}!';
$string['privacy:metadata'] = 'The Smart Dashboard plugin does not store any personal data.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Dashboard Replacement';
$string['redirect_desc'] = 'Configure whether the Smart Dashboard replaces the default Moodle dashboard for specific roles.';
$string['enabledirect'] = 'Enable Dashboard Replacement';
$string['enabledirect_desc'] = 'If enabled, users with selected roles visiting the default dashboard will be redirected here.';
$string['redirectroles'] = 'Roles to Redirect';
$string['redirectroles_desc'] = 'Select the roles that should be redirected to the Smart Dashboard. Users with ANY of these roles in ANY context will be affected.';
$string['redirectadmins'] = 'Redirect Site Administrators';
$string['redirectadmins_desc'] = 'Should Site Administrators also be redirected?';

// Appearance Settings.
$string['appearance_heading'] = 'Appearance';
$string['appearance_desc'] = 'Customize the visual appearance of the Smart Dashboard.';
$string['thememode'] = 'Color Mode';
$string['thememode_desc'] = 'Choose the color mode for the dashboard. Use "Light" if your Moodle theme has a light background, or "Dark" for dark-themed sites.';
$string['thememode_dark'] = 'Dark Mode';
$string['thememode_light'] = 'Light Mode';
$string['todays_agenda'] = 'Today\'s Agenda';
$string['payment_calc_mode'] = 'Payment Calculation Mode';
$string['payment_calc_mode_desc'] = 'Choose how the payment analytics calculates revenue and student counts.';
$string['save_settings'] = 'Save Settings';
$string['latest_announcements'] = 'Latest Announcements';
$string['dont_show_again'] = 'Don\'t show this again';
$string['close'] = 'Close';
$string['magic_reports_title'] = 'Magic Reports (AI Analysis)';
$string['magic_reports_desc'] = 'Ask questions about your data in plain English, and the AI will generate the report for you.';
$string['saved_reports'] = 'Saved Reports';
$string['loading'] = 'Loading...';
$string['ask_a_question'] = 'Ask a question';
$string['generate'] = 'Generate';
$string['result'] = 'Result';
$string['save_report'] = 'Save Report';
$string['assignments_needing_grading'] = 'Assignments Needing Grading';
$string['student_welcome_sub'] = 'Here is your progress and resources.';
$string['welcome_back'] = 'Welcome back!';
$string['teacher_welcome_sub'] = 'Here are the courses you are teaching. Track student progress, grading, and engagement insights.';
$string['parent_welcome_sub'] = 'Here you can monitor your mentees\' progress and activities.';
$string['parent_mentees_title'] = 'Your Mentees';
$string['parent_overall_performance'] = 'Overall Performance';
$string['parent_upcoming_deadlines'] = 'Upcoming Deadlines';
$string['parent_recent_results'] = 'Recent Results';
$string['parent_no_data'] = 'No data available';
$string['parent_view_calendar'] = 'View Calendar';
$string['parent_average_grade'] = 'Average Grade';
$string['saving'] = 'Saving...';
$string['filter_by_cat'] = 'Filter by Category';
$string['select_category'] = 'Select a category...';
$string['show_courses'] = 'Show Courses';
$string['total_enrollments'] = 'Total Enrollments';
$string['direct_sum'] = 'Direct Sum';
$string['unique_students'] = 'Unique Students';
$string['subcategories'] = 'Subcategories';
$string['courses'] = 'Courses';
$string['select_category_to_view'] = 'Please select a category and click "Show Courses" to view data.';
$string['select_category_to_filter'] = 'Select a specific category to filter results.';
$string['no_courses_found'] = 'No courses found matching your selection.';
$string['dashboard'] = 'Dashboard';
$string['overview'] = 'Overview';
$string['risk'] = 'Risk Details';
$string['detailed'] = 'Detailed';
$string['grades_overview'] = 'Grades Overview';
$string['payments'] = 'Payments';
$string['magic_reports'] = 'Magic Reports';
$string['payment_analytics'] = 'Payment Analytics';
$string['time_range'] = 'Time Range';
$string['all_time'] = 'All Time';
$string['today'] = 'Today';
$string['past_7_days'] = 'Past 7 Days';
$string['past_30_days'] = 'Past 30 Days';
$string['past_year'] = 'Past Year';
$string['custom_range'] = 'Custom Range';
$string['from'] = 'From';
$string['to'] = 'To';
$string['category'] = 'Category';
$string['system_analytics'] = 'System Analytics';
$string['student_grades_will_appear'] = 'Student grades will appear here.';
$string['no_pending_tasks'] = 'You have no pending tasks or adaptive study plans for today.';
$string['caught_up'] = 'You\'re all caught up!';
$string['due_today'] = 'Due Today';
$string['go_to_course'] = 'Go to Course';
$string['role_student'] = 'Student';
$string['role_teacher'] = 'Teacher';
$string['role_parent'] = 'Parent';
$string['parent_terminology'] = 'Parent Terminology';
$string['parent_terminology_desc'] = 'Select the word used to describe the Parent/Mentor role in the dashboard.';
$string['term_parent'] = 'Parent';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Partner';
$string['term_supervisor'] = 'Academic Supervisor';
$string['term_guardian'] = 'Guardian';
$string['term_sponsor'] = 'Sponsor';
// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Saved custom AI-generated reports created by the user.';
$string['privacy:metadata:reports:userid'] = 'The user who created the report.';
$string['privacy:metadata:reports:title'] = 'The name of the saved report.';
$string['privacy:metadata:reports:description'] = 'Optional description or the original AI prompt.';
$string['privacy:metadata:reports:sql_query'] = 'The SQL query generated for the report.';
$string['privacy:metadata:reports:timecreated'] = 'The time the report was created.';
$string['privacy:metadata:reports:timemodified'] = 'The time the report was last modified.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Stores the IDs of dashboard announcements that the user has dismissed.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'At-risk student score snapshots calculated daily by the risk engine.';
$string['privacy:metadata:risk:userid'] = 'The student whose risk was evaluated.';
$string['privacy:metadata:risk:courseid'] = 'The course context for the risk evaluation.';
$string['privacy:metadata:risk:riskscore'] = 'The calculated risk score (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'The risk classification (low, medium, or high).';
$string['privacy:metadata:risk:timecreated'] = 'The time the risk snapshot was calculated.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'At-risk student data may be sent to an external n8n workflow webhook configured by the administrator.';
$string['privacy:metadata:n8n:userid'] = 'The user ID of the at-risk student.';
$string['privacy:metadata:n8n:courseid'] = 'The course ID related to the risk alert.';
$string['privacy:metadata:n8n:riskscore'] = 'The risk score sent to the external webhook.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Historical AI analysis and feedback for student grades.';
$string['privacy:metadata:ai_grades:userid'] = 'The student whose grades were analyzed.';
$string['privacy:metadata:ai_grades:report_html'] = 'The AI-generated feedback and recommendations HTML.';
$string['privacy:metadata:ai_grades:timecreated'] = 'The timestamp when the analysis was generated.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Calculate at-risk student scores';
$string['risk_heading'] = 'At-Risk Student Alerts';
$string['risk_heading_desc'] = 'Configure the at-risk student early warning system. The risk engine runs daily and scores each student based on the weighted criteria below. Teachers are automatically notified when a student becomes high-risk.';
$string['n8n_webhook_url'] = 'n8n Webhook URL';
$string['n8n_webhook_url_desc'] = 'The URL to your n8n workflow webhook for sending at-risk student data.';
$string['n8n_webhook_token'] = 'n8n Webhook Token';
$string['n8n_webhook_token_desc'] = 'Optional Bearer token for authenticating with your n8n webhook.';
$string['risk_max_inactive_days'] = 'Max inactive days';
$string['risk_max_inactive_days_desc'] = 'Number of days of inactivity before the login risk score reaches 100%. Default: 14 days.';
$string['risk_weight_login'] = 'Weight: Login recency';
$string['risk_weight_completion'] = 'Weight: Course completion';
$string['risk_weight_grade'] = 'Weight: Course grade';
$string['risk_weight_overdue'] = 'Weight: Overdue activities';
$string['risk_weight_adaptiveplan'] = 'Weight: Adaptive plan compliance';
$string['risk_weight_desc'] = 'Relative weight for this criterion (values are normalized to 100%). Default: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Relative weight for adaptive plan compliance. Automatically redistributed if mod_adaptiveplan is not installed. Default: 20.';
$string['risk_alert_subject'] = 'At-Risk Alert: {$a} needs attention';
$string['risk_alert_body'] = 'Student {$a->studentname} has been flagged as at-risk in the course "{$a->coursename}" with a risk score of {$a->riskscore}%.

Please check on this student\'s progress and consider reaching out to offer support.

View the dashboard for more details.';
$string['risk_alert_body_html'] = '<p><strong>Student {$a->studentname}</strong> has been flagged as <span style="color:#dc3545;font-weight:bold;">at-risk</span> in the course "<strong>{$a->coursename}</strong>" with a risk score of <strong>{$a->riskscore}%</strong>.</p><p>Please check on this student\'s progress and consider reaching out to offer support.</p>';
$string['risk_alert_small'] = '{$a->studentname} is at-risk in {$a->coursename}';
$string['risk_level_low'] = 'On Track';
$string['risk_level_medium'] = 'Monitor';
$string['risk_level_high'] = 'At Risk';
$string['risk_score'] = 'Risk Score';
$string['risk_no_data'] = 'Risk data not yet available. The system calculates risk scores daily.';
$string['messageprovider:risk_alert'] = 'At-risk student notifications';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Smart Dashboard Risk Rule';
$string['subplugintype_smartdashboardrule_plural'] = 'Smart Dashboard Risk Rules';

// Mobile App Support.
$string['mobile_no_data'] = 'No data available. Pull down to refresh.';
$string['at_risk_students'] = 'At-Risk Students';
$string['risk_high'] = 'High Risk';
$string['risk_medium'] = 'Medium Risk';
$string['risk_low'] = 'Low Risk';
$string['grading_pending'] = 'Grading Pending';
$string['total_students'] = 'Total Students';
$string['total_courses'] = 'Total Courses';
$string['due_date'] = 'Due';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Access denied';
$string['error_webhook_not_configured'] = 'n8n Webhook URL is not configured.';
$string['error_invalid_json'] = 'Invalid JSON payload.';
$string['error_invalid_action'] = 'Invalid action';
$string['error_n8n_error'] = 'n8n Error: {$a}';
$string['success_data_sent'] = 'Data successfully sent to n8n!';
$string['student_count_display'] = 'Student count display';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Sum of students in all courses (includes duplicates)';
$string['unique_students_tooltip'] = 'Count of unique students (no duplicates)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'e.g. Show me the top 5 courses with lowest completion rates...';
$string['magic_ai_description'] = 'Using AI to translate natural language into SQL queries.';
$string['show_generated_sql'] = 'Show generated SQL';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Revenue Distribution';
$string['chart_students_revenue_category'] = 'Students & Revenue per Category';

// Student Overview strings.
$string['student_my_courses'] = 'My Courses';
$string['student_upcoming_deadlines'] = 'Upcoming Deadlines';
$string['student_my_grades'] = 'My Grades';
$string['student_overall_average'] = 'Overall Average';
$string['student_complete'] = 'complete';
$string['student_no_deadlines'] = 'No upcoming deadlines — you\'re all caught up!';
$string['student_no_grades'] = 'No grades available yet.';
$string['student_no_courses'] = 'You are not enrolled in any courses.';
$string['student_no_progress'] = 'Not tracked';
$string['student_due_soon'] = 'In {$a} days';
$string['student_view_course'] = 'View Course';
$string['student_course_progress'] = 'Course Progress';
$string['student_active_courses'] = 'Active Courses';
$string['student_next_deadline'] = 'Next Deadline';
$string['student_recent_feedback'] = 'Recent Feedback';
$string['student_no_feedback'] = 'No recent feedback available.';
$string['student_none'] = 'None';
$string['student_my_badges'] = 'My Latest Badges';
$string['student_no_badges'] = 'You haven\'t earned any badges yet. Keep up the good work!';



// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'View student course grades report';
$string['studentgrades:viewall'] = 'View all users\' course grades reports';
$string['selectuser'] = 'Select user';
$string['exporthtml'] = 'Export as HTML';
$string['includedescription'] = 'Include Description';
$string['nousers'] = 'No users found';
$string['student_nocourses'] = 'Student is not enrolled in any courses';
$string['user'] = 'Student';
$string['reportdate'] = 'Report date';
$string['coursename'] = 'Course';
$string['gradeitem'] = 'Grade item';
$string['grade'] = 'Grade';
$string['range'] = 'Range';
$string['percentage'] = 'Percentage';
$string['total'] = 'Total';
$string['coursetotal'] = 'Course Total';
$string['overallsummary'] = 'Overall Summary';
$string['totalcourses'] = 'Total Courses';
$string['viewmygrades'] = 'View My Grades';
$string['exportmygrades'] = 'Export My Grades';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'No content to export.';
$string['filtergrades'] = 'Filter Grades';
$string['allcourses'] = 'All Courses';
$string['categorysearch'] = 'Category / Search';
$string['typetofilter'] = 'Type to filter...';
$string['analyzeandemail'] = 'Analyze & Email Me';
$string['dailylimitreached'] = 'Daily limit reached. Please wait {$a} minute(s) before generating a new analysis.';
$string['viewanalysisnow'] = 'View Analysis Now';
$string['generatinganalysis'] = 'Generating Analysis...';
$string['talkingtocoreai'] = 'Talking to Moodle AI...';
$string['aianalysisresult'] = 'AI Analysis Result';
$string['downloadpdf'] = 'Download PDF';
$string['communicationerror'] = 'Communication Error';
$string['analysishistory'] = 'Analysis History';
$string['defaultprompt'] = "You are an educational AI assistant. Analyze the following student performance data. The data includes course descriptions, activities, max grades, student grades, and activity descriptions. Provide a constructive analysis of the student\'s strengths and areas for improvement based on this data.";
$string['privacy:metadata:userid'] = 'The user ID.';
$string['privacy:metadata:grades'] = 'The user\'s grades data.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Grades data is sent to the n8n webhook for AI analysis.';
$string['permissiondenied'] = 'Permission Denied. You are logged in as User ID: {$a->currentuserid} but requested data for User ID: {$a->userid}. Appropriate capability or linked parent account required.';
$string['airesponsesuccessnocontent'] = 'AI Response success but no content. Raw data: {$a}';
$string['aiprovidererror'] = 'AI Provider Error: {$a}';
$string['errorinitializingai'] = 'Error initializing AI action: {$a}';
$string['aimockresponse'] = 'AI System Response: Hello! I received your message. (Moodle Core AI classes not detected, showing mock response)';
$string['generalerror'] = 'Error: {$a}';
$string['invalidaction'] = 'Invalid action';
$string['success'] = 'Success';
$string['unknownerror'] = 'Unknown error occurred';
$string['aiconfigmissing'] = 'AI Configuration (Webhook URL) not found in Student Grades Report settings.';
$string['analysisrequestsent'] = 'Analysis request sent successfully!';
$string['failedtosenddata'] = 'Failed to send data. HTTP Code: {$a->code} Response: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Color Settings';
$string['colorsettingsdesc'] = 'Customize the colors used in the HTML export grade reports. These settings allow you to match your institution\'s branding and improve visual accessibility.';
// Header Colors
$string['headerprimarycolor'] = 'Header Primary Color';
$string['headerprimarycolordesc'] = 'Primary color for the report header gradient background';
$string['headersecondarycolor'] = 'Header Secondary Color';
$string['headersecondarycolordesc'] = 'Secondary color for the report header gradient background';
$string['headertextcolor'] = 'Header Text Color';
$string['headertextcolordesc'] = 'Text color for the report header';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Excellent Grade Color';
$string['gradeexcellentcolordesc'] = 'Color for excellent grade performance indicators';
$string['gradegoodcolor'] = 'Good Grade Color';
$string['gradegoodcolordesc'] = 'Color for good grade performance indicators';
$string['gradeaveragecolor'] = 'Average Grade Color';
$string['gradeaveragecolordesc'] = 'Color for average grade performance indicators';
$string['gradepoorcolor'] = 'Poor Grade Color';
$string['gradepoorcolordesc'] = 'Color for poor grade performance indicators';
// Table Colors
$string['tablebordercolor'] = 'Table Border Color';
$string['tablebordercolordesc'] = 'Color for table borders and cell separators';
$string['rowalternatecolor'] = 'Row Alternate Color';
$string['rowalternatecolordesc'] = 'Background color for alternating table rows';
$string['rowhovercolor'] = 'Row Hover Color';
$string['rowhovercolordesc'] = 'Background color when hovering over table rows';
// Category Colors
$string['categoryprimarycolor'] = 'Category Primary Color';
$string['categoryprimarycolordesc'] = 'Primary color for category row gradient background';
$string['categorysecondarycolor'] = 'Category Secondary Color';
$string['categorysecondarycolordesc'] = 'Secondary color for category row gradient background';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Category Total Primary Color';
$string['categorytotalprimarycolordesc'] = 'Primary color for category total row gradient background';
$string['categorytotalsecondarycolor'] = 'Category Total Secondary Color';
$string['categorytotalsecondarycolordesc'] = 'Secondary color for category total row gradient background';
$string['coursetotalprimarycolor'] = 'Course Total Primary Color';
$string['coursetotalprimarycolordesc'] = 'Primary color for course total row gradient background';
$string['coursetotalsecondarycolor'] = 'Course Total Secondary Color';
$string['coursetotalsecondarycolordesc'] = 'Secondary color for course total row gradient background';
// Grade Value Colors
$string['gradevaluecolor'] = 'Grade Value Text Color';
$string['gradevaluecolordesc'] = 'Text color for grade values';
$string['gradevaluebgcolor'] = 'Grade Value Background Color';
$string['gradevaluebgcolordesc'] = 'Background color for grade value cells';
$string['percentagecolor'] = 'Percentage Text Color';
$string['percentagecolordesc'] = 'Text color for percentage values';
$string['percentagebgcolor'] = 'Percentage Background Color';
$string['percentagebgcolordesc'] = 'Background color for percentage cells';
// AI Settings
$string['aisettings'] = 'AI Analysis Settings';
$string['aisettingsdesc'] = 'Configure the integration with external AI services via n8n.';
$string['enableemailanalysis'] = 'Enable Analysis via Email';
$string['enableemailanalysisdesc'] = 'Allow users to request an analysis report sent to their email.';
$string['enableinstantanalysis'] = 'Enable Instant Analysis';
$string['enableinstantanalysisdesc'] = 'Allow users to view an analysis report instantly in a modal window.';
$string['webhookurl'] = 'n8n Webhook URL';
$string['webhookurldesc'] = 'The URL of the n8n webhook that will process the student grade data.';
$string['token'] = 'n8n Webhook Token';
$string['tokendesc'] = 'Secure token for authentication with the n8n webhook (sent in headers).';
$string['aiprompt'] = 'AI Analysis Prompt';
$string['aipromptdesc'] = 'The prompt sent to the AI along with the student data. Customize this to change the tone or focus of the analysis.';
$string['aicooldown'] = 'Analysis Cooldown (Minutes)';
$string['aicooldowndesc'] = 'Minimum time in minutes between analysis requests for critical data saving. Set to 0 to disable.';
// Reset Information
$string['resetcolorsheading'] = 'Reset Colors';
$string['resetcolorsdesc'] = 'To reset all colors to their default values, clear each color field and save the settings. The plugin will automatically use the default color scheme.';

// Pro Edition features info.
$string['pro_features_heading'] = 'Unlock Smart Dashboard Pro';
$string['pro_features_desc'] = 'Take your institutional analytics further with Smart Dashboard Pro: Natural Language AI SQL Reports, Parent & Mentor 360° Portal, Revenue & Payment Analytics, and Automated n8n Webhook Alerts. <a href="https://smartlearn.education" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary mt-2 d-inline-block">Explore Pro Features &rarr;</a>';


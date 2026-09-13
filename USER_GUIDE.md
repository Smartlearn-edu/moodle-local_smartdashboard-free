# Smart Dashboard User Guide & Administration Manual

A comprehensive, step-by-step user guide and administration manual for the **Smart Dashboard for Moodle** (`local_smartdashboard`).

Built for **Students**, **Teachers**, **Managers**, **Parents / Mentors**, and **Site Administrators** — transforming Moodle from a passive repository into an intelligent, real-time command center.

---

## 📑 Table of Contents

1. [Overview & Core Architecture](#1-overview--core-architecture)
2. [Accessing the Dashboard & Navigation](#2-accessing-the-dashboard--navigation)
3. [Student User Guide](#3-student-user-guide)
   - [Personalized Welcome Banner](#personalized-welcome-banner)
   - [Customizable Quick Shortcuts Grid](#customizable-quick-shortcuts-grid)
   - [Course Progress & Completion Cards](#course-progress--completion-cards)
   - [Color-Coded Deadline Timeline](#color-coded-deadline-timeline)
   - [My Grades Summary & Academic Drill-Down](#my-grades-summary--academic-drill-down)
   - [Today's Agenda & Adaptive Study Plan](#todays-agenda--adaptive-study-plan)
   - [AI Performance Analysis & Strengths Review](#ai-performance-analysis--strengths-review)
4. [Teacher & Educator Portal Guide](#4-teacher--educator-portal-guide)
   - [Centralized Grading Queue](#centralized-grading-queue)
   - [Student Progress & Completion Tracking](#student-progress--completion-tracking)
   - [Modular At-Risk Student Early Warning System](#modular-at-risk-student-early-warning-system)
   - [Activity Completion Drill-Down](#activity-completion-drill-down)
5. [Parent & Mentor 360° Portal Guide](#5-parent--mentor-360-portal-guide)
   - [Mentee Switcher & Multiple Student Oversight](#mentee-switcher--multiple-student-oversight)
   - [Program-Level Filtering](#program-level-filtering)
   - [Grade Progression Analytics Charts](#grade-progression-analytics-charts)
   - [Subject Mastery Radar Graphs](#subject-mastery-radar-graphs)
   - [Weekly Engagement Heatmaps & Study Streaks](#weekly-engagement-heatmaps--study-streaks)
   - [KPI At-Risk Indicators & Alerts](#kpi-at-risk-indicators--alerts)
6. [Administrator & Manager Guide](#6-administrator--manager-guide)
   - [System-Wide Enrollment & Category Analytics](#system-wide-enrollment--category-analytics)
   - [Revenue & Payment Analytics](#revenue--payment-analytics)
   - [AI Magic Reports & SQL Insights Hub](#ai-magic-reports--sql-insights-hub)
   - [Modular Risk Rule Engine Configuration](#modular-risk-rule-engine-configuration)
   - [n8n Automation Webhook Setup](#n8n-automation-webhook-setup)
   - [Dashboard Replacement & Automatic Redirection](#dashboard-replacement--automatic-redirection)
   - [Parent/Mentor Terminology Customization](#parentmentor-terminology-customization)
   - [Customizing Student Quick-Access Shortcuts](#customizing-student-quick-access-shortcuts)
   - [Adding Standard Moodle Blocks to the Dashboard](#adding-standard-moodle-blocks-to-the-dashboard)
7. [External Web Services API Reference](#7-external-web-services-api-reference)
8. [Troubleshooting & Frequently Asked Questions (FAQ)](#8-troubleshooting--frequently-asked-questions-faq)

---

## 1. Overview & Core Architecture

The **Smart Dashboard** (`local_smartdashboard`) aggregates critical data across courses, submissions, grades, student risk metrics, and financial records into a unified, responsive interface with native dark/light mode support.

### Supported Environments
- **Moodle Versions**: 4.0, 4.1, 4.2, 4.3, 4.4, 4.5, 5.0+
- **PHP Requirements**: 7.4, 8.0, 8.1, 8.2, 8.3+
- **Database Support**: MariaDB, MySQL, PostgreSQL
- **Browser Compatibility**: All modern browsers supporting CSS Grid, Flexbox, and Backdrop Filters.
- **RTL & Multilingual**: Built-in support for **English**, **Spanish**, and **Arabic** (with right-to-left layout adaptation).

---

## 2. Accessing the Dashboard & Navigation

### Direct Access URL
Users can access the dashboard directly at:
```text
https://your-moodle-domain.com/local/smartdashboard/
```

### Automatic Dashboard Redirection
When configured by an administrator, Smart Dashboard can seamlessly replace the default Moodle `/my/` dashboard for selected roles upon login.

### Theme Appearance Toggle
Smart Dashboard automatically adopts the administrator-configured color palette (**Dark Mode** or **Light Mode**), matching your institution's branding seamlessly.

---

## 3. Student User Guide

When a student logs in, the Smart Dashboard dynamically personalizes their view to surface essential tasks, progress, upcoming deadlines, and grades.

```
+-----------------------------------------------------------------------+
|  👋 Welcome back, Alex!                                               |
|  [ 📚 Library ] [ 📝 Assignments ] [ 🏆 Badges ] [ 💬 Messages ]     |
+-----------------------------------------------------------------------+
|  📚 My Courses (Progress Cards)                                       |
|  +-----------------------+  +-----------------------+                 |
|  | Biology 101           |  | Computer Science 200  |                 |
|  | [============ 75%  ]  |  | [====== 35%         ] |                 |
|  +-----------------------+  +-----------------------+                 |
+-----------------------------------------------------------------------+
|  ⏰ Upcoming Deadlines              |  📈 My Grades Summary           |
|  🔴 Critical: Lab Report (Today)    |  Biology: 92% (A)               |
|  🟡 Due Soon: Quiz 3 (In 2 days)    |  CS 200: 84% (B)                |
+-----------------------------------------------------------------------+
|  📅 Today's Agenda & Adaptive Plan                                   |
|  [x] Read Chapter 4 (20 min)  -  [ ] Complete Practice Quiz (15 min)  |
+-----------------------------------------------------------------------+
```

### Personalized Welcome Banner
- Displays the student's full name, profile avatar, and contextual greeting.
- Displays active enrolled course count and quick status badges.

### Customizable Quick Shortcuts Grid
- Up to 10 customizable shortcut buttons configured by the site administrator (e.g., Course Catalog, Digital Library, Study Groups, Calendar, Student Support).
- One-click navigation to frequently used resources with intuitive FontAwesome icons.

### Course Progress & Completion Cards
- **Visual Completion Bars**: Real-time progress percentage calculated from Moodle's activity completion engine.
- **Course Summary Info**: Number of enrolled students, course category, and quick links directly into the course home.

### Color-Coded Deadline Timeline
Categorizes all upcoming assignments, quizzes, and deliverables by urgency:
- 🔴 **Critical (Within 24 Hours)**: Marked with an urgent red badge to draw immediate attention.
- 🟡 **Due Soon (1 to 3 Days)**: Marked with an amber badge for upcoming milestones.
- 🔵 **Upcoming (> 3 Days)**: Marked with a blue/neutral badge for future planning.
- **Direct Submission Link**: Click any deadline card to jump directly to the submission page.

### My Grades Summary & Academic Drill-Down
- **Performance Snapshot**: Shows letter grade, current percentage, and maximum possible points across all active courses.
- **Detailed Drill-Down**: Click on any course to open the interactive breakdown modal displaying:
  - Individual assignment, quiz, and discussion grades.
  - Weightings, grade ranges, and instructor feedback comments.
  - Category totals and overall course totals.
- **HTML / CSV Export**: Export your complete grade report with one click for offline review or portfolio records.

### Today's Agenda & Adaptive Study Plan
- Synchronizes with Moodle Adaptive Study Plans (`mod_adaptiveplan`).
- Breaks down your daily study schedule into bite-sized, actionable tasks with estimated completion durations.
- Interactive checklist to track study progress throughout the day.

### AI Performance Analysis & Strengths Review
- **Instant Academic Insights**: Powered by AI integration to deliver constructive evaluations of strengths and targeted improvement areas.
- **Actionable Advice**: Tailored study recommendations based on your recent submission scores and activity engagement.

---

## 4. Teacher & Educator Portal Guide

The Teacher Portal is designed to eliminate repetitive administrative navigation and bring all actionable items to a single screen.

### Centralized Grading Queue
- **Cross-Course Submissions Queue**: Consolidates all ungraded assignments and pending essay submissions from every course you teach.
- **Submission Counts & Urgency**: Shows the number of submissions awaiting review, student names, and submission timestamps.
- **One-Click Speed Grading**: Click directly on any submission row to open Moodle's grading interface in a dedicated view without navigating course trees.

### Student Progress & Completion Tracking
- Monitor enrollment numbers and completion percentages across all your classes.
- Filter students by course, group, or status.
- Identify students falling behind class pacing before examination dates.

### Modular At-Risk Student Early Warning System
- **Risk Score (0–100%)**: Automatically calculated daily based on weighted indicators:
  - **Inactivity / Login Recency**: Flags students who have not logged in for X days.
  - **Course Completion Velocity**: Detects stalled activity completion.
  - **Grade Averages**: Identifies students with failing or declining assignment scores.
  - **Overdue Submissions**: Counts missed deadlines.
  - **Adaptive Plan Compliance**: Tracks completion of assigned study plan tasks.
- **Risk Level Badges**:
  - 🟢 **On Track (0–39%)**
  - 🟡 **Monitor (40–69%)**
  - 🔴 **At Risk (70–100%)**
- **Intervention Details**: Click any at-risk student to view their detailed activity timeline and trigger outreach notifications.

### Activity Completion Drill-Down
- Inspect activity-by-activity completion criteria for every student.
- View exact completion dates, viewing records, and submission requirements.

---

## 5. Parent & Mentor 360° Portal Guide

The Parent & Mentor 360° Portal provides guardians, academic advisors, and sponsors with a clear, holistic view of mentee academic journeys.

### Mentee Switcher & Multiple Student Oversight
- Easily toggle between multiple assigned students or children using the intuitive dropdown menu.
- Role terminology can be customized (e.g., *Parent*, *Mentor*, *Guardian*, *Academic Supervisor*, *Sponsor*).

### Program-Level Filtering
- For organizations using `enrol_programs`, mentors can filter students by specific academic tracks, degrees, or cohort programs.

### Grade Progression Analytics Charts
- Visual multi-axis chart showing academic performance trends over weeks or terms.
- Compare individual assignment marks against the course median and maximum possible scores.

### Subject Mastery Radar Graphs
- Multi-dimensional competency radar visualizes strengths across different subjects and skill domains (e.g., Mathematics, Humanities, Science, Programming).

### Weekly Engagement Heatmaps & Study Streaks
- **Daily Activity Density**: Visualizes student login activity and interaction frequency throughout each day of the week.
- **Study Streak Counter**: Displays consecutive active study days to encourage consistency and positive study habits.

### KPI At-Risk Indicators & Alerts
- Real-time badges highlight critical items requiring parental or mentor support (e.g., missed deadlines, declining attendance, low quiz scores).

---

## 6. Administrator & Manager Guide

The Administrator Hub equips decision-makers with institution-wide intelligence, revenue monitoring, and automated AI data reporting.

### System-Wide Enrollment & Category Analytics
- **Total Enrollments & Direct Sums**: Track overall active enrollments with duplicate and unique student breakdowns.
- **Category Performance Breakdown**: Compare activity and student density across faculties and academic departments.
- **Student-to-Teacher Ratio**: Visual indicator of faculty workload and cohort distributions.
- **CSV Data Export**: Export complete institutional enrollment snapshots for reporting and compliance audits.

### Revenue & Payment Analytics
- **Actual vs. Estimated Revenue**: Interactive bar and line charts comparing projected revenue against collected payments.
- **Category ROI Filtering**: Analyze which course categories generate the highest financial return.
- **Custom Time Ranges & Currency Toggles**: Filter records by All Time, Today, Past 7 Days, Past 30 Days, Past Year, or custom date ranges with multi-currency support.
- **Exportable Accounting Datasets**: One-click CSV downloads for billing and auditing.

### AI Magic Reports & SQL Insights Hub
Transform natural language questions into secure, optimized SQL queries and dynamic visual charts.

1. **Asking a Question**:
   - Type your prompt in plain English, for example:
     > *"Show me the top 10 most active courses by student completion in the last 30 days"*  
     > *"Which courses have the highest number of overdue assignments?"*  
     > *"Show monthly revenue distribution by course category for 2026"*
2. **AI Query Generation**:
   - Uses `local_aihub` (with fallback to Moodle Core AI `\core_ai\manager`) to translate the prompt into an executable database query.
3. **Interactive Visualizers**:
   - Automatically renders query results into interactive charts (Bar, Line, Pie, Radar) or formatted data tables.
4. **Report Management**:
   - **Save Report**: Save custom reports with custom titles and descriptions.
   - **Saved Reports Library**: Re-run, inspect, or delete saved reports anytime.
   - **SQL Inspection**: View and verify the generated SQL query for full data governance.

### Modular Risk Rule Engine Configuration
Configure risk calculation parameters under **Site Administration → Plugins → Local plugins → Smart Dashboard**:

| Subplugin Rule | Purpose | Configurable Parameters |
|---|---|---|
| `loginrecency` | Monitors student inactivity | Max inactive days threshold (default: 14 days), Rule weight |
| `coursecompletion` | Tracks stalled progress | Completion percentage threshold, Rule weight |
| `grades` | Flags low assignment/quiz averages | Failing score threshold, Rule weight |
| `safetynet70` | 70% safety net baseline | Minimum target threshold (70%), Rule weight |
| `overdue` | Flags missed activity deadlines | Max allowed overdue tasks, Rule weight |
| `adaptiveplan` | Tracks compliance with study plans | Daily task completion threshold, Rule weight |

### n8n Automation Webhook Setup
Automate external alerts (SMS, Slack, Microsoft Teams, WhatsApp, Email) when students trigger at-risk thresholds.

1. In your **n8n** instance, create a **Webhook** trigger node with HTTP `POST` method.
2. In Moodle, navigate to **Site Administration → Plugins → Local plugins → Smart Dashboard**.
3. Under **At-Risk Student Alerts**, enter:
   - **n8n Webhook URL**: `https://your-n8n-instance.com/webhook/smartdashboard-alerts`
   - **n8n Webhook Token**: Your secure Bearer authentication token.
4. When student risk levels are evaluated, Moodle dispatches JSON payloads to your workflow:

```json
{
  "event": "student_at_risk",
  "timestamp": 1787665313,
  "student": {
    "id": 42,
    "name": "Jane Doe",
    "email": "jane.doe@example.com"
  },
  "course": {
    "id": 15,
    "fullname": "Advanced Data Structures"
  },
  "risk": {
    "score": 85,
    "level": "high",
    "reasons": ["Inactive for 12 days", "Assignment 2 overdue"]
  }
}
```

### Dashboard Replacement & Automatic Redirection
Configure whether Smart Dashboard replaces the default Moodle `/my/` page:
- **Enable Dashboard Replacement**: Toggle on/off.
- **Roles to Redirect**: Select specific roles (e.g., Student, Teacher, Authenticated User).
- **Redirect Site Administrators**: Choose whether site administrators should also be redirected.

### Parent/Mentor Terminology Customization
Choose how the relationship is labeled throughout the user interface:
- Parent
- Mentor
- Partner
- Academic Supervisor
- Guardian
- Sponsor

### Customizing Student Quick-Access Shortcuts
Configure up to 10 icons in Site Administration:
- **Icon Name**: Label displayed beneath the icon (e.g., "Library", "Schedule", "Help Desk").
- **Icon Class (FontAwesome)**: FontAwesome CSS class (e.g., `fa-book`, `fa-calendar-check`, `fa-graduation-cap`, `fa-life-ring`).
- **Link URL**: Full internal or external URL target.

### Adding Standard Moodle Blocks to the Dashboard
To make any Moodle block available to be added to Smart Dashboard pages, add `'local-smartdashboard-*' => true` to the block's `applicable_formats()` method:

```php
// Inside blocks/<blockname>/block_<blockname>.php
public function applicable_formats() {
    return [
        'course-view'            => true,
        'site'                   => true,
        'my'                     => true,
        'local-smartdashboard-*' => true, // <-- Enable for Smart Dashboard
    ];
}
```
> **Note:** After modifying any block file, navigate to **Site Administration → Development → Purge caches** to refresh Moodle's block registry.

---

## 7. External Web Services API Reference

All Smart Dashboard endpoints are securely registered under the service `local_smartdashboard_webservice` with strict capability checks:

| Function Name | Method | Capability / Description |
|---|---|---|
| `local_smartdashboard_get_cross_course_progress` | `read` | Student course completion percentages and activity counts |
| `local_smartdashboard_get_student_detailed_progress` | `read` | Detailed per-activity completion breakdown for a specific student |
| `local_smartdashboard_get_grading_overview` | `read` | List of assignments and submissions awaiting grading across courses |
| `local_smartdashboard_get_system_analytics` | `read` | System-wide enrollment, category statistics, and student ratios |
| `local_smartdashboard_get_payment_analytics` | `read` | Revenue analytics, estimated vs. actual figures, and ROI metrics |
| `local_smartdashboard_save_dashboard_settings` | `write` | Save administrative dashboard configuration preferences |
| `local_smartdashboard_get_dashboard_settings` | `read` | Retrieve current dashboard configuration and shortcut settings |
| `local_smartdashboard_get_cross_course_grades` | `read` | Cross-course grade summaries and item breakdowns |
| `local_smartdashboard_get_magic_insight` | `read` | Natural language to SQL query generation via AI Hub |
| `local_smartdashboard_save_magic_report` | `write` | Persist a custom AI-generated report configuration |
| `local_smartdashboard_get_saved_reports` | `read` | Retrieve list of saved AI Magic Reports |
| `local_smartdashboard_delete_magic_report` | `write` | Remove a saved AI report configuration |
| `local_smartdashboard_get_programs` | `read` | Fetch program definitions and course IDs (`enrol_programs`) |
| `local_smartdashboard_dismiss_announcement` | `write` | AJAX dismissal preference for dashboard news notifications |
| `local_smartdashboard_get_daily_plan` | `read` | Fetch daily study pacing tasks (`mod_adaptiveplan`) |
| `local_smartdashboard_get_risk_data` | `read` | Fetch calculated student risk scores and engagement indicators |
| `local_smartdashboard_send_n8n_data` | `write` | Transmit risk alert payloads to external n8n webhooks |
| `local_smartdashboard_test_ai` | `read` | Test AI connectivity and prompt evaluation |

---

## 8. Troubleshooting & Frequently Asked Questions (FAQ)

### Q: Why do I see a blank page or outdated styles after an update?
**A:** Moodle aggressively caches JavaScript AMD modules and CSS. Go to **Site Administration → Development → Purge caches** and click **Purge all caches**, then hard-refresh your browser (`Ctrl + F5` or `Cmd + Shift + R`).

### Q: How do I make the dashboard the default landing page for students?
**A:** Go to **Site Administration → Plugins → Local plugins → Smart Dashboard**, enable **Enable Dashboard Replacement**, and select **Student** / **Authenticated user** in the **Roles to Redirect** list.

### Q: Why is AI Magic Reports not generating queries?
**A:** Ensure you have configured either:
1. The **AI Hub** plugin (`local_aihub`), or
2. Moodle Core AI (`\core_ai\manager`) with an active AI provider configured under **Site Administration → General → AI settings**.

### Q: Where can I see when the At-Risk calculation task runs?
**A:** The risk engine runs automatically via Moodle's scheduled tasks. You can view or trigger the task manually under **Site Administration → Server → Scheduled tasks → Calculate at-risk student scores** (`\local_smartdashboard\task\calculate_risk`).

### Q: Can parents see other students' grades?
**A:** No. Access control is strictly enforced via Moodle's context and capability system. Parents and mentors can only view data for users assigned to them via Moodle's official mentor/parent role assignments.

---

## 📄 License & Support

Smart Dashboard is distributed under the **GNU General Public License v3.0**.

- **Website**: [smartlearn.education](https://smartlearn.education)
- **Documentation**: [services.smartlearn.education/docs/smart-dashboard](https://services.smartlearn.education/docs/smart-dashboard)
- **Issue Tracker & Feature Requests**: [GitHub Issues](https://github.com/Smartlearn-edu/moodle_local_smartdashboard/issues)

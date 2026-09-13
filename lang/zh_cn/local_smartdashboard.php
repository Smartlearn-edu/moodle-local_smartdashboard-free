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
 * Simplified Chinese language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = '智能仪表盘';
$string['smartdashboard:view'] = '查看智能仪表盘';
$string['mycourses'] = '我的课程';
$string['nocourses'] = '您尚未教授任何课程。';
$string['gotocourse'] = '进入课程';
$string['students'] = '名学生';
$string['enrollments'] = '选课人次';
$string['activities'] = '活动';
$string['needsgrading'] = '待批改的提交';
$string['section_overview'] = '概览';
$string['section_grading'] = '评分';
$string['section_progress'] = '学生进度';
$string['section_analytics'] = '分析';
$string['section_settings'] = '设置';

// Student Dashboard Settings.
$string['student_icons_heading'] = '学生仪表盘图标';
$string['student_icons_desc'] = '配置学生仪表盘欢迎横幅上显示的图标。';
$string['icon_heading'] = '图标 {$a}';
$string['icon_name'] = '图标名称';
$string['icon_class'] = '图标类名 (FontAwesome)';
$string['icon_class_desc'] = '例如："fa-book"、"fa-graduation-cap"';
$string['icon_url'] = '链接网址';
$string['welcomebackstudent'] = '欢迎回来，{$a}！';
$string['privacy:metadata'] = '智能仪表盘插件不存储任何个人数据。';

// Dashboard Replacement Settings.
$string['redirect_heading'] = '替换仪表盘';
$string['redirect_desc'] = '配置智能仪表盘是否为特定角色替换 Moodle 默认仪表盘。';
$string['enabledirect'] = '启用仪表盘替换';
$string['enabledirect_desc'] = '如果启用，分配了选定角色的用户在访问默认仪表盘时将被重定向至此处。';
$string['redirectroles'] = '需要重定向的角色';
$string['redirectroles_desc'] = '选择应重定向到智能仪表盘的角色。在任何上下文中拥有这些角色之一的用户都将受到影响。';
$string['redirectadmins'] = '重定向网站管理员';
$string['redirectadmins_desc'] = '网站管理员是否也应该被重定向？';

// Appearance Settings.
$string['appearance_heading'] = '外观';
$string['appearance_desc'] = '自定义智能仪表盘的外观样式。';
$string['thememode'] = '颜色模式';
$string['thememode_desc'] = '选择仪表盘的颜色模式。如果您的 Moodle 主题为浅色背景，请选择“浅色”；若为深色主题站点，请选择“深色”。';
$string['thememode_dark'] = '深色模式';
$string['thememode_light'] = '浅色模式';
$string['todays_agenda'] = '今日日程';
$string['payment_calc_mode'] = '支付计算模式';
$string['payment_calc_mode_desc'] = '选择支付分析如何计算收入和学生人数。';
$string['save_settings'] = '保存设置';
$string['latest_announcements'] = '最新公告';
$string['dont_show_again'] = '不再显示此内容';
$string['close'] = '关闭';
$string['magic_reports_title'] = '魔法报告 (AI 分析)';
$string['magic_reports_desc'] = '用自然语言就您的数据提问，AI 将为您生成相应报告。';
$string['saved_reports'] = '已保存的报告';
$string['loading'] = '正在加载...';
$string['ask_a_question'] = '提出问题';
$string['generate'] = '生成';
$string['result'] = '结果';
$string['save_report'] = '保存报告';
$string['assignments_needing_grading'] = '待批改的作业';
$string['student_welcome_sub'] = '这里是您的学习进度与资源。';
$string['welcome_back'] = '欢迎回来！';
$string['teacher_welcome_sub'] = '这里是您教授的课程。跟踪学生学习进度、成绩批改及参与度分析。';
$string['parent_welcome_sub'] = '在这里您可以监督您辅导对象的学习进度和活动。';
$string['parent_mentees_title'] = '您的辅导对象';
$string['parent_overall_performance'] = '总体表现';
$string['parent_upcoming_deadlines'] = '即将截止的任务';
$string['parent_recent_results'] = '近期成绩';
$string['parent_no_data'] = '暂无数据';
$string['parent_view_calendar'] = '查看日历';
$string['parent_average_grade'] = '平均成绩';
$string['saving'] = '正在保存...';
$string['filter_by_cat'] = '按类别筛选';
$string['select_category'] = '选择一个类别...';
$string['show_courses'] = '显示课程';
$string['total_enrollments'] = '总选课人次';
$string['direct_sum'] = '直接累加';
$string['unique_students'] = '独立学生数';
$string['subcategories'] = '子类别';
$string['courses'] = '课程';
$string['select_category_to_view'] = '请选择一个类别并点击“显示课程”以查看数据。';
$string['select_category_to_filter'] = '选择特定类别以筛选结果。';
$string['no_courses_found'] = '未找到符合您选择的课程。';
$string['dashboard'] = '仪表盘';
$string['overview'] = '概览';
$string['risk'] = '风险详情';
$string['detailed'] = '详细';
$string['grades_overview'] = '成绩概览';
$string['payments'] = '支付';
$string['magic_reports'] = '魔法报告';
$string['payment_analytics'] = '支付分析';
$string['time_range'] = '时间范围';
$string['all_time'] = '全部时间';
$string['today'] = '今日';
$string['past_7_days'] = '过去 7 天';
$string['past_30_days'] = '过去 30 天';
$string['past_year'] = '过去一年';
$string['custom_range'] = '自定义范围';
$string['from'] = '起始';
$string['to'] = '截止';
$string['category'] = '类别';
$string['system_analytics'] = '系统分析';
$string['student_grades_will_appear'] = '学生成绩将显示在此处。';
$string['no_pending_tasks'] = '您今天没有待处理的任务或自适应学习计划。';
$string['caught_up'] = '您已完成所有待办事项！';
$string['due_today'] = '今日截止';
$string['go_to_course'] = '进入课程';
$string['role_student'] = '学生';
$string['role_teacher'] = '教师';
$string['role_parent'] = '家长';
$string['parent_terminology'] = '家长角色称谓';
$string['parent_terminology_desc'] = '选择在仪表盘中用于描述家长/导师角色的词语。';
$string['term_parent'] = '家长';
$string['term_mentor'] = '导师';
$string['term_partner'] = '伙伴';
$string['term_supervisor'] = '学业督导';
$string['term_guardian'] = '监护人';
$string['term_sponsor'] = '赞助人';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = '用户创建并保存的由 AI 生成的自定义报告。';
$string['privacy:metadata:reports:userid'] = '创建该报告的用户。';
$string['privacy:metadata:reports:title'] = '已保存报告的名称。';
$string['privacy:metadata:reports:description'] = '可选描述或原始 AI 提示词。';
$string['privacy:metadata:reports:sql_query'] = '为该报告生成的 SQL 查询。';
$string['privacy:metadata:reports:timecreated'] = '报告创建的时间。';
$string['privacy:metadata:reports:timemodified'] = '报告最后修改的时间。';
$string['privacy:metadata:preference:dismissed_announcements'] = '存储用户已关闭的仪表盘公告的 ID。';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = '由风险评估引擎每日计算的学生学业预警分数快照。';
$string['privacy:metadata:risk:userid'] = '被评估学业风险的学生。';
$string['privacy:metadata:risk:courseid'] = '风险评估所在的课程上下文。';
$string['privacy:metadata:risk:riskscore'] = '计算得出的风险分值 (0-100)。';
$string['privacy:metadata:risk:risklevel'] = '风险等级分类（低、中或高）。';
$string['privacy:metadata:risk:timecreated'] = '风险快照计算的时间。';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = '学业预警学生的数据可能会发送到管理员配置的外部 n8n 工作流 Webhook。';
$string['privacy:metadata:n8n:userid'] = '处于预警状态学生的唯一个人 ID。';
$string['privacy:metadata:n8n:courseid'] = '与风险预警相关的课程 ID。';
$string['privacy:metadata:n8n:riskscore'] = '发送到外部 Webhook 的风险分值。';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = '学生成绩的历史 AI 分析与反馈记录。';
$string['privacy:metadata:ai_grades:userid'] = '成绩被分析的学生。';
$string['privacy:metadata:ai_grades:report_html'] = '由 AI 生成的反馈与建议 HTML 内容。';
$string['privacy:metadata:ai_grades:timecreated'] = '生成分析时的时间戳。';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = '计算学业预警学生的分值';
$string['risk_heading'] = '学业预警学生提醒';
$string['risk_heading_desc'] = '配置学业预警早期提醒系统。风险评估引擎每日运行，根据以下加权标准为每位学生评分。当学生变为高风险状态时，将自动通知教师。';
$string['n8n_webhook_url'] = 'n8n Webhook 网址';
$string['n8n_webhook_url_desc'] = '用于发送学业预警学生数据的 n8n 工作流 Webhook 网址。';
$string['n8n_webhook_token'] = 'n8n Webhook 令牌';
$string['n8n_webhook_token_desc'] = '用于在 n8n Webhook 进行身份验证的可选 Bearer 令牌。';
$string['risk_max_inactive_days'] = '最大未活跃天数';
$string['risk_max_inactive_days_desc'] = '登录风险分数达到 100% 前允许的不活跃天数。默认值：14 天。';
$string['risk_weight_login'] = '权重：登录新鲜度';
$string['risk_weight_completion'] = '权重：课程完成度';
$string['risk_weight_grade'] = '权重：课程成绩';
$string['risk_weight_overdue'] = '权重：逾期活动';
$string['risk_weight_adaptiveplan'] = '权重：自适应计划依从度';
$string['risk_weight_desc'] = '此标准的相对权重（数值将归一化至 100%）。默认值：20。';
$string['risk_weight_adaptiveplan_desc'] = '自适应计划依从度的相对权重。如果未安装 mod_adaptiveplan，将自动重新分配。默认值：20。';
$string['risk_alert_subject'] = '学业预警提醒：{$a} 需要关注';
$string['risk_alert_body'] = '学生 {$a->studentname} 在课程“{$a->coursename}”中已被标记为有学业预警风险，风险分值为 {$a->riskscore}%。

请检查该学生的学习进度，并考虑主动联系以提供支持。

查看仪表盘以了解更多详情。';
$string['risk_alert_body_html'] = '<p><strong>学生 {$a->studentname}</strong> 在课程“<strong>{$a->coursename}</strong>”中已被标记为<span style="color:#dc3545;font-weight:bold;">学业预警</span>状态，风险分值为 <strong>{$a->riskscore}%</strong>。</p><p>请检查该学生的学习进度，并考虑主动联系以提供支持。</p>';
$string['risk_alert_small'] = '{$a->studentname} 在 {$a->coursename} 处于预警状态';
$string['risk_level_low'] = '正常跟踪';
$string['risk_level_medium'] = '需要关注';
$string['risk_level_high'] = '学业预警';
$string['risk_score'] = '风险分值';
$string['risk_no_data'] = '暂无风险数据。系统每日计算风险分值。';
$string['messageprovider:risk_alert'] = '学业预警学生通知';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = '智能仪表盘风险规则';
$string['subplugintype_smartdashboardrule_plural'] = '智能仪表盘风险规则';

// Mobile App Support.
$string['mobile_no_data'] = '暂无数据。下拉可刷新。';
$string['at_risk_students'] = '预警学生';
$string['risk_high'] = '高风险';
$string['risk_medium'] = '中风险';
$string['risk_low'] = '低风险';
$string['grading_pending'] = '待批改';
$string['total_students'] = '学生总数';
$string['total_courses'] = '课程总数';
$string['due_date'] = '截止日期';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = '访问被拒绝';
$string['error_webhook_not_configured'] = 'n8n Webhook 网址尚未配置。';
$string['error_invalid_json'] = '无效的 JSON 数据载荷。';
$string['error_invalid_action'] = '无效的操作';
$string['error_n8n_error'] = 'n8n 错误：{$a}';
$string['success_data_sent'] = '数据已成功发送至 n8n！';
$string['student_count_display'] = '学生人数显示方式';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = '所有课程中的学生总人次（包含重复计入）';
$string['unique_students_tooltip'] = '独立学生人数（去重）';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = '例如：显示完成率最低的前 5 门课程...';
$string['magic_ai_description'] = '利用 AI 将自然语言转换为 SQL 查询。';
$string['show_generated_sql'] = '显示生成的 SQL';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = '收入分布';
$string['chart_students_revenue_category'] = '各类别学生数与收入';

// Student Overview strings.
$string['student_my_courses'] = '我的课程';
$string['student_upcoming_deadlines'] = '即将截止的任务';
$string['student_my_grades'] = '我的成绩';
$string['student_overall_average'] = '总体平均分';
$string['student_complete'] = '已完成';
$string['student_no_deadlines'] = '没有即将截止的任务 — 您已处理完所有事项！';
$string['student_no_grades'] = '暂无可用成绩。';
$string['student_no_courses'] = '您尚未加入任何课程。';
$string['student_no_progress'] = '未跟踪';
$string['student_due_soon'] = '还有 {$a} 天';
$string['student_view_course'] = '查看课程';
$string['student_course_progress'] = '课程进度';
$string['student_active_courses'] = '活跃课程';
$string['student_next_deadline'] = '下一个截止时间';
$string['student_recent_feedback'] = '近期反馈';
$string['student_no_feedback'] = '暂无最新反馈。';
$string['student_none'] = '无';
$string['student_my_badges'] = '我的最新勋章';
$string['student_no_badges'] = '您尚未获得任何勋章。继续加油！';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = '查看学生课程成绩报告';
$string['studentgrades:viewall'] = '查看所有用户的课程成绩报告';
$string['selectuser'] = '选择用户';
$string['exporthtml'] = '导出为 HTML';
$string['includedescription'] = '包含描述';
$string['nousers'] = '未找到用户';
$string['student_nocourses'] = '该学生未选修任何课程';
$string['user'] = '学生';
$string['reportdate'] = '报告日期';
$string['coursename'] = '课程';
$string['gradeitem'] = '成绩项';
$string['grade'] = '成绩';
$string['range'] = '范围';
$string['percentage'] = '百分比';
$string['total'] = '总计';
$string['coursetotal'] = '课程总分';
$string['overallsummary'] = '总体概括';
$string['totalcourses'] = '课程总数';
$string['viewmygrades'] = '查看我的成绩';
$string['exportmygrades'] = '导出我的成绩';
// Added for marketplace compliance
$string['nocontenttoexport'] = '没有可导出的内容。';
$string['filtergrades'] = '筛选成绩';
$string['allcourses'] = '全部课程';
$string['categorysearch'] = '类别 / 搜索';
$string['typetofilter'] = '输入以筛选...';
$string['analyzeandemail'] = '分析并通过邮件发送给我';
$string['dailylimitreached'] = '已达每日上限。请等待 {$a} 分钟后再生成新的分析。';
$string['viewanalysisnow'] = '立即查看分析';
$string['generatinganalysis'] = '正在生成分析...';
$string['talkingtocoreai'] = '正在与 Moodle AI 通信...';
$string['aianalysisresult'] = 'AI 分析结果';
$string['downloadpdf'] = '下载 PDF';
$string['communicationerror'] = '通信错误';
$string['analysishistory'] = '分析历史';
$string['defaultprompt'] = '您是一名教育 AI 助手。请分析以下学生的学业表现数据。数据包括课程描述、活动、最高成绩、学生成绩和活动说明。请根据这些数据，对学生的优势和需要改进的方面提供建设性的分析。';
$string['privacy:metadata:userid'] = '用户 ID。';
$string['privacy:metadata:grades'] = '用户的成绩数据。';
$string['privacy:metadata:n8n_webhook_summary'] = '成绩数据将发送至 n8n Webhook 以进行 AI 分析。';
$string['permissiondenied'] = '权限被拒绝。您当前以用户 ID: {$a->currentuserid} 登录，但请求了用户 ID: {$a->userid} 的数据。需要相应的权限或关联的家长账户。';
$string['airesponsesuccessnocontent'] = 'AI 响应成功但无内容。原始数据：{$a}';
$string['aiprovidererror'] = 'AI 服务商错误：{$a}';
$string['errorinitializingai'] = '初始化 AI 操作时出错：{$a}';
$string['aimockresponse'] = 'AI 系统响应：您好！我已收到您的消息。（未检测到 Moodle 核心 AI 类，显示模拟响应）';
$string['generalerror'] = '错误：{$a}';
$string['invalidaction'] = '无效的操作';
$string['success'] = '成功';
$string['unknownerror'] = '发生未知错误';
$string['aiconfigmissing'] = '在学生成绩报告设置中未找到 AI 配置（Webhook 网址）。';
$string['analysisrequestsent'] = '分析请求已成功发送！';
$string['failedtosenddata'] = '发送数据失败。HTTP 代码：{$a->code} 响应：{$a->response}';
// Color Settings
$string['colorsettings'] = '颜色设置';
$string['colorsettingsdesc'] = '自定义 HTML 导出成绩报告中所使用的颜色。这些设置可让您契合机构的品牌形象并提升视觉可读性。';
// Header Colors
$string['headerprimarycolor'] = '页眉主颜色';
$string['headerprimarycolordesc'] = '报告页眉渐变背景的主颜色';
$string['headersecondarycolor'] = '页眉次要颜色';
$string['headersecondarycolordesc'] = '报告页眉渐变背景的次要颜色';
$string['headertextcolor'] = '页眉文本颜色';
$string['headertextcolordesc'] = '报告页眉的文本颜色';
// Grade Performance Colors
$string['gradeexcellentcolor'] = '优秀成绩颜色';
$string['gradeexcellentcolordesc'] = '优秀成绩表现指标的颜色';
$string['gradegoodcolor'] = '良好成绩颜色';
$string['gradegoodcolordesc'] = '良好成绩表现指标的颜色';
$string['gradeaveragecolor'] = '一般成绩颜色';
$string['gradeaveragecolordesc'] = '一般/中等成绩表现指标的颜色';
$string['gradepoorcolor'] = '较差成绩颜色';
$string['gradepoorcolordesc'] = '较差成绩表现指标的颜色';
// Table Colors
$string['tablebordercolor'] = '表格边框颜色';
$string['tablebordercolordesc'] = '表格边框和单元格分隔线的颜色';
$string['rowalternatecolor'] = '隔行交替颜色';
$string['rowalternatecolordesc'] = '表格交替行的背景颜色';
$string['rowhovercolor'] = '行悬停颜色';
$string['rowhovercolordesc'] = '鼠标悬停在表格行时的背景颜色';
// Category Colors
$string['categoryprimarycolor'] = '类别主颜色';
$string['categoryprimarycolordesc'] = '类别行渐变背景的主颜色';
$string['categorysecondarycolor'] = '类别次要颜色';
$string['categorysecondarycolordesc'] = '类别行渐变背景的次要颜色';
// Total Row Colors
$string['categorytotalprimarycolor'] = '类别总计行主颜色';
$string['categorytotalprimarycolordesc'] = '类别总计行渐变背景的主颜色';
$string['categorytotalsecondarycolor'] = '类别总计行次要颜色';
$string['categorytotalsecondarycolordesc'] = '类别总计行渐变背景的次要颜色';
$string['coursetotalprimarycolor'] = '课程总计行主颜色';
$string['coursetotalprimarycolordesc'] = '课程总计行渐变背景的主颜色';
$string['coursetotalsecondarycolor'] = '课程总计行次要颜色';
$string['coursetotalsecondarycolordesc'] = '课程总计行渐变背景的次要颜色';
// Grade Value Colors
$string['gradevaluecolor'] = '成绩数值文本颜色';
$string['gradevaluecolordesc'] = '成绩数值的文本颜色';
$string['gradevaluebgcolor'] = '成绩数值背景颜色';
$string['gradevaluebgcolordesc'] = '成绩数值单元格的背景颜色';
$string['percentagecolor'] = '百分比文本颜色';
$string['percentagecolordesc'] = '百分比数值的文本颜色';
$string['percentagebgcolor'] = '百分比背景颜色';
$string['percentagebgcolordesc'] = '百分比单元格的背景颜色';
// AI Settings
$string['aisettings'] = 'AI 分析设置';
$string['aisettingsdesc'] = '配置通过 n8n 与外部 AI 服务的集成。';
$string['enableemailanalysis'] = '启用通过邮件发送分析';
$string['enableemailanalysisdesc'] = '允许用户请求将分析报告发送到其电子邮箱。';
$string['enableinstantanalysis'] = '启用即时分析';
$string['enableinstantanalysisdesc'] = '允许用户在模态弹窗中即时查看分析报告。';
$string['webhookurl'] = 'n8n Webhook 网址';
$string['webhookurldesc'] = '用于处理学生成绩数据的 n8n Webhook 网址。';
$string['token'] = 'n8n Webhook 令牌';
$string['tokendesc'] = '用于在 n8n Webhook 身份验证的安全令牌（在标头中发送）。';
$string['aiprompt'] = 'AI 分析提示词';
$string['aipromptdesc'] = '与学生数据一起发送给 AI 的提示词。自定义此项以调整分析的语气或重点。';
$string['aicooldown'] = '分析冷却时间（分钟）';
$string['aicooldowndesc'] = '分析请求之间的最短时间间隔（分钟），以节省关键数据资源。设为 0 则禁用。';
// Reset Information
$string['resetcolorsheading'] = '重置颜色';
$string['resetcolorsdesc'] = '若要将所有颜色重置为默认值，请清空每个颜色字段并保存设置。插件将自动采用默认配色方案。';

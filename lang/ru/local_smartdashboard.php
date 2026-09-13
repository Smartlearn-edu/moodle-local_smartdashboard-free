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
 * Russian language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Интеллектуальная панель';
$string['smartdashboard:view'] = 'Просмотр интеллектуальной панели';
$string['mycourses'] = 'Мои курсы';
$string['nocourses'] = 'Вы пока не ведете ни одного курса.';
$string['gotocourse'] = 'Перейти к курсу';
$string['students'] = 'студенты';
$string['enrollments'] = 'Зачисления';
$string['activities'] = 'Активности';
$string['needsgrading'] = 'Работы, требующие проверки';
$string['section_overview'] = 'Обзор';
$string['section_grading'] = 'Оценивание';
$string['section_progress'] = 'Прогресс студентов';
$string['section_analytics'] = 'Аналитика';
$string['section_settings'] = 'Настройки';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Иконки панели студента';
$string['student_icons_desc'] = 'Настройте иконки, отображаемые на приветственном баннере панели студента.';
$string['icon_heading'] = 'Иконка {$a}';
$string['icon_name'] = 'Название иконки';
$string['icon_class'] = 'Класс иконки (FontAwesome)';
$string['icon_class_desc'] = 'например, "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'URL ссылки';
$string['welcomebackstudent'] = 'С возвращением, {$a}!';
$string['privacy:metadata'] = 'Плагин «Интеллектуальная панель» не сохраняет никаких персональных данных.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Замена личного кабинета';
$string['redirect_desc'] = 'Настройте, заменяет ли Интеллектуальная панель стандартный личный кабинет Moodle для определенных ролей.';
$string['enabledirect'] = 'Включить замену личного кабинета';
$string['enabledirect_desc'] = 'Если включено, пользователи с выбранными ролями при переходе в стандартный личный кабинет будут перенаправлены сюда.';
$string['redirectroles'] = 'Роли для перенаправления';
$string['redirectroles_desc'] = 'Выберите роли, которые следует перенаправлять на Интеллектуальную панель. Это повлияет на пользователей с ЛЮБОЙ из этих ролей в ЛЮБОМ контексте.';
$string['redirectadmins'] = 'Перенаправлять администраторов сайта';
$string['redirectadmins_desc'] = 'Следует ли также перенаправлять администраторов сайта?';

// Appearance Settings.
$string['appearance_heading'] = 'Внешний вид';
$string['appearance_desc'] = 'Настройте внешний вид Интеллектуальной панели.';
$string['thememode'] = 'Цветовая схема';
$string['thememode_desc'] = 'Выберите цветовую схему для панели. Используйте «Светлая», если ваша тема Moodle со светлым фоном, или «Темная» для сайтов с темной темой.';
$string['thememode_dark'] = 'Темная тема';
$string['thememode_light'] = 'Светлая тема';
$string['todays_agenda'] = 'План на сегодня';
$string['payment_calc_mode'] = 'Режим расчета платежей';
$string['payment_calc_mode_desc'] = 'Выберите, как аналитика платежей рассчитывает доход и количество студентов.';
$string['save_settings'] = 'Сохранить настройки';
$string['latest_announcements'] = 'Последние объявления';
$string['dont_show_again'] = 'Больше не показывать';
$string['close'] = 'Закрыть';
$string['magic_reports_title'] = 'Магические отчеты (Анализ ИИ)';
$string['magic_reports_desc'] = 'Задавайте вопросы о ваших данных на обычном языке, и искусственный интеллект сформирует отчет для вас.';
$string['saved_reports'] = 'Сохраненные отчеты';
$string['loading'] = 'Загрузка...';
$string['ask_a_question'] = 'Задайте вопрос';
$string['generate'] = 'Сгенерировать';
$string['result'] = 'Результат';
$string['save_report'] = 'Сохранить отчет';
$string['assignments_needing_grading'] = 'Задания, требующие проверки';
$string['student_welcome_sub'] = 'Здесь представлены ваши успехи и учебные материалы.';
$string['welcome_back'] = 'С возвращением!';
$string['teacher_welcome_sub'] = 'Здесь представлены курсы, которые вы ведете. Отслеживайте прогресс студентов, оценивание и данные об их активности.';
$string['parent_welcome_sub'] = 'Здесь вы можете отслеживать успеваемость и активность ваших подопечных.';
$string['parent_mentees_title'] = 'Ваши подопечные';
$string['parent_overall_performance'] = 'Общая успеваемость';
$string['parent_upcoming_deadlines'] = 'Ближайшие сроки сдачи';
$string['parent_recent_results'] = 'Последние результаты';
$string['parent_no_data'] = 'Нет данных';
$string['parent_view_calendar'] = 'Посмотреть календарь';
$string['parent_average_grade'] = 'Средняя оценка';
$string['saving'] = 'Сохранение...';
$string['filter_by_cat'] = 'Фильтр по категориям';
$string['select_category'] = 'Выберите категорию...';
$string['show_courses'] = 'Показать курсы';
$string['total_enrollments'] = 'Всего зачислений';
$string['direct_sum'] = 'Прямая сумма';
$string['unique_students'] = 'Уникальные студенты';
$string['subcategories'] = 'Подкатегории';
$string['courses'] = 'Курсы';
$string['select_category_to_view'] = 'Пожалуйста, выберите категорию и нажмите «Показать курсы» для просмотра данных.';
$string['select_category_to_filter'] = 'Выберите определенную категорию для фильтрации результатов.';
$string['no_courses_found'] = 'Не найдено курсов, соответствующих вашему выбору.';
$string['dashboard'] = 'Личный кабинет';
$string['overview'] = 'Обзор';
$string['risk'] = 'Информация о рисках';
$string['detailed'] = 'Подробно';
$string['grades_overview'] = 'Обзор оценок';
$string['payments'] = 'Платежи';
$string['magic_reports'] = 'Магические отчеты';
$string['payment_analytics'] = 'Аналитика платежей';
$string['time_range'] = 'Временной диапазон';
$string['all_time'] = 'За все время';
$string['today'] = 'Сегодня';
$string['past_7_days'] = 'За последние 7 дней';
$string['past_30_days'] = 'За последние 30 дней';
$string['past_year'] = 'За прошлый год';
$string['custom_range'] = 'Пользовательский диапазон';
$string['from'] = 'С';
$string['to'] = 'По';
$string['category'] = 'Категория';
$string['system_analytics'] = 'Системная аналитика';
$string['student_grades_will_appear'] = 'Здесь появятся оценки студента.';
$string['no_pending_tasks'] = 'У вас нет ожидающих задач или адаптивных планов обучения на сегодня.';
$string['caught_up'] = 'Все задания выполнены!';
$string['due_today'] = 'Срок сдачи сегодня';
$string['go_to_course'] = 'Перейти к курсу';
$string['role_student'] = 'Студент';
$string['role_teacher'] = 'Преподаватель';
$string['role_parent'] = 'Родитель';
$string['parent_terminology'] = 'Терминология роли родителя';
$string['parent_terminology_desc'] = 'Выберите слово, используемое для описания роли Родителя/Наставника на панели.';
$string['term_parent'] = 'Родитель';
$string['term_mentor'] = 'Наставник';
$string['term_partner'] = 'Партнер';
$string['term_supervisor'] = 'Академический куратор';
$string['term_guardian'] = 'Опекун';
$string['term_sponsor'] = 'Спонсор';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Сохраненные пользовательские отчеты, созданные с помощью ИИ.';
$string['privacy:metadata:reports:userid'] = 'Пользователь, создавший отчет.';
$string['privacy:metadata:reports:title'] = 'Название сохраненного отчета.';
$string['privacy:metadata:reports:description'] = 'Необязательное описание или исходный запрос к ИИ.';
$string['privacy:metadata:reports:sql_query'] = 'SQL-запрос, сгенерированный для отчета.';
$string['privacy:metadata:reports:timecreated'] = 'Время создания отчета.';
$string['privacy:metadata:reports:timemodified'] = 'Время последнего изменения отчета.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Хранит идентификаторы объявлений панели, которые пользователь скрыл.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Снимки оценок студентов группы риска, рассчитываемые ежедневно механизмом анализа рисков.';
$string['privacy:metadata:risk:userid'] = 'Студент, чей риск оценивался.';
$string['privacy:metadata:risk:courseid'] = 'Контекст курса для оценки риска.';
$string['privacy:metadata:risk:riskscore'] = 'Рассчитанный показатель риска (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'Классификация риска (низкий, средний или высокий).';
$string['privacy:metadata:risk:timecreated'] = 'Время расчета показателя риска.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Данные студентов группы риска могут отправляться во внешний вебхук n8n, настроенный администратором.';
$string['privacy:metadata:n8n:userid'] = 'ID пользователя студента группы риска.';
$string['privacy:metadata:n8n:courseid'] = 'ID курса, связанного с оповещением о риске.';
$string['privacy:metadata:n8n:riskscore'] = 'Показатель риска, отправленный во внешний вебхук.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'История анализа ИИ и отзывы по оценкам студента.';
$string['privacy:metadata:ai_grades:userid'] = 'Студент, чьи оценки были проанализированы.';
$string['privacy:metadata:ai_grades:report_html'] = 'HTML-код рекомендаций и отзывов, сгенерированных ИИ.';
$string['privacy:metadata:ai_grades:timecreated'] = 'Временная метка генерации анализа.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Расчет показателей студентов группы риска';
$string['risk_heading'] = 'Оповещения о студентах группы риска';
$string['risk_heading_desc'] = 'Настройте систему раннего предупреждения о студентах группы риска. Механизм анализа рисков запускается ежедневно и оценивает каждого студента на основе приведенных ниже взвешенных критериев. Преподаватели автоматически получают уведомления, когда риск студента становится высоким.';
$string['n8n_webhook_url'] = 'URL вебхука n8n';
$string['n8n_webhook_url_desc'] = 'URL-адрес вебхука рабочего процесса n8n для отправки данных студентов группы риска.';
$string['n8n_webhook_token'] = 'Токен вебхука n8n';
$string['n8n_webhook_token_desc'] = 'Необязательный токен Bearer для аутентификации в вебхуке n8n.';
$string['risk_max_inactive_days'] = 'Макс. дней неактивности';
$string['risk_max_inactive_days_desc'] = 'Количество дней неактивности, после которого показатель риска по входу достигает 100%. По умолчанию: 14 дней.';
$string['risk_weight_login'] = 'Вес: Свежесть входа';
$string['risk_weight_completion'] = 'Вес: Завершение курса';
$string['risk_weight_grade'] = 'Вес: Оценка за курс';
$string['risk_weight_overdue'] = 'Вес: Просроченные задания';
$string['risk_weight_adaptiveplan'] = 'Вес: Выполнение адаптивного плана';
$string['risk_weight_desc'] = 'Относительный вес для этого критерия (значения нормализуются до 100%). По умолчанию: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Относительный вес выполнения адаптивного плана. Автоматически перераспределяется, если mod_adaptiveplan не установлен. По умолчанию: 20.';
$string['risk_alert_subject'] = 'Оповещение о риске: {$a} требует внимания';
$string['risk_alert_body'] = 'Студент {$a->studentname} отмечен как входящий в группу риска в курсе "{$a->coursename}" с показателем риска {$a->riskscore}%.

Пожалуйста, проверьте успеваемость этого студента и рассмотрите возможность предложить ему помощь.

Перейдите в панель управления для получения подробной информации.';
$string['risk_alert_body_html'] = '<p><strong>Студент {$a->studentname}</strong> был отмечен как находящийся <span style="color:#dc3545;font-weight:bold;">в группе риска</span> в курсе "<strong>{$a->coursename}</strong>" с показателем риска <strong>{$a->riskscore}%</strong>.</p><p>Пожалуйста, проверьте успеваемость этого студента и рассмотрите возможность оказать ему поддержку.</p>';
$string['risk_alert_small'] = '{$a->studentname} в группе риска в {$a->coursename}';
$string['risk_level_low'] = 'В норме';
$string['risk_level_medium'] = 'На контроле';
$string['risk_level_high'] = 'В группе риска';
$string['risk_score'] = 'Показатель риска';
$string['risk_no_data'] = 'Данные о рисках пока недоступны. Система рассчитывает показатели риска ежедневно.';
$string['messageprovider:risk_alert'] = 'Уведомления о студентах группы риска';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Правило риска интеллектуальной панели';
$string['subplugintype_smartdashboardrule_plural'] = 'Правила риска интеллектуальной панели';

// Mobile App Support.
$string['mobile_no_data'] = 'Нет данных. Потяните вниз, чтобы обновить.';
$string['at_risk_students'] = 'Студенты группы риска';
$string['risk_high'] = 'Высокий риск';
$string['risk_medium'] = 'Средний риск';
$string['risk_low'] = 'Низкий риск';
$string['grading_pending'] = 'Ожидает оценки';
$string['total_students'] = 'Всего студентов';
$string['total_courses'] = 'Всего курсов';
$string['due_date'] = 'Срок сдачи';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Доступ запрещен';
$string['error_webhook_not_configured'] = 'URL вебхука n8n не настроен.';
$string['error_invalid_json'] = 'Недопустимые данные JSON.';
$string['error_invalid_action'] = 'Недопустимое действие';
$string['error_n8n_error'] = 'Ошибка n8n: {$a}';
$string['success_data_sent'] = 'Данные успешно отправлены в n8n!';
$string['student_count_display'] = 'Отображение количества студентов';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Сумма студентов во всех курсах (включает дубликаты)';
$string['unique_students_tooltip'] = 'Количество уникальных студентов (без дубликатов)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'напр., Покажи топ-5 курсов с самым низким уровнем завершения...';
$string['magic_ai_description'] = 'Использование ИИ для перевода естественного языка в SQL-запросы.';
$string['show_generated_sql'] = 'Показать сгенерированный SQL';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Распределение доходов';
$string['chart_students_revenue_category'] = 'Студенты и доход по категориям';

// Student Overview strings.
$string['student_my_courses'] = 'Мои курсы';
$string['student_upcoming_deadlines'] = 'Ближайшие сроки сдачи';
$string['student_my_grades'] = 'Мои оценки';
$string['student_overall_average'] = 'Общий средний балл';
$string['student_complete'] = 'завершено';
$string['student_no_deadlines'] = 'Нет предстоящих сроков сдачи — вы все выполнили!';
$string['student_no_grades'] = 'Оценок пока нет.';
$string['student_no_courses'] = 'Вы не записаны ни на один курс.';
$string['student_no_progress'] = 'Не отслеживается';
$string['student_due_soon'] = 'Через {$a} дн.';
$string['student_view_course'] = 'Просмотреть курс';
$string['student_course_progress'] = 'Прогресс в курсе';
$string['student_active_courses'] = 'Активные курсы';
$string['student_next_deadline'] = 'Следующий срок сдачи';
$string['student_recent_feedback'] = 'Последние отзывы';
$string['student_no_feedback'] = 'Нет недавних отзывов.';
$string['student_none'] = 'Нет';
$string['student_my_badges'] = 'Мои последние значки';
$string['student_no_badges'] = 'Вы еще не получили ни одного значка. Продолжайте стараться!';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Просмотр отчета об оценках студента по курсу';
$string['studentgrades:viewall'] = 'Просмотр отчетов об оценках по курсу всех пользователей';
$string['selectuser'] = 'Выберите пользователя';
$string['exporthtml'] = 'Экспорт в HTML';
$string['includedescription'] = 'Включить описание';
$string['nousers'] = 'Пользователи не найдены';
$string['student_nocourses'] = 'Студент не записан ни на один курс';
$string['user'] = 'Студент';
$string['reportdate'] = 'Дата отчета';
$string['coursename'] = 'Курс';
$string['gradeitem'] = 'Элемент оценивания';
$string['grade'] = 'Оценка';
$string['range'] = 'Диапазон';
$string['percentage'] = 'Процент';
$string['total'] = 'Итого';
$string['coursetotal'] = 'Итог по курсу';
$string['overallsummary'] = 'Общая сводка';
$string['totalcourses'] = 'Всего курсов';
$string['viewmygrades'] = 'Посмотреть мои оценки';
$string['exportmygrades'] = 'Экспортировать мои оценки';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Нет содержимого для экспорта.';
$string['filtergrades'] = 'Фильтровать оценки';
$string['allcourses'] = 'Все курсы';
$string['categorysearch'] = 'Категория / Поиск';
$string['typetofilter'] = 'Введите для фильтрации...';
$string['analyzeandemail'] = 'Проанализировать и отправить мне';
$string['dailylimitreached'] = 'Достигнут дневной лимит. Пожалуйста, подождите {$a} мин. перед генерацией нового анализа.';
$string['viewanalysisnow'] = 'Посмотреть анализ сейчас';
$string['generatinganalysis'] = 'Генерация анализа...';
$string['talkingtocoreai'] = 'Связь с Moodle AI...';
$string['aianalysisresult'] = 'Результат анализа ИИ';
$string['downloadpdf'] = 'Скачать PDF';
$string['communicationerror'] = 'Ошибка связи';
$string['analysishistory'] = 'История анализов';
$string['defaultprompt'] = 'Вы — образовательный ИИ-ассистент. Проанализируйте следующие данные об успеваемости студента. Данные включают описания курсов, активности, максимальные баллы, оценки студента и описания заданий. Предоставьте конструктивный анализ сильных сторон студента и областей, требующих улучшения, на основе этих данных.';
$string['privacy:metadata:userid'] = 'ID пользователя.';
$string['privacy:metadata:grades'] = 'Данные об оценках пользователя.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Данные оценок отправляются в вебхук n8n для анализа ИИ.';
$string['permissiondenied'] = 'В доступе отказано. Вы вошли с ID пользователя: {$a->currentuserid}, но запросили данные для ID пользователя: {$a->userid}. Требуются соответствующие права или привязанная учетная запись родителя.';
$string['airesponsesuccessnocontent'] = 'Ответ ИИ успешен, но содержимое отсутствует. Необработанные данные: {$a}';
$string['aiprovidererror'] = 'Ошибка поставщика ИИ: {$a}';
$string['errorinitializingai'] = 'Ошибка инициализации действия ИИ: {$a}';
$string['aimockresponse'] = 'Ответ системы ИИ: Здравствуйте! Я получил ваше сообщение. (Классы Moodle Core AI не обнаружены, отображается тестовый ответ)';
$string['generalerror'] = 'Ошибка: {$a}';
$string['invalidaction'] = 'Недопустимое действие';
$string['success'] = 'Успешно';
$string['unknownerror'] = 'Произошла неизвестная ошибка';
$string['aiconfigmissing'] = 'Конфигурация ИИ (URL вебхука) не найдена в настройках отчета об оценках студентов.';
$string['analysisrequestsent'] = 'Запрос на анализ успешно отправлен!';
$string['failedtosenddata'] = 'Не удалось отправить данные. Код HTTP: {$a->code} Ответ: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Настройки цветов';
$string['colorsettingsdesc'] = 'Настройте цвета, используемые в HTML-отчетах об оценках. Эти параметры позволяют соответствовать фирменному стилю учебного заведения и повысить доступность восприятия.';
// Header Colors
$string['headerprimarycolor'] = 'Основной цвет заголовка';
$string['headerprimarycolordesc'] = 'Основной цвет градиентного фона заголовка отчета';
$string['headersecondarycolor'] = 'Вторичный цвет заголовка';
$string['headersecondarycolordesc'] = 'Вторичный цвет градиентного фона заголовка отчета';
$string['headertextcolor'] = 'Цвет текста заголовка';
$string['headertextcolordesc'] = 'Цвет текста для заголовка отчета';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Цвет отличной оценки';
$string['gradeexcellentcolordesc'] = 'Цвет индикатора отличной успеваемости';
$string['gradegoodcolor'] = 'Цвет хорошей оценки';
$string['gradegoodcolordesc'] = 'Цвет индикатора хорошей успеваемости';
$string['gradeaveragecolor'] = 'Цвет средней оценки';
$string['gradeaveragecolordesc'] = 'Цвет индикатора средней успеваемости';
$string['gradepoorcolor'] = 'Цвет неудовлетворительной оценки';
$string['gradepoorcolordesc'] = 'Цвет индикатора низкой успеваемости';
// Table Colors
$string['tablebordercolor'] = 'Цвет границ таблицы';
$string['tablebordercolordesc'] = 'Цвет границ таблицы и разделителей ячеек';
$string['rowalternatecolor'] = 'Цвет чередующихся строк';
$string['rowalternatecolordesc'] = 'Цвет фона для чередующихся строк таблицы';
$string['rowhovercolor'] = 'Цвет строки при наведении';
$string['rowhovercolordesc'] = 'Цвет фона при наведении курсора на строки таблицы';
// Category Colors
$string['categoryprimarycolor'] = 'Основной цвет категории';
$string['categoryprimarycolordesc'] = 'Основной цвет градиентного фона строки категории';
$string['categorysecondarycolor'] = 'Вторичный цвет категории';
$string['categorysecondarycolordesc'] = 'Вторичный цвет градиентного фона строки категории';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Основной цвет итога категории';
$string['categorytotalprimarycolordesc'] = 'Основной цвет градиентного фона строки итога категории';
$string['categorytotalsecondarycolor'] = 'Вторичный цвет итога категории';
$string['categorytotalsecondarycolordesc'] = 'Вторичный цвет градиентного фона строки итога категории';
$string['coursetotalprimarycolor'] = 'Основной цвет итога по курсу';
$string['coursetotalprimarycolordesc'] = 'Основной цвет градиентного фона строки итога по курсу';
$string['coursetotalsecondarycolor'] = 'Вторичный цвет итога по курсу';
$string['coursetotalsecondarycolordesc'] = 'Вторичный цвет градиентного фона строки итога по курсу';
// Grade Value Colors
$string['gradevaluecolor'] = 'Цвет текста значения оценки';
$string['gradevaluecolordesc'] = 'Цвет текста для значений оценок';
$string['gradevaluebgcolor'] = 'Цвет фона значения оценки';
$string['gradevaluebgcolordesc'] = 'Цвет фона для ячеек со значениями оценок';
$string['percentagecolor'] = 'Цвет текста процентов';
$string['percentagecolordesc'] = 'Цвет текста для процентных значений';
$string['percentagebgcolor'] = 'Цвет фона процентов';
$string['percentagebgcolordesc'] = 'Цвет фона для ячеек с процентами';
// AI Settings
$string['aisettings'] = 'Настройки анализа ИИ';
$string['aisettingsdesc'] = 'Настройте интеграцию с внешними сервисами ИИ через n8n.';
$string['enableemailanalysis'] = 'Включить анализ по электронной почте';
$string['enableemailanalysisdesc'] = 'Разрешить пользователям запрашивать отчет с анализом на их электронную почту.';
$string['enableinstantanalysis'] = 'Включить мгновенный анализ';
$string['enableinstantanalysisdesc'] = 'Разрешить пользователям мгновенно просматривать отчет с анализом во всплывающем окне.';
$string['webhookurl'] = 'URL вебхука n8n';
$string['webhookurldesc'] = 'URL-адрес вебхука n8n, который будет обрабатывать данные оценок студентов.';
$string['token'] = 'Токен вебхука n8n';
$string['tokendesc'] = 'Безопасный токен для аутентификации в вебхуке n8n (передается в заголовках).';
$string['aiprompt'] = 'Промпт анализа ИИ';
$string['aipromptdesc'] = 'Запрос, отправляемый в ИИ вместе с данными студента. Измените его, чтобы настроить тон или акценты анализа.';
$string['aicooldown'] = 'Интервал между анализами (в минутах)';
$string['aicooldowndesc'] = 'Минимальное время в минутах между запросами анализа для снижения нагрузки. Установите 0 для отключения.';
// Reset Information
$string['resetcolorsheading'] = 'Сброс цветов';
$string['resetcolorsdesc'] = 'Чтобы сбросить все цвета к значениям по умолчанию, очистите каждое поле цвета и сохраните настройки. Плагин автоматически применит цветовую схему по умолчанию.';

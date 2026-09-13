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
 * Spanish language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Panel Inteligente';
$string['smartdashboard:view'] = 'Ver el Panel Inteligente';
$string['mycourses'] = 'Mis Cursos';
$string['nocourses'] = 'Aún no estás impartiendo ningún curso.';
$string['gotocourse'] = 'Ir al Curso';
$string['students'] = 'estudiantes';
$string['enrollments'] = 'Inscripciones';
$string['activities'] = 'Actividades';
$string['needsgrading'] = 'Entrega(s) por calificar';
$string['section_overview'] = 'Visión General';
$string['section_grading'] = 'Calificaciones';
$string['section_progress'] = 'Progreso del Estudiante';
$string['section_analytics'] = 'Analítica';
$string['section_settings'] = 'Configuración';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Iconos del Panel del Estudiante';
$string['student_icons_desc'] = 'Configure los iconos que se muestran en el banner de bienvenida del panel del estudiante.';
$string['icon_heading'] = 'Icono {$a}';
$string['icon_name'] = 'Nombre del Icono';
$string['icon_class'] = 'Clase de Icono (FontAwesome)';
$string['icon_class_desc'] = 'p. ej. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'URL del enlace';
$string['welcomebackstudent'] = '¡Bienvenido de nuevo, {$a}!';
$string['privacy:metadata'] = 'El plugin Smart Dashboard no almacena ningún dato personal.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Reemplazo del Panel';
$string['redirect_desc'] = 'Configura si el Panel Inteligente reemplaza el panel predeterminado de Moodle para roles específicos.';
$string['enabledirect'] = 'Habilitar Reemplazo del Panel';
$string['enabledirect_desc'] = 'Si está habilitado, los usuarios con los roles seleccionados que visiten el panel predeterminado serán redirigidos aquí.';
$string['redirectroles'] = 'Roles a Redirigir';
$string['redirectroles_desc'] = 'Selecciona los roles que deben ser redirigidos al Panel Inteligente. Los usuarios con CUALQUIERA de estos roles en CUALQUIER contexto se verán afectados.';
$string['redirectadmins'] = 'Redirigir a Administradores del Sitio';
$string['redirectadmins_desc'] = '¿Deberían redirigirse también los Administradores del Sitio?';

// Appearance Settings.
$string['appearance_heading'] = 'Apariencia';
$string['appearance_desc'] = 'Personaliza la apariencia visual del Panel Inteligente.';
$string['thememode'] = 'Modo de Color';
$string['thememode_desc'] = 'Elige el modo de color para el panel. Usa "Claro" si tu tema de Moodle tiene un fondo claro, o "Oscuro" para sitios con tema oscuro.';
$string['thememode_dark'] = 'Modo Oscuro';
$string['thememode_light'] = 'Modo Claro';
$string['todays_agenda'] = 'Agenda de Hoy';
$string['payment_calc_mode'] = 'Modo de Cálculo de Pagos';
$string['payment_calc_mode_desc'] = 'Elige cómo la analítica de pagos calcula los ingresos y el recuento de estudiantes.';
$string['save_settings'] = 'Guardar Configuración';
$string['latest_announcements'] = 'Últimos Anuncios';
$string['dont_show_again'] = 'No volver a mostrar esto';
$string['close'] = 'Cerrar';
$string['magic_reports_title'] = 'Informes Mágicos (Análisis con IA)';
$string['magic_reports_desc'] = 'Haz preguntas sobre tus datos en lenguaje natural y la IA generará el informe por ti.';
$string['saved_reports'] = 'Informes Guardados';
$string['loading'] = 'Cargando...';
$string['ask_a_question'] = 'Haz una pregunta';
$string['generate'] = 'Generar';
$string['result'] = 'Resultado';
$string['save_report'] = 'Guardar Informe';
$string['assignments_needing_grading'] = 'Tareas por Calificar';
$string['student_welcome_sub'] = 'Aquí está tu progreso y tus recursos.';
$string['welcome_back'] = '¡Bienvenido de nuevo!';
$string['teacher_welcome_sub'] = 'Aquí están los cursos que estás impartiendo. Da seguimiento al progreso de los estudiantes, calificaciones y estadísticas de participación.';
$string['parent_welcome_sub'] = 'Aquí puedes monitorear el progreso y las actividades de tus tutorados.';
$string['parent_mentees_title'] = 'Tus Tutorados';
$string['parent_overall_performance'] = 'Rendimiento General';
$string['parent_upcoming_deadlines'] = 'Próximas Fechas Límite';
$string['parent_recent_results'] = 'Resultados Recientes';
$string['parent_no_data'] = 'No hay datos disponibles';
$string['parent_view_calendar'] = 'Ver Calendario';
$string['parent_average_grade'] = 'Calificación Promedio';
$string['saving'] = 'Guardando...';
$string['filter_by_cat'] = 'Filtrar por Categoría';
$string['select_category'] = 'Selecciona una categoría...';
$string['show_courses'] = 'Mostrar Cursos';
$string['total_enrollments'] = 'Total de Inscripciones';
$string['direct_sum'] = 'Suma Directa';
$string['unique_students'] = 'Estudiantes Únicos';
$string['subcategories'] = 'Subcategorías';
$string['courses'] = 'Cursos';
$string['select_category_to_view'] = 'Por favor selecciona una categoría y haz clic en "Mostrar Cursos" para ver los datos.';
$string['select_category_to_filter'] = 'Selecciona una categoría específica para filtrar los resultados.';
$string['no_courses_found'] = 'No se encontraron cursos que coincidan con tu selección.';
$string['dashboard'] = 'Panel';
$string['overview'] = 'Visión General';
$string['risk'] = 'Detalles de Riesgo';
$string['detailed'] = 'Detallado';
$string['grades_overview'] = 'Resumen de Calificaciones';
$string['payments'] = 'Pagos';
$string['magic_reports'] = 'Informes Mágicos';
$string['payment_analytics'] = 'Analítica de Pagos';
$string['time_range'] = 'Rango de Tiempo';
$string['all_time'] = 'Todo el Tiempo';
$string['today'] = 'Hoy';
$string['past_7_days'] = 'Últimos 7 Días';
$string['past_30_days'] = 'Últimos 30 Días';
$string['past_year'] = 'Último Año';
$string['custom_range'] = 'Rango Personalizado';
$string['from'] = 'Desde';
$string['to'] = 'Hasta';
$string['category'] = 'Categoría';
$string['system_analytics'] = 'Analítica del Sistema';
$string['student_grades_will_appear'] = 'Las calificaciones de los estudiantes aparecerán aquí.';
$string['no_pending_tasks'] = 'No tienes tareas pendientes ni planes de estudio adaptativos para hoy.';
$string['caught_up'] = '¡Estás al día!';
$string['due_today'] = 'Vence Hoy';
$string['go_to_course'] = 'Ir al Curso';
$string['role_student'] = 'Estudiante';
$string['role_teacher'] = 'Profesor';
$string['role_parent'] = 'Padre/Tutor';
$string['parent_terminology'] = 'Terminología de Padres/Tutores';
$string['parent_terminology_desc'] = 'Selecciona la palabra utilizada para describir el rol de Padre/Mentor en el panel.';
$string['term_parent'] = 'Padre/Madre';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Socio';
$string['term_supervisor'] = 'Supervisor Académico';
$string['term_guardian'] = 'Tutor Legal';
$string['term_sponsor'] = 'Patrocinador';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Informes personalizados generados por IA guardados y creados por el usuario.';
$string['privacy:metadata:reports:userid'] = 'El usuario que creó el informe.';
$string['privacy:metadata:reports:title'] = 'El nombre del informe guardado.';
$string['privacy:metadata:reports:description'] = 'Descripción opcional o la instrucción original de IA.';
$string['privacy:metadata:reports:sql_query'] = 'La consulta SQL generada para el informe.';
$string['privacy:metadata:reports:timecreated'] = 'La fecha y hora en que se creó el informe.';
$string['privacy:metadata:reports:timemodified'] = 'La fecha y hora en que se modificó el informe por última vez.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Almacena los IDs de los anuncios del panel que el usuario ha descartado.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Instantáneas de puntuación de estudiantes en riesgo calculadas diariamente por el motor de riesgo.';
$string['privacy:metadata:risk:userid'] = 'El estudiante cuyo riesgo fue evaluado.';
$string['privacy:metadata:risk:courseid'] = 'El contexto del curso para la evaluación de riesgo.';
$string['privacy:metadata:risk:riskscore'] = 'La puntuación de riesgo calculada (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'La clasificación de riesgo (bajo, medio o alto).';
$string['privacy:metadata:risk:timecreated'] = 'La fecha y hora en que se calculó la instantánea de riesgo.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Los datos de los estudiantes en riesgo pueden enviarse a un webhook de flujo de trabajo n8n externo configurado por el administrador.';
$string['privacy:metadata:n8n:userid'] = 'El ID de usuario del estudiante en riesgo.';
$string['privacy:metadata:n8n:courseid'] = 'El ID del curso relacionado con la alerta de riesgo.';
$string['privacy:metadata:n8n:riskscore'] = 'La puntuación de riesgo enviada al webhook externo.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Historial de análisis y comentarios de IA para las calificaciones de los estudiantes.';
$string['privacy:metadata:ai_grades:userid'] = 'El estudiante cuyas calificaciones fueron analizadas.';
$string['privacy:metadata:ai_grades:report_html'] = 'El HTML de recomendaciones y retroalimentación generado por IA.';
$string['privacy:metadata:ai_grades:timecreated'] = 'La marca de tiempo de cuándo se generó el análisis.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Calcular puntuaciones de estudiantes en riesgo';
$string['risk_heading'] = 'Alertas de Estudiantes en Riesgo';
$string['risk_heading_desc'] = 'Configura el sistema de alerta temprana para estudiantes en riesgo. El motor de riesgo se ejecuta diariamente y evalúa a cada estudiante según los criterios ponderados que se indican a continuación. Se notifica automáticamente a los profesores cuando un estudiante pasa a ser de alto riesgo.';
$string['n8n_webhook_url'] = 'URL del Webhook de n8n';
$string['n8n_webhook_url_desc'] = 'La URL del webhook de flujo de trabajo de n8n para enviar datos de estudiantes en riesgo.';
$string['n8n_webhook_token'] = 'Token del Webhook de n8n';
$string['n8n_webhook_token_desc'] = 'Token Bearer opcional para autenticarse con tu webhook de n8n.';
$string['risk_max_inactive_days'] = 'Días máximos de inactividad';
$string['risk_max_inactive_days_desc'] = 'Número de días de inactividad antes de que la puntuación de riesgo de inicio de sesión alcance el 100%. Por defecto: 14 días.';
$string['risk_weight_login'] = 'Ponderación: Recencia de inicio de sesión';
$string['risk_weight_completion'] = 'Ponderación: Finalización del curso';
$string['risk_weight_grade'] = 'Ponderación: Calificación del curso';
$string['risk_weight_overdue'] = 'Ponderación: Actividades atrasadas';
$string['risk_weight_adaptiveplan'] = 'Ponderación: Cumplimiento del plan adaptativo';
$string['risk_weight_desc'] = 'Ponderación relativa para este criterio (los valores se normalizan al 100%). Por defecto: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Ponderación relativa para el cumplimiento del plan adaptativo. Se redistribuye automáticamente si mod_adaptiveplan no está instalado. Por defecto: 20.';
$string['risk_alert_subject'] = 'Alerta de Riesgo: {$a} necesita atención';
$string['risk_alert_body'] = 'El estudiante {$a->studentname} ha sido marcado como en riesgo en el curso "{$a->coursename}" con una puntuación de riesgo del {$a->riskscore}%.

Por favor, revisa el progreso de este estudiante y considera ponerte en contacto para ofrecerle apoyo.

Consulta el panel para más detalles.';
$string['risk_alert_body_html'] = '<p><strong>El estudiante {$a->studentname}</strong> ha sido marcado como <span style="color:#dc3545;font-weight:bold;">en riesgo</span> en el curso "<strong>{$a->coursename}</strong>" con una puntuación de riesgo de <strong>{$a->riskscore}%</strong>.</p><p>Por favor, revisa el progreso de este estudiante y considera ponerte en contacto para ofrecerle apoyo.</p>';
$string['risk_alert_small'] = '{$a->studentname} está en riesgo en {$a->coursename}';
$string['risk_level_low'] = 'En Buen Camino';
$string['risk_level_medium'] = 'En Observación';
$string['risk_level_high'] = 'En Riesgo';
$string['risk_score'] = 'Puntuación de Riesgo';
$string['risk_no_data'] = 'Los datos de riesgo aún no están disponibles. El sistema calcula las puntuaciones de riesgo diariamente.';
$string['messageprovider:risk_alert'] = 'Notificaciones de estudiantes en riesgo';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Regla de Riesgo del Panel Inteligente';
$string['subplugintype_smartdashboardrule_plural'] = 'Reglas de Riesgo del Panel Inteligente';

// Mobile App Support.
$string['mobile_no_data'] = 'No hay datos disponibles. Desliza hacia abajo para actualizar.';
$string['at_risk_students'] = 'Estudiantes en Riesgo';
$string['risk_high'] = 'Riesgo Alto';
$string['risk_medium'] = 'Riesgo Medio';
$string['risk_low'] = 'Riesgo Bajo';
$string['grading_pending'] = 'Calificación Pendiente';
$string['total_students'] = 'Total de Estudiantes';
$string['total_courses'] = 'Total de Cursos';
$string['due_date'] = 'Vencimiento';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Acceso denegado';
$string['error_webhook_not_configured'] = 'La URL del webhook de n8n no está configurada.';
$string['error_invalid_json'] = 'Carga útil JSON no válida.';
$string['error_invalid_action'] = 'Acción no válida';
$string['error_n8n_error'] = 'Error de n8n: {$a}';
$string['success_data_sent'] = '¡Datos enviados con éxito a n8n!';
$string['student_count_display'] = 'Visualización del recuento de estudiantes';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Suma de estudiantes en todos los cursos (incluye duplicados)';
$string['unique_students_tooltip'] = 'Recuento de estudiantes únicos (sin duplicados)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'ej. Muéstrame los 5 cursos principales con las tasas de finalización más bajas...';
$string['magic_ai_description'] = 'Uso de IA para traducir lenguaje natural a consultas SQL.';
$string['show_generated_sql'] = 'Mostrar SQL generado';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Distribución de Ingresos';
$string['chart_students_revenue_category'] = 'Estudiantes e Ingresos por Categoría';

// Student Overview strings.
$string['student_my_courses'] = 'Mis Cursos';
$string['student_upcoming_deadlines'] = 'Próximas Fechas Límite';
$string['student_my_grades'] = 'Mis Calificaciones';
$string['student_overall_average'] = 'Promedio General';
$string['student_complete'] = 'completado';
$string['student_no_deadlines'] = 'No hay fechas límite próximas — ¡estás al día!';
$string['student_no_grades'] = 'Aún no hay calificaciones disponibles.';
$string['student_no_courses'] = 'No estás inscrito en ningún curso.';
$string['student_no_progress'] = 'No rastreado';
$string['student_due_soon'] = 'En {$a} días';
$string['student_view_course'] = 'Ver Curso';
$string['student_course_progress'] = 'Progreso del Curso';
$string['student_active_courses'] = 'Cursos Activos';
$string['student_next_deadline'] = 'Próxima Fecha Límite';
$string['student_recent_feedback'] = 'Comentarios Recientes';
$string['student_no_feedback'] = 'No hay comentarios recientes disponibles.';
$string['student_none'] = 'Ninguno';
$string['student_my_badges'] = 'Mis Últimas Insignias';
$string['student_no_badges'] = 'Aún no has ganado ninguna insignia. ¡Sigue con el buen trabajo!';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Ver informe de calificaciones de cursos de estudiantes';
$string['studentgrades:viewall'] = 'Ver informes de calificaciones de cursos de todos los usuarios';
$string['selectuser'] = 'Seleccionar usuario';
$string['exporthtml'] = 'Exportar como HTML';
$string['includedescription'] = 'Incluir Descripción';
$string['nousers'] = 'No se encontraron usuarios';
$string['student_nocourses'] = 'El estudiante no está inscrito en ningún curso';
$string['user'] = 'Estudiante';
$string['reportdate'] = 'Fecha del informe';
$string['coursename'] = 'Curso';
$string['gradeitem'] = 'Ítem de calificación';
$string['grade'] = 'Calificación';
$string['range'] = 'Rango';
$string['percentage'] = 'Porcentaje';
$string['total'] = 'Total';
$string['coursetotal'] = 'Total del Curso';
$string['overallsummary'] = 'Resumen General';
$string['totalcourses'] = 'Total de Cursos';
$string['viewmygrades'] = 'Ver Mis Calificaciones';
$string['exportmygrades'] = 'Exportar Mis Calificaciones';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'No hay contenido para exportar.';
$string['filtergrades'] = 'Filtrar Calificaciones';
$string['allcourses'] = 'Todos los Cursos';
$string['categorysearch'] = 'Categoría / Búsqueda';
$string['typetofilter'] = 'Escribe para filtrar...';
$string['analyzeandemail'] = 'Analizar y Enviarme por Correo';
$string['dailylimitreached'] = 'Límite diario alcanzado. Por favor, espera {$a} minuto(s) antes de generar un nuevo análisis.';
$string['viewanalysisnow'] = 'Ver Análisis Ahora';
$string['generatinganalysis'] = 'Generando Análisis...';
$string['talkingtocoreai'] = 'Comunicando con Moodle AI...';
$string['aianalysisresult'] = 'Resultado del Análisis con IA';
$string['downloadpdf'] = 'Descargar PDF';
$string['communicationerror'] = 'Error de Comunicación';
$string['analysishistory'] = 'Historial de Análisis';
$string['defaultprompt'] = 'Eres un asistente educativo de IA. Analiza los siguientes datos de rendimiento del estudiante. Los datos incluyen descripciones de cursos, actividades, calificaciones máximas, calificaciones del estudiante y descripciones de actividades. Proporciona un análisis constructivo de las fortalezas del estudiante y las áreas de mejora basadas en estos datos.';
$string['privacy:metadata:userid'] = 'El ID del usuario.';
$string['privacy:metadata:grades'] = 'Los datos de calificaciones del usuario.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Los datos de calificaciones se envían al webhook de n8n para su análisis con IA.';
$string['permissiondenied'] = 'Permiso denegado. Has iniciado sesión como Usuario ID: {$a->currentuserid} pero solicitaste datos para el Usuario ID: {$a->userid}. Se requiere el permiso adecuado o una cuenta de padre/tutor vinculada.';
$string['airesponsesuccessnocontent'] = 'Respuesta de IA exitosa pero sin contenido. Datos sin procesar: {$a}';
$string['aiprovidererror'] = 'Error del Proveedor de IA: {$a}';
$string['errorinitializingai'] = 'Error al inicializar la acción de IA: {$a}';
$string['aimockresponse'] = 'Respuesta del Sistema de IA: ¡Hola! Recibí tu mensaje. (No se detectaron clases de Moodle Core AI, mostrando respuesta simulada)';
$string['generalerror'] = 'Error: {$a}';
$string['invalidaction'] = 'Acción no válida';
$string['success'] = 'Éxito';
$string['unknownerror'] = 'Ocurrió un error desconocido';
$string['aiconfigmissing'] = 'Configuración de IA (URL del Webhook) no encontrada en los ajustes del Informe de Calificaciones del Estudiante.';
$string['analysisrequestsent'] = '¡Solicitud de análisis enviada con éxito!';
$string['failedtosenddata'] = 'Error al enviar datos. Código HTTP: {$a->code} Respuesta: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Configuración de Colores';
$string['colorsettingsdesc'] = 'Personaliza los colores utilizados en los informes de calificaciones exportados a HTML. Estos ajustes te permiten coincidir con la imagen institucional y mejorar la accesibilidad visual.';
// Header Colors
$string['headerprimarycolor'] = 'Color Primario del Encabezado';
$string['headerprimarycolordesc'] = 'Color primario para el fondo degradado del encabezado del informe';
$string['headersecondarycolor'] = 'Color Secundario del Encabezado';
$string['headersecondarycolordesc'] = 'Color secundario para el fondo degradado del encabezado del informe';
$string['headertextcolor'] = 'Color del Texto del Encabezado';
$string['headertextcolordesc'] = 'Color del texto para el encabezado del informe';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Color de Calificación Excelente';
$string['gradeexcellentcolordesc'] = 'Color para los indicadores de rendimiento de calificación excelente';
$string['gradegoodcolor'] = 'Color de Buena Calificación';
$string['gradegoodcolordesc'] = 'Color para los indicadores de rendimiento de buena calificación';
$string['gradeaveragecolor'] = 'Color de Calificación Regular';
$string['gradeaveragecolordesc'] = 'Color para los indicadores de rendimiento de calificación promedio';
$string['gradepoorcolor'] = 'Color de Calificación Deficiente';
$string['gradepoorcolordesc'] = 'Color para los indicadores de rendimiento de calificación deficiente';
// Table Colors
$string['tablebordercolor'] = 'Color del Borde de la Tabla';
$string['tablebordercolordesc'] = 'Color para los bordes de la tabla y separadores de celdas';
$string['rowalternatecolor'] = 'Color Alterno de Filas';
$string['rowalternatecolordesc'] = 'Color de fondo para las filas alternas de la tabla';
$string['rowhovercolor'] = 'Color de Fila al Pasar el Cursor';
$string['rowhovercolordesc'] = 'Color de fondo al pasar el cursor sobre las filas de la tabla';
// Category Colors
$string['categoryprimarycolor'] = 'Color Primario de Categoría';
$string['categoryprimarycolordesc'] = 'Color primario para el fondo degradado de la fila de categoría';
$string['categorysecondarycolor'] = 'Color Secundario de Categoría';
$string['categorysecondarycolordesc'] = 'Color secundario para el fondo degradado de la fila de categoría';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Color Primario del Total de Categoría';
$string['categorytotalprimarycolordesc'] = 'Color primario para el fondo degradado de la fila de total de categoría';
$string['categorytotalsecondarycolor'] = 'Color Secundario del Total de Categoría';
$string['categorytotalsecondarycolordesc'] = 'Color secundario para el fondo degradado de la fila de total de categoría';
$string['coursetotalprimarycolor'] = 'Color Primario del Total del Curso';
$string['coursetotalprimarycolordesc'] = 'Color primario para el fondo degradado de la fila de total del curso';
$string['coursetotalsecondarycolor'] = 'Color Secundario del Total del Curso';
$string['coursetotalsecondarycolordesc'] = 'Color secundario para el fondo degradado de la fila de total del curso';
// Grade Value Colors
$string['gradevaluecolor'] = 'Color del Texto del Valor de Calificación';
$string['gradevaluecolordesc'] = 'Color del texto para los valores de calificación';
$string['gradevaluebgcolor'] = 'Color de Fondo del Valor de Calificación';
$string['gradevaluebgcolordesc'] = 'Color de fondo para las celdas de valores de calificación';
$string['percentagecolor'] = 'Color del Texto del Porcentaje';
$string['percentagecolordesc'] = 'Color del texto para los valores de porcentaje';
$string['percentagebgcolor'] = 'Color de Fondo del Porcentaje';
$string['percentagebgcolordesc'] = 'Color de fondo para las celdas de porcentaje';
// AI Settings
$string['aisettings'] = 'Configuración del Análisis con IA';
$string['aisettingsdesc'] = 'Configura la integración con servicios externos de IA a través de n8n.';
$string['enableemailanalysis'] = 'Habilitar Análisis por Correo Electrónico';
$string['enableemailanalysisdesc'] = 'Permite a los usuarios solicitar un informe de análisis enviado a su correo electrónico.';
$string['enableinstantanalysis'] = 'Habilitar Análisis Instantáneo';
$string['enableinstantanalysisdesc'] = 'Permite a los usuarios ver un informe de análisis al instante en una ventana modal.';
$string['webhookurl'] = 'URL del Webhook de n8n';
$string['webhookurldesc'] = 'La URL del webhook de n8n que procesará los datos de calificaciones de los estudiantes.';
$string['token'] = 'Token del Webhook de n8n';
$string['tokendesc'] = 'Token seguro para autenticación con el webhook de n8n (enviado en los encabezados).';
$string['aiprompt'] = 'Instrucción de Análisis de IA';
$string['aipromptdesc'] = 'La instrucción enviada a la IA junto con los datos del estudiante. Personalízala para cambiar el tono o el enfoque del análisis.';
$string['aicooldown'] = 'Tiempo de Espera entre Análisis (Minutos)';
$string['aicooldowndesc'] = 'Tiempo mínimo en minutos entre solicitudes de análisis para el ahorro crítico de datos. Establece en 0 para desactivar.';
// Reset Information
$string['resetcolorsheading'] = 'Restablecer Colores';
$string['resetcolorsdesc'] = 'Para restablecer todos los colores a sus valores predeterminados, borra cada campo de color y guarda la configuración. El plugin utilizará automáticamente la combinación de colores predeterminada.';

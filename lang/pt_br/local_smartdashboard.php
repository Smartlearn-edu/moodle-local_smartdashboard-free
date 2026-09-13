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
 * Brazilian Portuguese language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Painel Inteligente';
$string['smartdashboard:view'] = 'Visualizar o Painel Inteligente';
$string['mycourses'] = 'Meus Cursos';
$string['nocourses'] = 'Você ainda não está ministrando nenhum curso.';
$string['gotocourse'] = 'Ir para o Curso';
$string['students'] = 'estudantes';
$string['enrollments'] = 'Inscrições';
$string['activities'] = 'Atividades';
$string['needsgrading'] = 'Envio(s) para avaliar';
$string['section_overview'] = 'Visão Geral';
$string['section_grading'] = 'Avaliação';
$string['section_progress'] = 'Progresso do Aluno';
$string['section_analytics'] = 'Análise';
$string['section_settings'] = 'Configurações';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Ícones do Painel do Estudante';
$string['student_icons_desc'] = 'Configure os ícones exibidos no banner de boas-vindas do painel do estudante.';
$string['icon_heading'] = 'Ícone {$a}';
$string['icon_name'] = 'Nome do Ícone';
$string['icon_class'] = 'Classe do Ícone (FontAwesome)';
$string['icon_class_desc'] = 'ex.: "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'URL do Link';
$string['welcomebackstudent'] = 'Bem-vindo(a) de volta, {$a}!';
$string['privacy:metadata'] = 'O plugin Smart Dashboard não armazena nenhum dado pessoal.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Substituição do Painel';
$string['redirect_desc'] = 'Configure se o Painel Inteligente substitui o painel padrão do Moodle para funções específicas.';
$string['enabledirect'] = 'Ativar Substituição do Painel';
$string['enabledirect_desc'] = 'Se ativado, os usuários com as funções selecionadas que visitarem o painel padrão serão redirecionados para cá.';
$string['redirectroles'] = 'Funções a Redirecionar';
$string['redirectroles_desc'] = 'Selecione as funções que devem ser redirecionadas para o Painel Inteligente. Usuários com QUALQUER uma dessas funções em QUALQUER contexto serão afetados.';
$string['redirectadmins'] = 'Redirecionar Administradores do Site';
$string['redirectadmins_desc'] = 'Os Administradores do Site também devem ser redirecionados?';

// Appearance Settings.
$string['appearance_heading'] = 'Aparência';
$string['appearance_desc'] = 'Personalize a aparência visual do Painel Inteligente.';
$string['thememode'] = 'Modo de Cor';
$string['thememode_desc'] = 'Escolha o modo de cor para o painel. Use "Claro" se o tema do seu Moodle tiver fundo claro ou "Escuro" para sites com tema escuro.';
$string['thememode_dark'] = 'Modo Escuro';
$string['thememode_light'] = 'Modo Claro';
$string['todays_agenda'] = 'Agenda de Hoje';
$string['payment_calc_mode'] = 'Modo de Cálculo de Pagamento';
$string['payment_calc_mode_desc'] = 'Escolha como a análise de pagamento calcula a receita e a contagem de estudantes.';
$string['save_settings'] = 'Salvar Configurações';
$string['latest_announcements'] = 'Últimos Anúncios';
$string['dont_show_again'] = 'Não mostrar isso novamente';
$string['close'] = 'Fechar';
$string['magic_reports_title'] = 'Relatórios Mágicos (Análise de IA)';
$string['magic_reports_desc'] = 'Faça perguntas sobre seus dados em linguagem natural e a IA gerará o relatório para você.';
$string['saved_reports'] = 'Relatórios Salvos';
$string['loading'] = 'Carregando...';
$string['ask_a_question'] = 'Faça uma pergunta';
$string['generate'] = 'Gerar';
$string['result'] = 'Resultado';
$string['save_report'] = 'Salvar Relatório';
$string['assignments_needing_grading'] = 'Tarefas Necessitando de Avaliação';
$string['student_welcome_sub'] = 'Aqui está seu progresso e recursos.';
$string['welcome_back'] = 'Bem-vindo(a) de volta!';
$string['teacher_welcome_sub'] = 'Aqui estão os cursos que você está ministrando. Acompanhe o progresso dos alunos, avaliações e percepções de engajamento.';
$string['parent_welcome_sub'] = 'Aqui você pode acompanhar o progresso e as atividades de seus tutorados.';
$string['parent_mentees_title'] = 'Seus Tutorados';
$string['parent_overall_performance'] = 'Desempenho Geral';
$string['parent_upcoming_deadlines'] = 'Próximos Prazos';
$string['parent_recent_results'] = 'Resultados Recentes';
$string['parent_no_data'] = 'Nenhum dado disponível';
$string['parent_view_calendar'] = 'Ver Calendário';
$string['parent_average_grade'] = 'Nota Média';
$string['saving'] = 'Salvando...';
$string['filter_by_cat'] = 'Filtrar por Categoria';
$string['select_category'] = 'Selecione uma categoria...';
$string['show_courses'] = 'Mostrar Cursos';
$string['total_enrollments'] = 'Total de Inscrições';
$string['direct_sum'] = 'Soma Direta';
$string['unique_students'] = 'Estudantes Únicos';
$string['subcategories'] = 'Subcategorias';
$string['courses'] = 'Cursos';
$string['select_category_to_view'] = 'Por favor, selecione uma categoria e clique em "Mostrar Cursos" para visualizar os dados.';
$string['select_category_to_filter'] = 'Selecione uma categoria específica para filtrar os resultados.';
$string['no_courses_found'] = 'Nenhum curso encontrado correspondente à sua seleção.';
$string['dashboard'] = 'Painel';
$string['overview'] = 'Visão Geral';
$string['risk'] = 'Detalhes de Risco';
$string['detailed'] = 'Detalhado';
$string['grades_overview'] = 'Visão Geral de Notas';
$string['payments'] = 'Pagamentos';
$string['magic_reports'] = 'Relatórios Mágicos';
$string['payment_analytics'] = 'Análise de Pagamentos';
$string['time_range'] = 'Intervalo de Tempo';
$string['all_time'] = 'Todo o Período';
$string['today'] = 'Hoje';
$string['past_7_days'] = 'Últimos 7 Dias';
$string['past_30_days'] = 'Últimos 30 Dias';
$string['past_year'] = 'Último Ano';
$string['custom_range'] = 'Intervalo Personalizado';
$string['from'] = 'De';
$string['to'] = 'Até';
$string['category'] = 'Categoria';
$string['system_analytics'] = 'Análise do Sistema';
$string['student_grades_will_appear'] = 'As notas dos alunos aparecerão aqui.';
$string['no_pending_tasks'] = 'Você não tem tarefas pendentes ou planos de estudo adaptativos para hoje.';
$string['caught_up'] = 'Você está em dia!';
$string['due_today'] = 'Entrega Hoje';
$string['go_to_course'] = 'Ir para o Curso';
$string['role_student'] = 'Estudante';
$string['role_teacher'] = 'Professor';
$string['role_parent'] = 'Responsável';
$string['parent_terminology'] = 'Terminologia de Responsável';
$string['parent_terminology_desc'] = 'Selecione a palavra usada para descrever a função de Responsável/Mentor no painel.';
$string['term_parent'] = 'Responsável';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Parceiro';
$string['term_supervisor'] = 'Supervisor Acadêmico';
$string['term_guardian'] = 'Tutor Legal';
$string['term_sponsor'] = 'Patrocinador';
// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Relatórios personalizados gerados por IA salvos criados pelo usuário.';
$string['privacy:metadata:reports:userid'] = 'O usuário que criou o relatório.';
$string['privacy:metadata:reports:title'] = 'O nome do relatório salvo.';
$string['privacy:metadata:reports:description'] = 'Descrição opcional ou o prompt original da IA.';
$string['privacy:metadata:reports:sql_query'] = 'A consulta SQL gerada para o relatório.';
$string['privacy:metadata:reports:timecreated'] = 'A data e hora em que o relatório foi criado.';
$string['privacy:metadata:reports:timemodified'] = 'A data e hora em que o relatório foi modificado pela última vez.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Armazena os IDs dos anúncios do painel que o usuário dispensou.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Instantâneos de pontuação de alunos em risco calculados diariamente pelo motor de risco.';
$string['privacy:metadata:risk:userid'] = 'O estudante cujo risco foi avaliado.';
$string['privacy:metadata:risk:courseid'] = 'O contexto do curso para a avaliação de risco.';
$string['privacy:metadata:risk:riskscore'] = 'A pontuação de risco calculada (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'A classificação de risco (baixo, médio ou alto).';
$string['privacy:metadata:risk:timecreated'] = 'A data e hora em que o instantâneo de risco foi calculado.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Os dados de estudantes em risco podem ser enviados para um webhook externo de fluxo de trabalho n8n configurado pelo administrador.';
$string['privacy:metadata:n8n:userid'] = 'O ID de usuário do estudante em risco.';
$string['privacy:metadata:n8n:courseid'] = 'O ID do curso relacionado ao alerta de risco.';
$string['privacy:metadata:n8n:riskscore'] = 'A pontuação de risco enviada para o webhook externo.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Histórico de análises de IA e feedback para as notas do estudante.';
$string['privacy:metadata:ai_grades:userid'] = 'O estudante cujas notas foram analisadas.';
$string['privacy:metadata:ai_grades:report_html'] = 'O HTML de feedback e recomendações gerado pela IA.';
$string['privacy:metadata:ai_grades:timecreated'] = 'A data e hora em que a análise foi gerada.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Calcular pontuações de estudantes em risco';
$string['risk_heading'] = 'Alertas de Estudantes em Risco';
$string['risk_heading_desc'] = 'Configure o sistema de alerta precoce de estudantes em risco. O motor de risco roda diariamente e pontua cada estudante com base nos critérios ponderados abaixo. Os professores são notificados automaticamente quando um estudante atinge alto risco.';
$string['n8n_webhook_url'] = 'URL do Webhook n8n';
$string['n8n_webhook_url_desc'] = 'A URL para o webhook do seu fluxo de trabalho n8n para envio de dados de estudantes em risco.';
$string['n8n_webhook_token'] = 'Token do Webhook n8n';
$string['n8n_webhook_token_desc'] = 'Token Bearer opcional para autenticação com seu webhook n8n.';
$string['risk_max_inactive_days'] = 'Máximo de dias inativos';
$string['risk_max_inactive_days_desc'] = 'Número de dias de inatividade antes que a pontuação de risco de login atinja 100%. Padrão: 14 dias.';
$string['risk_weight_login'] = 'Peso: Recência de login';
$string['risk_weight_completion'] = 'Peso: Conclusão do curso';
$string['risk_weight_grade'] = 'Peso: Nota do curso';
$string['risk_weight_overdue'] = 'Peso: Atividades em atraso';
$string['risk_weight_adaptiveplan'] = 'Peso: Conformidade com plano adaptativo';
$string['risk_weight_desc'] = 'Peso relativo para este critério (os valores são normalizados para 100%). Padrão: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Peso relativo para conformidade com o plano adaptativo. Redistribuído automaticamente se mod_adaptiveplan não estiver instalado. Padrão: 20.';
$string['risk_alert_subject'] = 'Alerta de Risco: {$a} precisa de atenção';
$string['risk_alert_body'] = 'O estudante {$a->studentname} foi sinalizado como em risco no curso "{$a->coursename}" com uma pontuação de risco de {$a->riskscore}%.

Por favor, verifique o progresso deste estudante e considere entrar em contato para oferecer apoio.

Acesse o painel para mais detalhes.';
$string['risk_alert_body_html'] = '<p><strong>O estudante {$a->studentname}</strong> foi sinalizado como <span style="color:#dc3545;font-weight:bold;">em risco</span> no curso "<strong>{$a->coursename}</strong>" com uma pontuação de risco de <strong>{$a->riskscore}%</strong>.</p><p>Por favor, verifique o progresso deste estudante e considere entrar em contato para oferecer apoio.</p>';
$string['risk_alert_small'] = '{$a->studentname} está em risco em {$a->coursename}';
$string['risk_level_low'] = 'Em Dia';
$string['risk_level_medium'] = 'Em Observação';
$string['risk_level_high'] = 'Em Risco';
$string['risk_score'] = 'Pontuação de Risco';
$string['risk_no_data'] = 'Dados de risco ainda não disponíveis. O sistema calcula as pontuações de risco diariamente.';
$string['messageprovider:risk_alert'] = 'Notificações de estudantes em risco';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Regra de Risco do Painel Inteligente';
$string['subplugintype_smartdashboardrule_plural'] = 'Regras de Risco do Painel Inteligente';

// Mobile App Support.
$string['mobile_no_data'] = 'Nenhum dado disponível. Puxe para baixo para atualizar.';
$string['at_risk_students'] = 'Estudantes em Risco';
$string['risk_high'] = 'Alto Risco';
$string['risk_medium'] = 'Médio Risco';
$string['risk_low'] = 'Baixo Risco';
$string['grading_pending'] = 'Avaliação Pendente';
$string['total_students'] = 'Total de Estudantes';
$string['total_courses'] = 'Total de Cursos';
$string['due_date'] = 'Entrega';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Acesso negado';
$string['error_webhook_not_configured'] = 'A URL do Webhook n8n não está configurada.';
$string['error_invalid_json'] = 'Carga útil JSON inválida.';
$string['error_invalid_action'] = 'Ação inválida';
$string['error_n8n_error'] = 'Erro n8n: {$a}';
$string['success_data_sent'] = 'Dados enviados com sucesso para o n8n!';
$string['student_count_display'] = 'Exibição de contagem de estudantes';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Soma de estudantes em todos os cursos (inclui duplicatas)';
$string['unique_students_tooltip'] = 'Contagem de estudantes únicos (sem duplicatas)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'ex.: Mostre-me os 5 cursos com as menores taxas de conclusão...';
$string['magic_ai_description'] = 'Usando IA para traduzir linguagem natural em consultas SQL.';
$string['show_generated_sql'] = 'Mostrar SQL gerado';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Distribuição de Receita';
$string['chart_students_revenue_category'] = 'Estudantes e Receita por Categoria';

// Student Overview strings.
$string['student_my_courses'] = 'Meus Cursos';
$string['student_upcoming_deadlines'] = 'Próximos Prazos';
$string['student_my_grades'] = 'Minhas Notas';
$string['student_overall_average'] = 'Média Geral';
$string['student_complete'] = 'concluído';
$string['student_no_deadlines'] = 'Nenhum prazo próximo — você está em dia!';
$string['student_no_grades'] = 'Nenhuma nota disponível ainda.';
$string['student_no_courses'] = 'Você não está inscrito em nenhum curso.';
$string['student_no_progress'] = 'Não rastreado';
$string['student_due_soon'] = 'Em {$a} dias';
$string['student_view_course'] = 'Ver Curso';
$string['student_course_progress'] = 'Progresso do Curso';
$string['student_active_courses'] = 'Cursos Ativos';
$string['student_next_deadline'] = 'Próximo Prazo';
$string['student_recent_feedback'] = 'Feedback Recente';
$string['student_no_feedback'] = 'Nenhum feedback recente disponível.';
$string['student_none'] = 'Nenhum';
$string['student_my_badges'] = 'Meus Emblemas Mais Recentes';
$string['student_no_badges'] = 'Você ainda não conquistou nenhum emblema. Continue com o bom trabalho!';



// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Visualizar relatório de notas de curso do estudante';
$string['studentgrades:viewall'] = 'Visualizar relatórios de notas de curso de todos os usuários';
$string['selectuser'] = 'Selecionar usuário';
$string['exporthtml'] = 'Exportar como HTML';
$string['includedescription'] = 'Incluir Descrição';
$string['nousers'] = 'Nenhum usuário encontrado';
$string['student_nocourses'] = 'O estudante não está inscrito em nenhum curso';
$string['user'] = 'Estudante';
$string['reportdate'] = 'Data do relatório';
$string['coursename'] = 'Curso';
$string['gradeitem'] = 'Item de nota';
$string['grade'] = 'Nota';
$string['range'] = 'Faixa';
$string['percentage'] = 'Porcentagem';
$string['total'] = 'Total';
$string['coursetotal'] = 'Total do Curso';
$string['overallsummary'] = 'Resumo Geral';
$string['totalcourses'] = 'Total de Cursos';
$string['viewmygrades'] = 'Ver Minhas Notas';
$string['exportmygrades'] = 'Exportar Minhas Notas';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Nenhum conteúdo para exportar.';
$string['filtergrades'] = 'Filtrar Notas';
$string['allcourses'] = 'Todos os Cursos';
$string['categorysearch'] = 'Categoria / Pesquisa';
$string['typetofilter'] = 'Digite para filtrar...';
$string['analyzeandemail'] = 'Analisar e Me Enviar por E-mail';
$string['dailylimitreached'] = 'Limite diário atingido. Por favor, aguarde {$a} minuto(s) antes de gerar uma nova análise.';
$string['viewanalysisnow'] = 'Ver Análise Agora';
$string['generatinganalysis'] = 'Gerando Análise...';
$string['talkingtocoreai'] = 'Falando com a IA do Moodle...';
$string['aianalysisresult'] = 'Resultado da Análise de IA';
$string['downloadpdf'] = 'Baixar PDF';
$string['communicationerror'] = 'Erro de Comunicação';
$string['analysishistory'] = 'Histórico de Análises';
$string['defaultprompt'] = 'Você é um assistente educacional de IA. Analise os seguintes dados de desempenho do estudante. Os dados incluem descrições de cursos, atividades, notas máximas, notas dos estudantes e descrições de atividades. Forneça uma análise construtiva dos pontos fortes do estudante e áreas para melhoria com base nesses dados.';
$string['privacy:metadata:userid'] = 'O ID do usuário.';
$string['privacy:metadata:grades'] = 'Os dados de notas do usuário.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Os dados de notas são enviados para o webhook n8n para análise de IA.';
$string['permissiondenied'] = 'Permissão Negada. Você está conectado como ID de Usuário: {$a->currentuserid}, mas solicitou dados para o ID de Usuário: {$a->userid}. É necessária permissão apropriada ou conta vinculada de responsável.';
$string['airesponsesuccessnocontent'] = 'Resposta da IA com sucesso, mas sem conteúdo. Dados brutos: {$a}';
$string['aiprovidererror'] = 'Erro do Provedor de IA: {$a}';
$string['errorinitializingai'] = 'Erro ao inicializar ação de IA: {$a}';
$string['aimockresponse'] = 'Resposta do Sistema de IA: Olá! Recebi sua mensagem. (Classes do Moodle Core AI não detectadas, exibindo resposta simulada)';
$string['generalerror'] = 'Erro: {$a}';
$string['invalidaction'] = 'Ação inválida';
$string['success'] = 'Sucesso';
$string['unknownerror'] = 'Ocorreu um erro desconhecido';
$string['aiconfigmissing'] = 'Configuração de IA (URL do Webhook) não encontrada nas configurações do Relatório de Notas do Estudante.';
$string['analysisrequestsent'] = 'Solicitação de análise enviada com sucesso!';
$string['failedtosenddata'] = 'Falha ao enviar dados. Código HTTP: {$a->code} Resposta: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Configurações de Cor';
$string['colorsettingsdesc'] = 'Personalize as cores usadas nos relatórios de notas exportados em HTML. Estas configurações permitem corresponder à identidade visual da sua instituição e melhorar a acessibilidade visual.';
// Header Colors
$string['headerprimarycolor'] = 'Cor Primária do Cabeçalho';
$string['headerprimarycolordesc'] = 'Cor primária para o fundo gradiente do cabeçalho do relatório';
$string['headersecondarycolor'] = 'Cor Secundária do Cabeçalho';
$string['headersecondarycolordesc'] = 'Cor secundária para o fundo gradiente do cabeçalho do relatório';
$string['headertextcolor'] = 'Cor do Texto do Cabeçalho';
$string['headertextcolordesc'] = 'Cor do texto para o cabeçalho do relatório';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Cor de Nota Excelente';
$string['gradeexcellentcolordesc'] = 'Cor para indicadores de desempenho de nota excelente';
$string['gradegoodcolor'] = 'Cor de Nota Boa';
$string['gradegoodcolordesc'] = 'Cor para indicadores de desempenho de nota boa';
$string['gradeaveragecolor'] = 'Cor de Nota Regular';
$string['gradeaveragecolordesc'] = 'Cor para indicadores de desempenho de nota regular';
$string['gradepoorcolor'] = 'Cor de Nota Insuficiente';
$string['gradepoorcolordesc'] = 'Cor para indicadores de desempenho de nota insuficiente';
// Table Colors
$string['tablebordercolor'] = 'Cor da Borda da Tabela';
$string['tablebordercolordesc'] = 'Cor para bordas de tabelas e separadores de células';
$string['rowalternatecolor'] = 'Cor Alternada da Linha';
$string['rowalternatecolordesc'] = 'Cor de fundo para linhas alternadas da tabela';
$string['rowhovercolor'] = 'Cor de Destaque da Linha ao Passar o Mouse';
$string['rowhovercolordesc'] = 'Cor de fundo ao passar o cursor sobre as linhas da tabela';
// Category Colors
$string['categoryprimarycolor'] = 'Cor Primária da Categoria';
$string['categoryprimarycolordesc'] = 'Cor primária para o fundo gradiente da linha de categoria';
$string['categorysecondarycolor'] = 'Cor Secundária da Categoria';
$string['categorysecondarycolordesc'] = 'Cor secundária para o fundo gradiente da linha de categoria';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Cor Primária do Total da Categoria';
$string['categorytotalprimarycolordesc'] = 'Cor primária para o fundo gradiente da linha de total da categoria';
$string['categorytotalsecondarycolor'] = 'Cor Secundária do Total da Categoria';
$string['categorytotalsecondarycolordesc'] = 'Cor secundária para o fundo gradiente da linha de total da categoria';
$string['coursetotalprimarycolor'] = 'Cor Primária do Total do Curso';
$string['coursetotalprimarycolordesc'] = 'Cor primária para o fundo gradiente da linha de total do curso';
$string['coursetotalsecondarycolor'] = 'Cor Secundária do Total do Curso';
$string['coursetotalsecondarycolordesc'] = 'Cor secundária para o fundo gradiente da linha de total do curso';
// Grade Value Colors
$string['gradevaluecolor'] = 'Cor do Texto do Valor da Nota';
$string['gradevaluecolordesc'] = 'Cor do texto para valores de notas';
$string['gradevaluebgcolor'] = 'Cor de Fundo do Valor da Nota';
$string['gradevaluebgcolordesc'] = 'Cor de fundo para células de valor de nota';
$string['percentagecolor'] = 'Cor do Texto de Porcentagem';
$string['percentagecolordesc'] = 'Cor do texto para valores de porcentagem';
$string['percentagebgcolor'] = 'Cor de Fundo de Porcentagem';
$string['percentagebgcolordesc'] = 'Cor de fundo para células de porcentagem';
// AI Settings
$string['aisettings'] = 'Configurações de Análise de IA';
$string['aisettingsdesc'] = 'Configure a integração com serviços externos de IA via n8n.';
$string['enableemailanalysis'] = 'Ativar Análise por E-mail';
$string['enableemailanalysisdesc'] = 'Permite que os usuários solicitem um relatório de análise enviado para o e-mail deles.';
$string['enableinstantanalysis'] = 'Ativar Análise Instantânea';
$string['enableinstantanalysisdesc'] = 'Permite que os usuários visualizem um relatório de análise instantaneamente em uma janela modal.';
$string['webhookurl'] = 'URL do Webhook n8n';
$string['webhookurldesc'] = 'A URL do webhook n8n que processará os dados de notas do estudante.';
$string['token'] = 'Token do Webhook n8n';
$string['tokendesc'] = 'Token seguro para autenticação com o webhook n8n (enviado nos cabeçalhos).';
$string['aiprompt'] = 'Prompt de Análise de IA';
$string['aipromptdesc'] = 'O prompt enviado para a IA junto com os dados do estudante. Personalize isto para alterar o tom ou o foco da análise.';
$string['aicooldown'] = 'Tempo de Espera entre Análises (Minutos)';
$string['aicooldowndesc'] = 'Tempo mínimo em minutos entre solicitações de análise para economia crítica de dados. Defina como 0 para desativar.';
// Reset Information
$string['resetcolorsheading'] = 'Redefinir Cores';
$string['resetcolorsdesc'] = 'Para redefinir todas as cores para seus valores padrão, limpe cada campo de cor e salve as configurações. O plugin usará automaticamente o esquema de cores padrão.';

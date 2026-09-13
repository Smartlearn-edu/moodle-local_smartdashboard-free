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
 * French language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Tableau de Bord Intelligent';
$string['smartdashboard:view'] = 'Voir le Tableau de Bord Intelligent';
$string['mycourses'] = 'Mes Cours';
$string['nocourses'] = 'Vous n\'enseignez encore aucun cours.';
$string['gotocourse'] = 'Aller au Cours';
$string['students'] = 'étudiants';
$string['enrollments'] = 'Inscriptions';
$string['activities'] = 'Activités';
$string['needsgrading'] = 'Devoir(s) à noter';
$string['section_overview'] = 'Vue d\'ensemble';
$string['section_grading'] = 'Évaluation';
$string['section_progress'] = 'Progrès des Étudiants';
$string['section_analytics'] = 'Analytique';
$string['section_settings'] = 'Paramètres';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Icônes du Tableau de Bord Étudiant';
$string['student_icons_desc'] = 'Configurez les icônes affichées sur la bannière de bienvenue du tableau de bord de l\'étudiant.';
$string['icon_heading'] = 'Icône {$a}';
$string['icon_name'] = 'Nom de l\'icône';
$string['icon_class'] = 'Classe de l\'icône (FontAwesome)';
$string['icon_class_desc'] = 'par ex. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'URL du lien';
$string['welcomebackstudent'] = 'Bon retour, {$a} !';
$string['privacy:metadata'] = 'Le plugin Smart Dashboard ne stocke aucune donnée personnelle.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Remplacement du Tableau de Bord';
$string['redirect_desc'] = 'Configurez si le Tableau de Bord Intelligent remplace le tableau de bord par défaut de Moodle pour des rôles spécifiques.';
$string['enabledirect'] = 'Activer le Remplacement du Tableau de Bord';
$string['enabledirect_desc'] = 'Si activé, les utilisateurs ayant les rôles sélectionnés visitant le tableau de bord par défaut seront redirigés ici.';
$string['redirectroles'] = 'Rôles à Rediriger';
$string['redirectroles_desc'] = 'Sélectionnez les rôles qui doivent être redirigés vers le Tableau de Bord Intelligent. Les utilisateurs ayant N\'IMPORTE LEQUEL de ces rôles dans N\'IMPORTE QUEL contexte seront affectés.';
$string['redirectadmins'] = 'Rediriger les Administrateurs du Site';
$string['redirectadmins_desc'] = 'Les Administrateurs du Site doivent-ils également être redirigés ?';

// Appearance Settings.
$string['appearance_heading'] = 'Apparence';
$string['appearance_desc'] = 'Personnalisez l\'apparence visuelle du Tableau de Bord Intelligent.';
$string['thememode'] = 'Mode de Couleur';
$string['thememode_desc'] = 'Choisissez le mode de couleur pour le tableau de bord. Utilisez "Clair" si votre thème Moodle a un fond clair, ou "Sombre" pour les sites à thème sombre.';
$string['thememode_dark'] = 'Mode Sombre';
$string['thememode_light'] = 'Mode Clair';
$string['todays_agenda'] = 'Ordre du Jour d\'Aujourd\'hui';
$string['payment_calc_mode'] = 'Mode de Calcul des Paiements';
$string['payment_calc_mode_desc'] = 'Choisissez comment l\'analytique des paiements calcule les revenus et le nombre d\'étudiants.';
$string['save_settings'] = 'Enregistrer les Paramètres';
$string['latest_announcements'] = 'Dernières Annonces';
$string['dont_show_again'] = 'Ne plus afficher ceci';
$string['close'] = 'Fermer';
$string['magic_reports_title'] = 'Rapports Magiques (Analyse IA)';
$string['magic_reports_desc'] = 'Posez des questions sur vos données en langage naturel et l\'IA générera le rapport pour vous.';
$string['saved_reports'] = 'Rapports Enregistrés';
$string['loading'] = 'Chargement...';
$string['ask_a_question'] = 'Poser une question';
$string['generate'] = 'Générer';
$string['result'] = 'Résultat';
$string['save_report'] = 'Enregistrer le Rapport';
$string['assignments_needing_grading'] = 'Devoirs à Noter';
$string['student_welcome_sub'] = 'Voici vos progrès et vos ressources.';
$string['welcome_back'] = 'Bon retour !';
$string['teacher_welcome_sub'] = 'Voici les cours que vous enseignez. Suivez les progrès des étudiants, la notation et les indicateurs d\'engagement.';
$string['parent_welcome_sub'] = 'Ici, vous pouvez suivre les progrès et les activités de vos tutorés.';
$string['parent_mentees_title'] = 'Vos Tutorés';
$string['parent_overall_performance'] = 'Performance Globale';
$string['parent_upcoming_deadlines'] = 'Échéances à Venir';
$string['parent_recent_results'] = 'Résultats Récents';
$string['parent_no_data'] = 'Aucune donnée disponible';
$string['parent_view_calendar'] = 'Afficher le Calendrier';
$string['parent_average_grade'] = 'Note Moyenne';
$string['saving'] = 'Enregistrement en cours...';
$string['filter_by_cat'] = 'Filtrer par Catégorie';
$string['select_category'] = 'Sélectionnez une catégorie...';
$string['show_courses'] = 'Afficher les Cours';
$string['total_enrollments'] = 'Total des Inscriptions';
$string['direct_sum'] = 'Somme Directe';
$string['unique_students'] = 'Étudiants Uniques';
$string['subcategories'] = 'Sous-catégories';
$string['courses'] = 'Cours';
$string['select_category_to_view'] = 'Veuillez sélectionner une catégorie et cliquer sur "Afficher les Cours" pour voir les données.';
$string['select_category_to_filter'] = 'Sélectionnez une catégorie spécifique pour filtrer les résultats.';
$string['no_courses_found'] = 'Aucun cours trouvé correspondant à votre sélection.';
$string['dashboard'] = 'Tableau de bord';
$string['overview'] = 'Vue d\'ensemble';
$string['risk'] = 'Détails du Risque';
$string['detailed'] = 'Détaillé';
$string['grades_overview'] = 'Aperçu des Notes';
$string['payments'] = 'Paiements';
$string['magic_reports'] = 'Rapports Magiques';
$string['payment_analytics'] = 'Analytique des Paiements';
$string['time_range'] = 'Plage de Temps';
$string['all_time'] = 'Depuis le Début';
$string['today'] = 'Aujourd\'hui';
$string['past_7_days'] = '7 Derniers Jours';
$string['past_30_days'] = '30 Derniers Jours';
$string['past_year'] = 'Année Dernière';
$string['custom_range'] = 'Plage Personnalisée';
$string['from'] = 'De';
$string['to'] = 'À';
$string['category'] = 'Catégorie';
$string['system_analytics'] = 'Analytique du Système';
$string['student_grades_will_appear'] = 'Les notes des étudiants apparaîtront ici.';
$string['no_pending_tasks'] = 'Vous n\'avez aucune tâche en attente ni aucun plan d\'étude adaptatif pour aujourd\'hui.';
$string['caught_up'] = 'Vous êtes complètement à jour !';
$string['due_today'] = 'À Rendre Aujourd\'hui';
$string['go_to_course'] = 'Aller au Cours';
$string['role_student'] = 'Étudiant';
$string['role_teacher'] = 'Enseignant';
$string['role_parent'] = 'Parent/Tuteur';
$string['parent_terminology'] = 'Terminologie Parent';
$string['parent_terminology_desc'] = 'Sélectionnez le terme utilisé pour décrire le rôle de Parent/Mentor dans le tableau de bord.';
$string['term_parent'] = 'Parent';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Partenaire';
$string['term_supervisor'] = 'Superviseur Académique';
$string['term_guardian'] = 'Tuteur Légal';
$string['term_sponsor'] = 'Parrain / Sponsor';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Rapports personnalisés générés par IA enregistrés et créés par l\'utilisateur.';
$string['privacy:metadata:reports:userid'] = 'L\'utilisateur qui a créé le rapport.';
$string['privacy:metadata:reports:title'] = 'Le nom du rapport enregistré.';
$string['privacy:metadata:reports:description'] = 'Description facultative ou invite IA d\'origine.';
$string['privacy:metadata:reports:sql_query'] = 'La requête SQL générée pour le rapport.';
$string['privacy:metadata:reports:timecreated'] = 'La date et l\'heure de création du rapport.';
$string['privacy:metadata:reports:timemodified'] = 'La date et l\'heure de la dernière modification du rapport.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Stocke les identifiants des annonces du tableau de bord que l\'utilisateur a ignorées.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Instantanés des scores d\'étudiants à risque calculés quotidiennement par le moteur de risque.';
$string['privacy:metadata:risk:userid'] = 'L\'étudiant dont le risque a été évalué.';
$string['privacy:metadata:risk:courseid'] = 'Le contexte de cours pour l\'évaluation du risque.';
$string['privacy:metadata:risk:riskscore'] = 'Le score de risque calculé (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'La classification du risque (faible, moyen ou élevé).';
$string['privacy:metadata:risk:timecreated'] = 'La date et l\'heure auxquelles l\'instantané de risque a été calculé.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Les données des étudiants à risque peuvent être envoyées à un webhook de workflow n8n externe configuré par l\'administrateur.';
$string['privacy:metadata:n8n:userid'] = 'L\'identifiant utilisateur de l\'étudiant à risque.';
$string['privacy:metadata:n8n:courseid'] = 'L\'identifiant du cours associé à l\'alerte de risque.';
$string['privacy:metadata:n8n:riskscore'] = 'Le score de risque envoyé au webhook externe.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Historique des analyses et commentaires IA pour les notes des étudiants.';
$string['privacy:metadata:ai_grades:userid'] = 'L\'étudiant dont les notes ont été analysées.';
$string['privacy:metadata:ai_grades:report_html'] = 'Le code HTML des recommandations et retours générés par l\'IA.';
$string['privacy:metadata:ai_grades:timecreated'] = 'L\'horodatage de la génération de l\'analyse.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Calculer les scores des étudiants à risque';
$string['risk_heading'] = 'Alertes d\'Étudiants à Risque';
$string['risk_heading_desc'] = 'Configurez le système d\'alerte précoce pour les étudiants à risque. Le moteur de risque s\'exécute quotidiennement et évalue chaque étudiant selon les critères pondérés ci-dessous. Les enseignants sont automatiquement avertis lorsqu\'un étudiant devient à haut risque.';
$string['n8n_webhook_url'] = 'URL du Webhook n8n';
$string['n8n_webhook_url_desc'] = 'L\'URL du webhook de workflow n8n pour envoyer les données des étudiants à risque.';
$string['n8n_webhook_token'] = 'Jeton du Webhook n8n';
$string['n8n_webhook_token_desc'] = 'Jeton Bearer facultatif pour s\'authentifier auprès de votre webhook n8n.';
$string['risk_max_inactive_days'] = 'Nombre maximal de jours d\'inactivité';
$string['risk_max_inactive_days_desc'] = 'Nombre de jours d\'inactivité avant que le score de risque de connexion atteigne 100 %. Par défaut : 14 jours.';
$string['risk_weight_login'] = 'Pondération : Récence de connexion';
$string['risk_weight_completion'] = 'Pondération : Achèvement du cours';
$string['risk_weight_grade'] = 'Pondération : Note du cours';
$string['risk_weight_overdue'] = 'Pondération : Activités en retard';
$string['risk_weight_adaptiveplan'] = 'Pondération : Respect du plan adaptatif';
$string['risk_weight_desc'] = 'Pondération relative pour ce critère (les valeurs sont normalisées à 100 %). Par défaut : 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Pondération relative pour le respect du plan adaptatif. Redistribuée automatiquement si mod_adaptiveplan n\'est pas installé. Par défaut : 20.';
$string['risk_alert_subject'] = 'Alerte de Risque : {$a} nécessite une attention';
$string['risk_alert_body'] = 'L\'étudiant {$a->studentname} a été signalé comme étant à risque dans le cours "{$a->coursename}" avec un score de risque de {$a->riskscore}%.

Veuillez vérifier les progrès de cet étudiant et envisager de le contacter pour lui offrir de l\'aide.

Consultez le tableau de bord pour plus de détails.';
$string['risk_alert_body_html'] = '<p><strong>L\'étudiant {$a->studentname}</strong> a été signalé comme étant <span style="color:#dc3545;font-weight:bold;">à risque</span> dans le cours "<strong>{$a->coursename}</strong>" avec un score de risque de <strong>{$a->riskscore}%</strong>.</p><p>Veuillez vérifier les progrès de cet étudiant et envisager de le contacter pour lui offrir de l\'aide.</p>';
$string['risk_alert_small'] = '{$a->studentname} est à risque dans {$a->coursename}';
$string['risk_level_low'] = 'Sur la Bonne Voie';
$string['risk_level_medium'] = 'À Surveiller';
$string['risk_level_high'] = 'À Risque';
$string['risk_score'] = 'Score de Risque';
$string['risk_no_data'] = 'Données de risque non encore disponibles. Le système calcule les scores de risque quotidiennement.';
$string['messageprovider:risk_alert'] = 'Notifications des étudiants à risque';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Règle de Risque du Tableau de Bord Intelligent';
$string['subplugintype_smartdashboardrule_plural'] = 'Règles de Risque du Tableau de Bord Intelligent';

// Mobile App Support.
$string['mobile_no_data'] = 'Aucune donnée disponible. Tirez vers le bas pour actualiser.';
$string['at_risk_students'] = 'Étudiants à Risque';
$string['risk_high'] = 'Risque Élevé';
$string['risk_medium'] = 'Risque Moyen';
$string['risk_low'] = 'Risque Faible';
$string['grading_pending'] = 'Notation en Attente';
$string['total_students'] = 'Total des Étudiants';
$string['total_courses'] = 'Total des Cours';
$string['due_date'] = 'Échéance';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Accès refusé';
$string['error_webhook_not_configured'] = 'L\'URL du webhook n8n n\'est pas configurée.';
$string['error_invalid_json'] = 'Charge utile JSON non valide.';
$string['error_invalid_action'] = 'Action non valide';
$string['error_n8n_error'] = 'Erreur n8n : {$a}';
$string['success_data_sent'] = 'Données envoyées avec succès à n8n !';
$string['student_count_display'] = 'Affichage du nombre d\'étudiants';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Somme des étudiants de tous les cours (avec doublons)';
$string['unique_students_tooltip'] = 'Nombre d\'étudiants uniques (sans doublons)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'par ex. Montrez-moi les 5 cours avec les taux d\'achèvement les plus bas...';
$string['magic_ai_description'] = 'Utilisation de l\'IA pour traduire le langage naturel en requêtes SQL.';
$string['show_generated_sql'] = 'Afficher le SQL généré';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Distribution des Revenus';
$string['chart_students_revenue_category'] = 'Étudiants et Revenus par Catégorie';

// Student Overview strings.
$string['student_my_courses'] = 'Mes Cours';
$string['student_upcoming_deadlines'] = 'Échéances à Venir';
$string['student_my_grades'] = 'Mes Notes';
$string['student_overall_average'] = 'Moyenne Générale';
$string['student_complete'] = 'terminé';
$string['student_no_deadlines'] = 'Aucune échéance à venir — vous êtes à jour !';
$string['student_no_grades'] = 'Aucune note disponible pour le moment.';
$string['student_no_courses'] = 'Vous n\'êtes inscrit à aucun cours.';
$string['student_no_progress'] = 'Non suivi';
$string['student_due_soon'] = 'Dans {$a} jours';
$string['student_view_course'] = 'Voir le Cours';
$string['student_course_progress'] = 'Progression du Cours';
$string['student_active_courses'] = 'Cours Actifs';
$string['student_next_deadline'] = 'Prochaine Échéance';
$string['student_recent_feedback'] = 'Commentaires Récents';
$string['student_no_feedback'] = 'Aucun commentaire récent disponible.';
$string['student_none'] = 'Aucun';
$string['student_my_badges'] = 'Mes Derniers Badges';
$string['student_no_badges'] = 'Vous n\'avez pas encore obtenu de badge. Continuez vos efforts !';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Afficher le rapport de notes de cours des étudiants';
$string['studentgrades:viewall'] = 'Afficher les rapports de notes de cours de tous les utilisateurs';
$string['selectuser'] = 'Sélectionner un utilisateur';
$string['exporthtml'] = 'Exporter en HTML';
$string['includedescription'] = 'Inclure la Description';
$string['nousers'] = 'Aucun utilisateur trouvé';
$string['student_nocourses'] = 'L\'étudiant n\'est inscrit à aucun cours';
$string['user'] = 'Étudiant';
$string['reportdate'] = 'Date du rapport';
$string['coursename'] = 'Cours';
$string['gradeitem'] = 'Élément d\'évaluation';
$string['grade'] = 'Note';
$string['range'] = 'Plage';
$string['percentage'] = 'Pourcentage';
$string['total'] = 'Total';
$string['coursetotal'] = 'Total du Cours';
$string['overallsummary'] = 'Résumé Global';
$string['totalcourses'] = 'Total des Cours';
$string['viewmygrades'] = 'Voir Mes Notes';
$string['exportmygrades'] = 'Exporter Mes Notes';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Aucun contenu à exporter.';
$string['filtergrades'] = 'Filtrer les Notes';
$string['allcourses'] = 'Tous les Cours';
$string['categorysearch'] = 'Catégorie / Recherche';
$string['typetofilter'] = 'Tapez pour filtrer...';
$string['analyzeandemail'] = 'Analyser et m\'Envoyer par E-mail';
$string['dailylimitreached'] = 'Limite quotidienne atteinte. Veuillez patienter {$a} minute(s) avant de générer une nouvelle analyse.';
$string['viewanalysisnow'] = 'Voir l\'Analyse Maintenant';
$string['generatinganalysis'] = 'Génération de l\'Analyse...';
$string['talkingtocoreai'] = 'Communication avec Moodle AI...';
$string['aianalysisresult'] = 'Résultat de l\'Analyse IA';
$string['downloadpdf'] = 'Télécharger le PDF';
$string['communicationerror'] = 'Erreur de Communication';
$string['analysishistory'] = 'Historique des Analyses';
$string['defaultprompt'] = 'Vous êtes un assistant IA éducatif. Analysez les données de performance suivantes des étudiants. Les données comprennent les descriptions de cours, les activités, les notes maximales, les notes de l\'étudiant et les descriptions d\'activités. Fournissez une analyse constructive des points forts de l\'étudiant et des axes d\'amélioration sur la base de ces données.';
$string['privacy:metadata:userid'] = 'L\'identifiant de l\'utilisateur.';
$string['privacy:metadata:grades'] = 'Les données de notes de l\'utilisateur.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Les données de notes sont envoyées au webhook n8n pour analyse par IA.';
$string['permissiondenied'] = 'Permission refusée. Vous êtes connecté avec l\'ID Utilisateur : {$a->currentuserid} mais vous avez demandé des données pour l\'ID Utilisateur : {$a->userid}. Autorisation appropriée ou compte parent associé requis.';
$string['airesponsesuccessnocontent'] = 'Réponse de l\'IA réussie mais aucun contenu. Données brutes : {$a}';
$string['aiprovidererror'] = 'Erreur du Fournisseur d\'IA : {$a}';
$string['errorinitializingai'] = 'Erreur lors de l\'initialisation de l\'action IA : {$a}';
$string['aimockresponse'] = 'Réponse du Système IA : Bonjour ! J\'ai bien reçu votre message. (Classes Moodle Core AI non détectées, affichage d\'une réponse simulée)';
$string['generalerror'] = 'Erreur : {$a}';
$string['invalidaction'] = 'Action non valide';
$string['success'] = 'Succès';
$string['unknownerror'] = 'Une erreur inconnue est survenue';
$string['aiconfigmissing'] = 'Configuration IA (URL du Webhook) introuvable dans les paramètres du Rapport de Notes des Étudiants.';
$string['analysisrequestsent'] = 'Demande d\'analyse envoyée avec succès !';
$string['failedtosenddata'] = 'Échec de l\'envoi des données. Code HTTP : {$a->code} Réponse : {$a->response}';
// Color Settings
$string['colorsettings'] = 'Paramètres des Couleurs';
$string['colorsettingsdesc'] = 'Personnalisez les couleurs utilisées dans les rapports de notes exportés en HTML. Ces paramètres vous permettent d\'adapter l\'image de votre établissement et d\'améliorer l\'accessibilité visuelle.';
// Header Colors
$string['headerprimarycolor'] = 'Couleur Primaire de l\'En-tête';
$string['headerprimarycolordesc'] = 'Couleur primaire pour l\'arrière-plan en dégradé de l\'en-tête du rapport';
$string['headersecondarycolor'] = 'Couleur Secondaire de l\'En-tête';
$string['headersecondarycolordesc'] = 'Couleur secondaire pour l\'arrière-plan en dégradé de l\'en-tête du rapport';
$string['headertextcolor'] = 'Couleur du Texte de l\'En-tête';
$string['headertextcolordesc'] = 'Couleur du texte pour l\'en-tête du rapport';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Couleur de Note Excellente';
$string['gradeexcellentcolordesc'] = 'Couleur des indicateurs de performance pour note excellente';
$string['gradegoodcolor'] = 'Couleur de Bonne Note';
$string['gradegoodcolordesc'] = 'Couleur des indicateurs de performance pour bonne note';
$string['gradeaveragecolor'] = 'Couleur de Note Moyenne';
$string['gradeaveragecolordesc'] = 'Couleur des indicateurs de performance pour note moyenne';
$string['gradepoorcolor'] = 'Couleur de Note Faible';
$string['gradepoorcolordesc'] = 'Couleur des indicateurs de performance pour note faible';
// Table Colors
$string['tablebordercolor'] = 'Couleur de Bordure du Tableau';
$string['tablebordercolordesc'] = 'Couleur des bordures du tableau et séparateurs de cellules';
$string['rowalternatecolor'] = 'Couleur Alternée des Lignes';
$string['rowalternatecolordesc'] = 'Couleur d\'arrière-plan pour les lignes alternées du tableau';
$string['rowhovercolor'] = 'Couleur de Survol des Lignes';
$string['rowhovercolordesc'] = 'Couleur d\'arrière-plan au survol des lignes du tableau';
// Category Colors
$string['categoryprimarycolor'] = 'Couleur Primaire de Catégorie';
$string['categoryprimarycolordesc'] = 'Couleur primaire pour l\'arrière-plan en dégradé de la ligne de catégorie';
$string['categorysecondarycolor'] = 'Couleur Secondaire de Catégorie';
$string['categorysecondarycolordesc'] = 'Couleur secondaire pour l\'arrière-plan en dégradé de la ligne de catégorie';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Couleur Primaire du Total de Catégorie';
$string['categorytotalprimarycolordesc'] = 'Couleur primaire pour l\'arrière-plan en dégradé de la ligne du total de catégorie';
$string['categorytotalsecondarycolor'] = 'Couleur Secondaire du Total de Catégorie';
$string['categorytotalsecondarycolordesc'] = 'Couleur secondaire pour l\'arrière-plan en dégradé de la ligne du total de catégorie';
$string['coursetotalprimarycolor'] = 'Couleur Primaire du Total du Cours';
$string['coursetotalprimarycolordesc'] = 'Couleur primaire pour l\'arrière-plan en dégradé de la ligne du total du cours';
$string['coursetotalsecondarycolor'] = 'Couleur Secondaire du Total du Cours';
$string['coursetotalsecondarycolordesc'] = 'Couleur secondaire pour l\'arrière-plan en dégradé de la ligne du total du cours';
// Grade Value Colors
$string['gradevaluecolor'] = 'Couleur du Texte de la Note';
$string['gradevaluecolordesc'] = 'Couleur du texte pour les valeurs de note';
$string['gradevaluebgcolor'] = 'Couleur de Fond de la Valeur de Note';
$string['gradevaluebgcolordesc'] = 'Couleur d\'arrière-plan pour les cellules de valeur de note';
$string['percentagecolor'] = 'Couleur du Texte du Pourcentage';
$string['percentagecolordesc'] = 'Couleur du texte pour les valeurs de pourcentage';
$string['percentagebgcolor'] = 'Couleur de Fond du Pourcentage';
$string['percentagebgcolordesc'] = 'Couleur d\'arrière-plan pour les cellules de pourcentage';
// AI Settings
$string['aisettings'] = 'Paramètres d\'Analyse IA';
$string['aisettingsdesc'] = 'Configurez l\'intégration avec des services d\'IA externes via n8n.';
$string['enableemailanalysis'] = 'Activer l\'Analyse par E-mail';
$string['enableemailanalysisdesc'] = 'Permettre aux utilisateurs de demander un rapport d\'analyse envoyé à leur adresse e-mail.';
$string['enableinstantanalysis'] = 'Activer l\'Analyse Instantanée';
$string['enableinstantanalysisdesc'] = 'Permettre aux utilisateurs de voir instantanément un rapport d\'analyse dans une fenêtre modale.';
$string['webhookurl'] = 'URL du Webhook n8n';
$string['webhookurldesc'] = 'L\'URL du webhook n8n qui traitera les données de notes des étudiants.';
$string['token'] = 'Jeton du Webhook n8n';
$string['tokendesc'] = 'Jeton sécurisé pour l\'authentification auprès du webhook n8n (envoyé dans les en-têtes).';
$string['aiprompt'] = 'Invite d\'Analyse IA';
$string['aipromptdesc'] = 'L\'invite envoyée à l\'IA avec les données de l\'étudiant. Personnalisez-la pour modifier le ton ou l\'orientation de l\'analyse.';
$string['aicooldown'] = 'Délai d\'Attente entre Analyses (Minutes)';
$string['aicooldowndesc'] = 'Temps minimum en minutes entre les demandes d\'analyse pour économiser les ressources. Définir sur 0 pour désactiver.';
// Reset Information
$string['resetcolorsheading'] = 'Réinitialiser les Couleurs';
$string['resetcolorsdesc'] = 'Pour réinitialiser toutes les couleurs à leurs valeurs par défaut, effacez chaque champ de couleur et enregistrez les paramètres. Le plugin utilisera automatiquement le schéma de couleurs par défaut.';

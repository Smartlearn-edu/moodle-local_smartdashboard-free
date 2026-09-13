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
 * Dutch language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Smart Dashboard';
$string['smartdashboard:view'] = 'Het Smart Dashboard bekijken';
$string['mycourses'] = 'Mijn cursussen';
$string['nocourses'] = 'Je geeft nog geen les in cursussen.';
$string['gotocourse'] = 'Ga naar cursus';
$string['students'] = 'studenten';
$string['enrollments'] = 'Aanmeldingen';
$string['activities'] = 'Activiteiten';
$string['needsgrading'] = 'Te beoordelen inzending(en)';
$string['section_overview'] = 'Overzicht';
$string['section_grading'] = 'Beoordeling';
$string['section_progress'] = 'Voortgang van de student';
$string['section_analytics'] = 'Analyses';
$string['section_settings'] = 'Instellingen';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Pictogrammen studentendashboard';
$string['student_icons_desc'] = 'Configureer de pictogrammen die worden weergegeven op de welkomstbanner van het studentendashboard.';
$string['icon_heading'] = 'Pictogram {$a}';
$string['icon_name'] = 'Pictogramnaam';
$string['icon_class'] = 'Pictogramklasse (FontAwesome)';
$string['icon_class_desc'] = 'bijv. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'Link-URL';
$string['welcomebackstudent'] = 'Welkom terug, {$a}!';
$string['privacy:metadata'] = 'De Smart Dashboard-plugin slaat geen persoonlijke gegevens op.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Dashboard-vervanging';
$string['redirect_desc'] = 'Configureer of het Smart Dashboard het standaard Moodle-dashboard vervangt voor specifieke rollen.';
$string['enabledirect'] = 'Dashboard-vervanging inschakelen';
$string['enabledirect_desc'] = 'Indien ingeschakeld, worden gebruikers met geselecteerde rollen die het standaarddashboard bezoeken hierheen doorgestuurd.';
$string['redirectroles'] = 'Door te sturen rollen';
$string['redirectroles_desc'] = 'Selecteer de rollen die moeten worden doorgestuurd naar het Smart Dashboard. Gebruikers met ELK van deze rollen in ELKE context worden beïnvloed.';
$string['redirectadmins'] = 'Sitebeheerders doorsturen';
$string['redirectadmins_desc'] = 'Moeten sitebeheerders ook worden doorgestuurd?';

// Appearance Settings.
$string['appearance_heading'] = 'Uiterlijk';
$string['appearance_desc'] = 'Pas het visuele uiterlijk van het Smart Dashboard aan.';
$string['thememode'] = 'Kleurmodus';
$string['thememode_desc'] = 'Kies de kleurmodus voor het dashboard. Gebruik "Licht" als je Moodle-thema een lichte achtergrond heeft, of "Donker" voor websites met een donker thema.';
$string['thememode_dark'] = 'Donkere modus';
$string['thememode_light'] = 'Lichte modus';
$string['todays_agenda'] = 'Agenda van vandaag';
$string['payment_calc_mode'] = 'Betalingsberekeningsmodus';
$string['payment_calc_mode_desc'] = 'Kies hoe de betalingsanalyse de omzet en het aantal studenten berekent.';
$string['save_settings'] = 'Instellingen opslaan';
$string['latest_announcements'] = 'Laatste aankondigingen';
$string['dont_show_again'] = 'Dit niet meer weergeven';
$string['close'] = 'Sluiten';
$string['magic_reports_title'] = 'Magische rapporten (AI-analyse)';
$string['magic_reports_desc'] = 'Stel vragen over je gegevens in natuurlijke taal en de AI genereert het rapport voor je.';
$string['saved_reports'] = 'Opgeslagen rapporten';
$string['loading'] = 'Laden...';
$string['ask_a_question'] = 'Stel een vraag';
$string['generate'] = 'Genereren';
$string['result'] = 'Resultaat';
$string['save_report'] = 'Rapport opslaan';
$string['assignments_needing_grading'] = 'Opdrachten die moeten worden beoordeeld';
$string['student_welcome_sub'] = 'Hier is je voortgang en leermiddelen.';
$string['welcome_back'] = 'Welkom terug!';
$string['teacher_welcome_sub'] = 'Hier zijn de cursussen waarin je lesgeeft. Volg de voortgang van studenten, beoordelingen en inzichten in betrokkenheid.';
$string['parent_welcome_sub'] = 'Hier kun je de voortgang en activiteiten van je pupillen volgen.';
$string['parent_mentees_title'] = 'Je pupillen';
$string['parent_overall_performance'] = 'Algehele prestatie';
$string['parent_upcoming_deadlines'] = 'Aankomende deadlines';
$string['parent_recent_results'] = 'Recente resultaten';
$string['parent_no_data'] = 'Geen gegevens beschikbaar';
$string['parent_view_calendar'] = 'Kalender bekijken';
$string['parent_average_grade'] = 'Gemiddeld cijfer';
$string['saving'] = 'Opslaan...';
$string['filter_by_cat'] = 'Filteren op categorie';
$string['select_category'] = 'Selecteer een categorie...';
$string['show_courses'] = 'Cursussen tonen';
$string['total_enrollments'] = 'Totaal aantal aanmeldingen';
$string['direct_sum'] = 'Directe som';
$string['unique_students'] = 'Unieke studenten';
$string['subcategories'] = 'Subcategorieën';
$string['courses'] = 'Cursussen';
$string['select_category_to_view'] = 'Selecteer een categorie en klik op "Cursussen tonen" om gegevens te bekijken.';
$string['select_category_to_filter'] = 'Selecteer een specifieke categorie om de resultaten te filteren.';
$string['no_courses_found'] = 'Geen cursussen gevonden die overeenkomen met je selectie.';
$string['dashboard'] = 'Dashboard';
$string['overview'] = 'Overzicht';
$string['risk'] = 'Risicodetails';
$string['detailed'] = 'Gedetailleerd';
$string['grades_overview'] = 'Cijferoverzicht';
$string['payments'] = 'Betalingen';
$string['magic_reports'] = 'Magische rapporten';
$string['payment_analytics'] = 'Betalingsanalyse';
$string['time_range'] = 'Tijdsbereik';
$string['all_time'] = 'Alle periodes';
$string['today'] = 'Vandaag';
$string['past_7_days'] = 'Afgelopen 7 dagen';
$string['past_30_days'] = 'Afgelopen 30 dagen';
$string['past_year'] = 'Afgelopen jaar';
$string['custom_range'] = 'Aangepast bereik';
$string['from'] = 'Van';
$string['to'] = 'Tot';
$string['category'] = 'Categorie';
$string['system_analytics'] = 'Systeemanalyse';
$string['student_grades_will_appear'] = 'Cijfers van de student worden hier weergegeven.';
$string['no_pending_tasks'] = 'Je hebt vandaag geen openstaande taken of adaptieve studieplannen.';
$string['caught_up'] = 'Je bent helemaal bij!';
$string['due_today'] = 'Vandaag inleveren';
$string['go_to_course'] = 'Ga naar cursus';
$string['role_student'] = 'Student';
$string['role_teacher'] = 'Docent';
$string['role_parent'] = 'Ouder';
$string['parent_terminology'] = 'Ouderterminologie';
$string['parent_terminology_desc'] = 'Selecteer het woord dat wordt gebruikt om de rol Ouder/Mentor in het dashboard te beschrijven.';
$string['term_parent'] = 'Ouder';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Partner';
$string['term_supervisor'] = 'Academisch begeleider';
$string['term_guardian'] = 'Voogd';
$string['term_sponsor'] = 'Sponsor';
// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Opgeslagen aangepaste AI-gegenereerde rapporten gemaakt door de gebruiker.';
$string['privacy:metadata:reports:userid'] = 'De gebruiker die het rapport heeft gemaakt.';
$string['privacy:metadata:reports:title'] = 'De naam van het opgeslagen rapport.';
$string['privacy:metadata:reports:description'] = 'Optionele beschrijving of de oorspronkelijke AI-prompt.';
$string['privacy:metadata:reports:sql_query'] = 'De SQL-query gegenereerd voor het rapport.';
$string['privacy:metadata:reports:timecreated'] = 'Het tijdstip waarop het rapport is gemaakt.';
$string['privacy:metadata:reports:timemodified'] = 'Het tijdstip waarop het rapport voor het laatst is gewijzigd.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Slaat de ID\'s op van dashboardaankondigingen die de gebruiker heeft gesloten.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Momentopnamen van risicoscores van studenten die dagelijks worden berekend door het risicosysteem.';
$string['privacy:metadata:risk:userid'] = 'De student wiens risico is geëvalueerd.';
$string['privacy:metadata:risk:courseid'] = 'De cursuscontext voor de risico-evaluatie.';
$string['privacy:metadata:risk:riskscore'] = 'De berekende risicoscore (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'De risicoclassificatie (laag, gemiddeld of hoog).';
$string['privacy:metadata:risk:timecreated'] = 'Het tijdstip waarop de risicomomentopname is berekend.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Gegevens van risicostudenten kunnen worden verzonden naar een externe n8n-workflow-webhook die is geconfigureerd door de beheerder.';
$string['privacy:metadata:n8n:userid'] = 'De gebruikers-ID van de risicostudent.';
$string['privacy:metadata:n8n:courseid'] = 'De cursus-ID gerelateerd aan de risicomelding.';
$string['privacy:metadata:n8n:riskscore'] = 'De risicoscore die naar de externe webhook is verzonden.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Historische AI-analyses en feedback voor cijfers van studenten.';
$string['privacy:metadata:ai_grades:userid'] = 'De student wiens cijfers zijn geanalyseerd.';
$string['privacy:metadata:ai_grades:report_html'] = 'De door AI gegenereerde HTML voor feedback en aanbevelingen.';
$string['privacy:metadata:ai_grades:timecreated'] = 'De tijdstempel waarop de analyse is gegenereerd.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Risicoscores van studenten berekenen';
$string['risk_heading'] = 'Meldingen voor risicostudenten';
$string['risk_heading_desc'] = 'Configureer het vroegtijdige waarschuwingssysteem voor risicostudenten. Het risicosysteem draait dagelijks en beoordeelt elke student op basis van de onderstaande gewogen criteria. Docenten worden automatisch op de hoogte gebracht wanneer een student een hoog risico loopt.';
$string['n8n_webhook_url'] = 'n8n Webhook-URL';
$string['n8n_webhook_url_desc'] = 'De URL naar je n8n-workflow-webhook voor het verzenden van gegevens over risicostudenten.';
$string['n8n_webhook_token'] = 'n8n Webhook-token';
$string['n8n_webhook_token_desc'] = 'Optioneel Bearer-token voor authenticatie bij je n8n-webhook.';
$string['risk_max_inactive_days'] = 'Maximaal aantal inactieve dagen';
$string['risk_max_inactive_days_desc'] = 'Aantal dagen van inactiviteit voordat de inlogrisicoscore 100% bereikt. Standaard: 14 dagen.';
$string['risk_weight_login'] = 'Gewicht: Recentheid van inloggen';
$string['risk_weight_completion'] = 'Gewicht: Cursusvoltooiing';
$string['risk_weight_grade'] = 'Gewicht: Cursuscijfer';
$string['risk_weight_overdue'] = 'Gewicht: Achterstallige activiteiten';
$string['risk_weight_adaptiveplan'] = 'Gewicht: Naleving van adaptief studieplan';
$string['risk_weight_desc'] = 'Relatief gewicht voor dit criterium (waarden worden genormaliseerd naar 100%). Standaard: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Relatief gewicht voor de naleving van het adaptieve studieplan. Wordt automatisch herverdeeld als mod_adaptiveplan niet is geïnstalleerd. Standaard: 20.';
$string['risk_alert_subject'] = 'Risicomelding: {$a} heeft aandacht nodig';
$string['risk_alert_body'] = 'Student {$a->studentname} is gemarkeerd als risicostudent in de cursus "{$a->coursename}" met een risicoscore van {$a->riskscore}%.

Controleer de voortgang van deze student en overweeg om ondersteuning aan te bieden.

Bekijk het dashboard voor meer details.';
$string['risk_alert_body_html'] = '<p><strong>Student {$a->studentname}</strong> is gemarkeerd als <span style="color:#dc3545;font-weight:bold;">risicostudent</span> in de cursus "<strong>{$a->coursename}</strong>" met een risicoscore van <strong>{$a->riskscore}%</strong>.</p><p>Controleer de voortgang van deze student en overweeg om ondersteuning aan te bieden.</p>';
$string['risk_alert_small'] = '{$a->studentname} loopt risico in {$a->coursename}';
$string['risk_level_low'] = 'Op schema';
$string['risk_level_medium'] = 'Monitoren';
$string['risk_level_high'] = 'In risicozone';
$string['risk_score'] = 'Risicoscore';
$string['risk_no_data'] = 'Risicogegevens zijn nog niet beschikbaar. Het systeem berekent dagelijks de risicoscores.';
$string['messageprovider:risk_alert'] = 'Meldingen over risicostudenten';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Smart Dashboard risicoregel';
$string['subplugintype_smartdashboardrule_plural'] = 'Smart Dashboard risicoregels';

// Mobile App Support.
$string['mobile_no_data'] = 'Geen gegevens beschikbaar. Trek omlaag om te vernieuwen.';
$string['at_risk_students'] = 'Risicostudenten';
$string['risk_high'] = 'Hoog risico';
$string['risk_medium'] = 'Gemiddeld risico';
$string['risk_low'] = 'Laag risico';
$string['grading_pending'] = 'Beoordeling in behandeling';
$string['total_students'] = 'Totaal aantal studenten';
$string['total_courses'] = 'Totaal aantal cursussen';
$string['due_date'] = 'Uiterste datum';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Toegang geweigerd';
$string['error_webhook_not_configured'] = 'n8n Webhook-URL is niet geconfigureerd.';
$string['error_invalid_json'] = 'Ongeldige JSON-payload.';
$string['error_invalid_action'] = 'Ongeldige actie';
$string['error_n8n_error'] = 'n8n-fout: {$a}';
$string['success_data_sent'] = 'Gegevens succesvol verzonden naar n8n!';
$string['student_count_display'] = 'Weergave aantal studenten';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Som van studenten in alle cursussen (inclusief duplicaten)';
$string['unique_students_tooltip'] = 'Aantal unieke studenten (zonder duplicaten)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'bijv. Toon me de top 5 cursussen met de laagste voltooiingspercentages...';
$string['magic_ai_description'] = 'AI gebruiken om natuurlijke taal te vertalen naar SQL-query\'s.';
$string['show_generated_sql'] = 'Gegenereerde SQL tonen';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Omzetverdeling';
$string['chart_students_revenue_category'] = 'Studenten en omzet per categorie';

// Student Overview strings.
$string['student_my_courses'] = 'Mijn cursussen';
$string['student_upcoming_deadlines'] = 'Aankomende deadlines';
$string['student_my_grades'] = 'Mijn cijfers';
$string['student_overall_average'] = 'Algemeen gemiddelde';
$string['student_complete'] = 'voltooid';
$string['student_no_deadlines'] = 'Geen aankomende deadlines — je bent helemaal bij!';
$string['student_no_grades'] = 'Nog geen cijfers beschikbaar.';
$string['student_no_courses'] = 'Je bent niet ingeschreven voor cursussen.';
$string['student_no_progress'] = 'Niet bijgehouden';
$string['student_due_soon'] = 'Over {$a} dagen';
$string['student_view_course'] = 'Cursus bekijken';
$string['student_course_progress'] = 'Cursusvoortgang';
$string['student_active_courses'] = 'Actieve cursussen';
$string['student_next_deadline'] = 'Volgende deadline';
$string['student_recent_feedback'] = 'Recente feedback';
$string['student_no_feedback'] = 'Geen recente feedback beschikbaar.';
$string['student_none'] = 'Geen';
$string['student_my_badges'] = 'Mijn nieuwste badges';
$string['student_no_badges'] = 'Je hebt nog geen badges verdiend. Ga zo door!';



// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Cursuscijferrapport van student bekijken';
$string['studentgrades:viewall'] = 'Cursuscijferrapporten van alle gebruikers bekijken';
$string['selectuser'] = 'Gebruiker selecteren';
$string['exporthtml'] = 'Exporteren als HTML';
$string['includedescription'] = 'Beschrijving opnemen';
$string['nousers'] = 'Geen gebruikers gevonden';
$string['student_nocourses'] = 'Student is niet ingeschreven voor cursussen';
$string['user'] = 'Student';
$string['reportdate'] = 'Rapportdatum';
$string['coursename'] = 'Cursus';
$string['gradeitem'] = 'Beoordelingsitem';
$string['grade'] = 'Cijfer';
$string['range'] = 'Bereik';
$string['percentage'] = 'Percentage';
$string['total'] = 'Totaal';
$string['coursetotal'] = 'Cursustotaal';
$string['overallsummary'] = 'Algemeen overzicht';
$string['totalcourses'] = 'Totaal aantal cursussen';
$string['viewmygrades'] = 'Mijn cijfers bekijken';
$string['exportmygrades'] = 'Mijn cijfers exporteren';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Geen inhoud om te exporteren.';
$string['filtergrades'] = 'Cijfers filteren';
$string['allcourses'] = 'Alle cursussen';
$string['categorysearch'] = 'Categorie / Zoeken';
$string['typetofilter'] = 'Typ om te filteren...';
$string['analyzeandemail'] = 'Analyseren en naar mij e-mailen';
$string['dailylimitreached'] = 'Dagelijkse limiet bereikt. Wacht {$a} minuut/minuten voordat je een nieuwe analyse genereert.';
$string['viewanalysisnow'] = 'Analyse nu bekijken';
$string['generatinganalysis'] = 'Analyse genereren...';
$string['talkingtocoreai'] = 'Communiceren met Moodle AI...';
$string['aianalysisresult'] = 'Resultaat van AI-analyse';
$string['downloadpdf'] = 'PDF downloaden';
$string['communicationerror'] = 'Communicatiefout';
$string['analysishistory'] = 'Analysegeschiedenis';
$string['defaultprompt'] = 'Je bent een educatieve AI-assistent. Analyseer de volgende prestatiegegevens van de student. De gegevens omvatten cursusbeschrijvingen, activiteiten, maximale cijfers, cijfers van de student en activiteitsbeschrijvingen. Geef een constructieve analyse van de sterke punten van de student en verbeterpunten op basis van deze gegevens.';
$string['privacy:metadata:userid'] = 'De gebruikers-ID.';
$string['privacy:metadata:grades'] = 'De cijfergegevens van de gebruiker.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Cijfergegevens worden naar de n8n-webhook verzonden voor AI-analyse.';
$string['permissiondenied'] = 'Toegang geweigerd. Je bent ingelogd als gebruikers-ID: {$a->currentuserid} maar hebt gegevens aangevraagd voor gebruikers-ID: {$a->userid}. De juiste bevoegdheid of een gekoppeld ouderaccount is vereist.';
$string['airesponsesuccessnocontent'] = 'AI-antwoord succesvol maar geen inhoud. Ruwe gegevens: {$a}';
$string['aiprovidererror'] = 'AI-providerfout: {$a}';
$string['errorinitializingai'] = 'Fout bij initialiseren van AI-actie: {$a}';
$string['aimockresponse'] = 'AI-systeemantwoord: Hallo! Ik heb je bericht ontvangen. (Moodle Core AI-klassen niet gedetecteerd, mock-antwoord wordt weergegeven)';
$string['generalerror'] = 'Fout: {$a}';
$string['invalidaction'] = 'Ongeldige actie';
$string['success'] = 'Succes';
$string['unknownerror'] = 'Onbekende fout opgetreden';
$string['aiconfigmissing'] = 'AI-configuratie (Webhook-URL) niet gevonden in de instellingen van het Cursuscijferrapport.';
$string['analysisrequestsent'] = 'Analyseverzoek succesvol verzonden!';
$string['failedtosenddata'] = 'Verzenden van gegevens mislukt. HTTP-code: {$a->code} Antwoord: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Kleurinstellingen';
$string['colorsettingsdesc'] = 'Pas de kleuren aan die worden gebruikt in de HTML-exportcijferrapporten. Met deze instellingen kun je aansluiten bij de huisstijl van je instelling en de visuele toegankelijkheid verbeteren.';
// Header Colors
$string['headerprimarycolor'] = 'Primaire koptekstkleur';
$string['headerprimarycolordesc'] = 'Primaire kleur voor de verloopachtergrond van de rapportkoptekst';
$string['headersecondarycolor'] = 'Secundaire koptekstkleur';
$string['headersecondarycolordesc'] = 'Secundaire kleur voor de verloopachtergrond van de rapportkoptekst';
$string['headertextcolor'] = 'Tekstkleur van koptekst';
$string['headertextcolordesc'] = 'Tekstkleur voor de rapportkoptekst';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Kleur voor uitstekend cijfer';
$string['gradeexcellentcolordesc'] = 'Kleur voor prestatie-indicatoren bij uitstekende cijfers';
$string['gradegoodcolor'] = 'Kleur voor goed cijfer';
$string['gradegoodcolordesc'] = 'Kleur voor prestatie-indicatoren bij goede cijfers';
$string['gradeaveragecolor'] = 'Kleur voor gemiddeld cijfer';
$string['gradeaveragecolordesc'] = 'Kleur voor prestatie-indicatoren bij gemiddelde cijfers';
$string['gradepoorcolor'] = 'Kleur voor onvoldoende cijfer';
$string['gradepoorcolordesc'] = 'Kleur voor prestatie-indicatoren bij onvoldoende cijfers';
// Table Colors
$string['tablebordercolor'] = 'Tabelrandkleur';
$string['tablebordercolordesc'] = 'Kleur voor tabelranden en celscheidingen';
$string['rowalternatecolor'] = 'Kleur voor afwisselende rijen';
$string['rowalternatecolordesc'] = 'Achtergrondkleur voor afwisselende tabelrijen';
$string['rowhovercolor'] = 'Rij-hoverkleur';
$string['rowhovercolordesc'] = 'Achtergrondkleur bij het aanwijzen van tabelrijen';
// Category Colors
$string['categoryprimarycolor'] = 'Primaire categoriekleur';
$string['categoryprimarycolordesc'] = 'Primaire kleur voor de verloopachtergrond van categorierijen';
$string['categorysecondarycolor'] = 'Secundaire categoriekleur';
$string['categorysecondarycolordesc'] = 'Secundaire kleur voor de verloopachtergrond van categorierijen';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Primaire kleur categorietotaal';
$string['categorytotalprimarycolordesc'] = 'Primaire kleur voor de verloopachtergrond van categorietotaalrijen';
$string['categorytotalsecondarycolor'] = 'Secundaire kleur categorietotaal';
$string['categorytotalsecondarycolordesc'] = 'Secundaire kleur voor de verloopachtergrond van categorietotaalrijen';
$string['coursetotalprimarycolor'] = 'Primaire kleur cursustotaal';
$string['coursetotalprimarycolordesc'] = 'Primaire kleur voor de verloopachtergrond van cursustotaalrijen';
$string['coursetotalsecondarycolor'] = 'Secundaire kleur cursustotaal';
$string['coursetotalsecondarycolordesc'] = 'Secundaire kleur voor de verloopachtergrond van cursustotaalrijen';
// Grade Value Colors
$string['gradevaluecolor'] = 'Tekstkleur voor cijferwaarde';
$string['gradevaluecolordesc'] = 'Tekstkleur voor cijferwaarden';
$string['gradevaluebgcolor'] = 'Achtergrondkleur voor cijferwaarde';
$string['gradevaluebgcolordesc'] = 'Achtergrondkleur voor cellen met cijferwaarden';
$string['percentagecolor'] = 'Tekstkleur voor percentage';
$string['percentagecolordesc'] = 'Tekstkleur voor percentagewaarden';
$string['percentagebgcolor'] = 'Achtergrondkleur voor percentage';
$string['percentagebgcolordesc'] = 'Achtergrondkleur voor percentagecellen';
// AI Settings
$string['aisettings'] = 'AI-analyse-instellingen';
$string['aisettingsdesc'] = 'Configureer de integratie met externe AI-diensten via n8n.';
$string['enableemailanalysis'] = 'Analyse via e-mail inschakelen';
$string['enableemailanalysisdesc'] = 'Sta gebruikers toe om een analyserapport aan te vragen dat naar hun e-mail wordt verzonden.';
$string['enableinstantanalysis'] = 'Directe analyse inschakelen';
$string['enableinstantanalysisdesc'] = 'Sta gebruikers toe om direct een analyserapport te bekijken in een pop-upvenster.';
$string['webhookurl'] = 'n8n Webhook-URL';
$string['webhookurldesc'] = 'De URL van de n8n-webhook die de cijfergegevens van de student verwerkt.';
$string['token'] = 'n8n Webhook-token';
$string['tokendesc'] = 'Beveiligingstoken voor authenticatie bij de n8n-webhook (verzonden in headers).';
$string['aiprompt'] = 'AI-analyseprompt';
$string['aipromptdesc'] = 'De prompt die samen met de studentgegevens naar de AI wordt gestuurd. Pas dit aan om de toon of focus van de analyse te wijzigen.';
$string['aicooldown'] = 'Afkoelperiode analyse (minuten)';
$string['aicooldowndesc'] = 'Minimale tijd in minuten tussen analyseverzoeken om datalimieten te besparen. Stel in op 0 om uit te schakelen.';
// Reset Information
$string['resetcolorsheading'] = 'Kleuren herstellen';
$string['resetcolorsdesc'] = 'Om alle kleuren terug te zetten naar de standaardwaarden, maakt u elk kleurveld leeg en slaat u de instellingen op. De plug-in gebruikt automatisch het standaardkleurenschema.';

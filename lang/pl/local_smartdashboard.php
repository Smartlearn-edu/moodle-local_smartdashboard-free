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
 * Polish language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Inteligentny kokpit';
$string['smartdashboard:view'] = 'Wyświetlanie inteligentnego kokpitu';
$string['mycourses'] = 'Moje kursy';
$string['nocourses'] = 'Nie prowadzisz jeszcze żadnych kursów.';
$string['gotocourse'] = 'Przejdź do kursu';
$string['students'] = 'studenci';
$string['enrollments'] = 'Zapisy';
$string['activities'] = 'Aktywności';
$string['needsgrading'] = 'Prace do ocenienia';
$string['section_overview'] = 'Przegląd';
$string['section_grading'] = 'Ocenianie';
$string['section_progress'] = 'Postępy studentów';
$string['section_analytics'] = 'Analityka';
$string['section_settings'] = 'Ustawienia';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Ikony kokpitu studenta';
$string['student_icons_desc'] = 'Skonfiguruj ikony wyświetlane na banerze powitalnym kokpitu studenta.';
$string['icon_heading'] = 'Ikona {$a}';
$string['icon_name'] = 'Nazwa ikony';
$string['icon_class'] = 'Klasa ikony (FontAwesome)';
$string['icon_class_desc'] = 'np. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'Adres URL linku';
$string['welcomebackstudent'] = 'Witaj ponownie, {$a}!';
$string['privacy:metadata'] = 'Wtyczka Inteligentny kokpit nie przechowuje żadnych danych osobowych.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Zastąpienie kokpitu';
$string['redirect_desc'] = 'Skonfiguruj, czy Inteligentny kokpit ma zastępować domyślny kokpit Moodle dla określonych ról.';
$string['enabledirect'] = 'Włącz zastąpienie kokpitu';
$string['enabledirect_desc'] = 'Jeśli włączone, użytkownicy z wybranymi rolami odwiedzający domyślny kokpit zostaną przekierowani tutaj.';
$string['redirectroles'] = 'Role do przekierowania';
$string['redirectroles_desc'] = 'Wybierz role, które powinny zostać przekierowane do Inteligentnego kokpitu. Wpłynie to na użytkowników posiadających DOWOLNĄ z tych ról w DOWOLNYM kontekście.';
$string['redirectadmins'] = 'Przekieruj administratorów witryny';
$string['redirectadmins_desc'] = 'Czy administratorzy witryny również powinni być przekierowywani?';

// Appearance Settings.
$string['appearance_heading'] = 'Wygląd';
$string['appearance_desc'] = 'Dostosuj wygląd wizualny Inteligentnego kokpitu.';
$string['thememode'] = 'Tryb kolorów';
$string['thememode_desc'] = 'Wybierz tryb kolorów dla kokpitu. Użyj "Jasny", jeśli Twój motyw Moodle ma jasne tło, lub "Ciemny" dla witryn o ciemnym motywie.';
$string['thememode_dark'] = 'Tryb ciemny';
$string['thememode_light'] = 'Tryb jasny';
$string['todays_agenda'] = 'Harmonogram na dziś';
$string['payment_calc_mode'] = 'Tryb obliczania płatności';
$string['payment_calc_mode_desc'] = 'Wybierz, w jaki sposób analityka płatności oblicza przychody oraz liczbę studentów.';
$string['save_settings'] = 'Zapisz ustawienia';
$string['latest_announcements'] = 'Najnowsze ogłoszenia';
$string['dont_show_again'] = 'Nie pokazuj tego ponownie';
$string['close'] = 'Zamknij';
$string['magic_reports_title'] = 'Magiczne raporty (Analiza AI)';
$string['magic_reports_desc'] = 'Zadawaj pytania dotyczące Twoich danych w języku naturalnym, a sztuczna inteligencja wygeneruje dla Ciebie raport.';
$string['saved_reports'] = 'Zapisane raporty';
$string['loading'] = 'Ładowanie...';
$string['ask_a_question'] = 'Zadaj pytanie';
$string['generate'] = 'Generuj';
$string['result'] = 'Wynik';
$string['save_report'] = 'Zapisz raport';
$string['assignments_needing_grading'] = 'Zadania wymagające ocenienia';
$string['student_welcome_sub'] = 'Oto Twoje postępy i zasoby.';
$string['welcome_back'] = 'Witaj ponownie!';
$string['teacher_welcome_sub'] = 'Oto kursy, które prowadzisz. Śledź postępy studentów, oceny oraz wskaźniki zaangażowania.';
$string['parent_welcome_sub'] = 'Tutaj możesz monitorować postępy i aktywności swoich podopiecznych.';
$string['parent_mentees_title'] = 'Twoi podopieczni';
$string['parent_overall_performance'] = 'Ogólne wyniki';
$string['parent_upcoming_deadlines'] = 'Nadchodzące terminy';
$string['parent_recent_results'] = 'Ostatnie wyniki';
$string['parent_no_data'] = 'Brak dostępnych danych';
$string['parent_view_calendar'] = 'Zobacz kalendarz';
$string['parent_average_grade'] = 'Średnia ocena';
$string['saving'] = 'Zapisywanie...';
$string['filter_by_cat'] = 'Filtruj według kategorii';
$string['select_category'] = 'Wybierz kategorię...';
$string['show_courses'] = 'Pokaż kursy';
$string['total_enrollments'] = 'Łączna liczba zapisów';
$string['direct_sum'] = 'Suma bezpośrednia';
$string['unique_students'] = 'Unikalni studenci';
$string['subcategories'] = 'Podkategorie';
$string['courses'] = 'Kursy';
$string['select_category_to_view'] = 'Wybierz kategorię i kliknij "Pokaż kursy", aby wyświetlić dane.';
$string['select_category_to_filter'] = 'Wybierz określoną kategorię, aby filtrować wyniki.';
$string['no_courses_found'] = 'Nie znaleziono kursów pasujących do Twojego wyboru.';
$string['dashboard'] = 'Kokpit';
$string['overview'] = 'Przegląd';
$string['risk'] = 'Szczegóły ryzyka';
$string['detailed'] = 'Szczegółowy';
$string['grades_overview'] = 'Przegląd ocen';
$string['payments'] = 'Płatności';
$string['magic_reports'] = 'Magiczne raporty';
$string['payment_analytics'] = 'Analityka płatności';
$string['time_range'] = 'Zakres czasu';
$string['all_time'] = 'Cały okres';
$string['today'] = 'Dzisiaj';
$string['past_7_days'] = 'Ostatnie 7 dni';
$string['past_30_days'] = 'Ostatnie 30 dni';
$string['past_year'] = 'Ostatni rok';
$string['custom_range'] = 'Własny zakres';
$string['from'] = 'Od';
$string['to'] = 'Do';
$string['category'] = 'Kategoria';
$string['system_analytics'] = 'Analityka systemowa';
$string['student_grades_will_appear'] = 'Tutaj pojawią się oceny studenta.';
$string['no_pending_tasks'] = 'Nie masz żadnych oczekujących zadań ani adaptacyjnych planów nauki na dziś.';
$string['caught_up'] = 'Wszystko zrobione na bieżąco!';
$string['due_today'] = 'Termin na dziś';
$string['go_to_course'] = 'Przejdź do kursu';
$string['role_student'] = 'Student';
$string['role_teacher'] = 'Nauczyciel';
$string['role_parent'] = 'Rodzic';
$string['parent_terminology'] = 'Terminologia roli rodzica';
$string['parent_terminology_desc'] = 'Wybierz słowo używane do opisania roli Rodzica/Mentora w kokpicie.';
$string['term_parent'] = 'Rodzic';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Partner';
$string['term_supervisor'] = 'Opiekun naukowy';
$string['term_guardian'] = 'Opiekun prawny';
$string['term_sponsor'] = 'Sponsor';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Zapisane niestandardowe raporty wygenerowane przez AI utworzone przez użytkownika.';
$string['privacy:metadata:reports:userid'] = 'Użytkownik, który utworzył raport.';
$string['privacy:metadata:reports:title'] = 'Nazwa zapisanego raportu.';
$string['privacy:metadata:reports:description'] = 'Opcjonalny opis lub oryginalne zapytanie do AI.';
$string['privacy:metadata:reports:sql_query'] = 'Zapytanie SQL wygenerowane dla raportu.';
$string['privacy:metadata:reports:timecreated'] = 'Czas utworzenia raportu.';
$string['privacy:metadata:reports:timemodified'] = 'Czas ostatniej modyfikacji raportu.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Przechowuje identyfikatory ogłoszeń w kokpicie, które użytkownik odrzucił.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Migawki punktacji studentów zagrożonych obliczane codziennie przez mechanizm ryzyka.';
$string['privacy:metadata:risk:userid'] = 'Student, którego ryzyko zostało ocenione.';
$string['privacy:metadata:risk:courseid'] = 'Kontekst kursu dla oceny ryzyka.';
$string['privacy:metadata:risk:riskscore'] = 'Obliczony wskaźnik ryzyka (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'Klasyfikacja ryzyka (niskie, średnie lub wysokie).';
$string['privacy:metadata:risk:timecreated'] = 'Czas obliczenia migawki ryzyka.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Dane studentów zagrożonych mogą być wysyłane do zewnętrznego webhooka przepływu pracy n8n skonfigurowanego przez administratora.';
$string['privacy:metadata:n8n:userid'] = 'Identyfikator użytkownika zagrożonego studenta.';
$string['privacy:metadata:n8n:courseid'] = 'Identyfikator kursu powiązanego z alertem o ryzyku.';
$string['privacy:metadata:n8n:riskscore'] = 'Wskaźnik ryzyka wysłany do zewnętrznego webhooka.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Historyczna analiza AI i informacje zwrotne dotyczące ocen studenta.';
$string['privacy:metadata:ai_grades:userid'] = 'Student, którego oceny zostały przeanalizowane.';
$string['privacy:metadata:ai_grades:report_html'] = 'Kod HTML wygenerowanych przez AI informacji zwrotnych i rekomendacji.';
$string['privacy:metadata:ai_grades:timecreated'] = 'Znacznik czasu wygenerowania analizy.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Oblicz wskaźniki studentów zagrożonych';
$string['risk_heading'] = 'Alerty o studentach zagrożonych';
$string['risk_heading_desc'] = 'Skonfiguruj system wczesnego ostrzegania o studentach zagrożonych. Silnik ryzyka działa codziennie i ocenia każdego studenta na podstawie poniższych ważonych kryteriów. Nauczyciele są automatycznie powiadamiani, gdy student znajdzie się w grupie wysokiego ryzyka.';
$string['n8n_webhook_url'] = 'Adres URL webhooka n8n';
$string['n8n_webhook_url_desc'] = 'Adres URL do webhooka przepływu pracy n8n do wysyłania danych zagrożonych studentów.';
$string['n8n_webhook_token'] = 'Token webhooka n8n';
$string['n8n_webhook_token_desc'] = 'Opcjonalny token Bearer do uwierzytelniania w webhooku n8n.';
$string['risk_max_inactive_days'] = 'Maksymalna liczba dni nieaktywności';
$string['risk_max_inactive_days_desc'] = 'Liczba dni braku aktywności, zanim wskaźnik ryzyka logowania osiągnie 100%. Domyślnie: 14 dni.';
$string['risk_weight_login'] = 'Waga: Ostatnie logowanie';
$string['risk_weight_completion'] = 'Waga: Ukończenie kursu';
$string['risk_weight_grade'] = 'Waga: Ocena z kursu';
$string['risk_weight_overdue'] = 'Waga: Zaległe aktywności';
$string['risk_weight_adaptiveplan'] = 'Waga: Zgodność z planem adaptacyjnym';
$string['risk_weight_desc'] = 'Względna waga dla tego kryterium (wartości są normalizowane do 100%). Domyślnie: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Względna waga zgodności z planem adaptacyjnym. Automatycznie redystrybuowana, jeśli mod_adaptiveplan nie jest zainstalowany. Domyślnie: 20.';
$string['risk_alert_subject'] = 'Alert o ryzyku: {$a} wymaga uwagi';
$string['risk_alert_body'] = 'Student {$a->studentname} został oznaczony jako zagrożony w kursie "{$a->coursename}" ze wskaźnikiem ryzyka {$a->riskscore}%.

Sprawdź postępy tego studenta i rozważ zaoferowanie wsparcia.

Wyświetl kokpit, aby uzyskać więcej szczegółów.';
$string['risk_alert_body_html'] = '<p><strong>Student {$a->studentname}</strong> został oznaczony jako <span style="color:#dc3545;font-weight:bold;">zagrożony</span> w kursie "<strong>{$a->coursename}</strong>" ze wskaźnikiem ryzyka <strong>{$a->riskscore}%</strong>.</p><p>Sprawdź postępy tego studenta i rozważ zaoferowanie wsparcia.</p>';
$string['risk_alert_small'] = '{$a->studentname} jest w grupie ryzyka w {$a->coursename}';
$string['risk_level_low'] = 'W normie';
$string['risk_level_medium'] = 'Do obserwacji';
$string['risk_level_high'] = 'W grupie ryzyka';
$string['risk_score'] = 'Wskaźnik ryzyka';
$string['risk_no_data'] = 'Dane o ryzyku nie są jeszcze dostępne. System oblicza wskaźniki ryzyka codziennie.';
$string['messageprovider:risk_alert'] = 'Powiadomienia o studentach zagrożonych';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Reguła ryzyka inteligentnego kokpitu';
$string['subplugintype_smartdashboardrule_plural'] = 'Reguły ryzyka inteligentnego kokpitu';

// Mobile App Support.
$string['mobile_no_data'] = 'Brak dostępnych danych. Przeciągnij w dół, aby odświeżyć.';
$string['at_risk_students'] = 'Zagrożeni studenci';
$string['risk_high'] = 'Wysokie ryzyko';
$string['risk_medium'] = 'Średnie ryzyko';
$string['risk_low'] = 'Niskie ryzyko';
$string['grading_pending'] = 'Oczekujące na ocenę';
$string['total_students'] = 'Łączna liczba studentów';
$string['total_courses'] = 'Łączna liczba kursów';
$string['due_date'] = 'Termin';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Brak dostępu';
$string['error_webhook_not_configured'] = 'Adres URL webhooka n8n nie jest skonfigurowany.';
$string['error_invalid_json'] = 'Nieprawidłowy ładunek JSON.';
$string['error_invalid_action'] = 'Nieprawidłowa akcja';
$string['error_n8n_error'] = 'Błąd n8n: {$a}';
$string['success_data_sent'] = 'Dane zostały pomyślnie wysłane do n8n!';
$string['student_count_display'] = 'Wyświetlanie liczby studentów';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Suma studentów we wszystkich kursach (uwzględnia duplikaty)';
$string['unique_students_tooltip'] = 'Liczba unikalnych studentów (bez duplikatów)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'np. Pokaż 5 kursów o najniższym wskaźniku ukończenia...';
$string['magic_ai_description'] = 'Wykorzystanie AI do tłumaczenia języka naturalnego na zapytania SQL.';
$string['show_generated_sql'] = 'Pokaż wygenerowany SQL';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Dystrybucja przychodów';
$string['chart_students_revenue_category'] = 'Studenci i przychody według kategorii';

// Student Overview strings.
$string['student_my_courses'] = 'Moje kursy';
$string['student_upcoming_deadlines'] = 'Nadchodzące terminy';
$string['student_my_grades'] = 'Moje oceny';
$string['student_overall_average'] = 'Ogólna średnia';
$string['student_complete'] = 'ukończono';
$string['student_no_deadlines'] = 'Brak nadchodzących terminów — wszystko zrobione na bieżąco!';
$string['student_no_grades'] = 'Brak dostępnych ocen.';
$string['student_no_courses'] = 'Nie jesteś zapisany na żaden kurs.';
$string['student_no_progress'] = 'Nieśledzone';
$string['student_due_soon'] = 'Za {$a} dni';
$string['student_view_course'] = 'Zobacz kurs';
$string['student_course_progress'] = 'Postęp w kursie';
$string['student_active_courses'] = 'Aktywne kursy';
$string['student_next_deadline'] = 'Najbliższy termin';
$string['student_recent_feedback'] = 'Ostatnia informacja zwrotna';
$string['student_no_feedback'] = 'Brak ostatnich informacji zwrotnych.';
$string['student_none'] = 'Brak';
$string['student_my_badges'] = 'Moje najnowsze odznaki';
$string['student_no_badges'] = 'Nie zdobyłeś jeszcze żadnych odznak. Tak trzymaj!';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Wyświetlanie raportu ocen studenta z kursu';
$string['studentgrades:viewall'] = 'Wyświetlanie raportów ocen z kursu wszystkich użytkowników';
$string['selectuser'] = 'Wybierz użytkownika';
$string['exporthtml'] = 'Eksportuj jako HTML';
$string['includedescription'] = 'Dołącz opis';
$string['nousers'] = 'Nie znaleziono użytkowników';
$string['student_nocourses'] = 'Student nie jest zapisany na żaden kurs';
$string['user'] = 'Student';
$string['reportdate'] = 'Data raportu';
$string['coursename'] = 'Kurs';
$string['gradeitem'] = 'Pozycja oceny';
$string['grade'] = 'Ocena';
$string['range'] = 'Zakres';
$string['percentage'] = 'Procent';
$string['total'] = 'Razem';
$string['coursetotal'] = 'Razem dla kursu';
$string['overallsummary'] = 'Podsumowanie ogólne';
$string['totalcourses'] = 'Łączna liczba kursów';
$string['viewmygrades'] = 'Zobacz moje oceny';
$string['exportmygrades'] = 'Eksportuj moje oceny';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Brak zawartości do wyeksportowania.';
$string['filtergrades'] = 'Filtruj oceny';
$string['allcourses'] = 'Wszystkie kursy';
$string['categorysearch'] = 'Kategoria / Szukaj';
$string['typetofilter'] = 'Wpisz, aby przefiltrować...';
$string['analyzeandemail'] = 'Przeanalizuj i wyślij mi e-mail';
$string['dailylimitreached'] = 'Osiągnięto dzienny limit. Odczekaj {$a} min., zanim wygenerujesz nową analizę.';
$string['viewanalysisnow'] = 'Wyświetl analizę teraz';
$string['generatinganalysis'] = 'Generowanie analizy...';
$string['talkingtocoreai'] = 'Łączenie z Moodle AI...';
$string['aianalysisresult'] = 'Wynik analizy AI';
$string['downloadpdf'] = 'Pobierz PDF';
$string['communicationerror'] = 'Błąd komunikacji';
$string['analysishistory'] = 'Historia analiz';
$string['defaultprompt'] = 'Jesteś edukacyjnym asystentem AI. Przeanalizuj poniższe dane dotyczące wyników studenta. Dane obejmują opisy kursów, aktywności, maksymalne oceny, oceny studenta oraz opisy zadań. Przygotuj konstruktywną analizę mocnych stron studenta oraz obszarów wymagających poprawy w oparciu o te dane.';
$string['privacy:metadata:userid'] = 'Identyfikator użytkownika.';
$string['privacy:metadata:grades'] = 'Dane o ocenach użytkownika.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Dane ocen są wysyłane do webhooka n8n w celu analizy AI.';
$string['permissiondenied'] = 'Odmowa dostępu. Jesteś zalogowany jako użytkownik o ID: {$a->currentuserid}, ale zażądano danych dla użytkownika o ID: {$a->userid}. Wymagane odpowiednie uprawnienia lub powiązane konto rodzica.';
$string['airesponsesuccessnocontent'] = 'Odpowiedź AI powiodła się, ale brak zawartości. Surowe dane: {$a}';
$string['aiprovidererror'] = 'Błąd dostawcy AI: {$a}';
$string['errorinitializingai'] = 'Błąd inicjalizacji akcji AI: {$a}';
$string['aimockresponse'] = 'Odpowiedź systemu AI: Witaj! Otrzymałem Twoją wiadomość. (Nie wykryto klas Moodle Core AI, wyświetlono odpowiedź demonstracyjną)';
$string['generalerror'] = 'Błąd: {$a}';
$string['invalidaction'] = 'Nieprawidłowa akcja';
$string['success'] = 'Sukces';
$string['unknownerror'] = 'Wystąpił nieznany błąd';
$string['aiconfigmissing'] = 'Brak konfiguracji AI (adres URL webhooka) w ustawieniach Raportu ocen studenta.';
$string['analysisrequestsent'] = 'Żądanie analizy zostało pomyślnie wysłane!';
$string['failedtosenddata'] = 'Nie udało się wysłać danych. Kod HTTP: {$a->code} Odpowiedź: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Ustawienia kolorów';
$string['colorsettingsdesc'] = 'Dostosuj kolory używane w eksportowanych raportach ocen HTML. Ustawienia te pozwalają dopasować raporty do identyfikacji wizualnej instytucji i poprawić dostępność.';
// Header Colors
$string['headerprimarycolor'] = 'Główny kolor nagłówka';
$string['headerprimarycolordesc'] = 'Główny kolor gradientu tła nagłówka raportu';
$string['headersecondarycolor'] = 'Drugi kolor nagłówka';
$string['headersecondarycolordesc'] = 'Drugorzędny kolor gradientu tła nagłówka raportu';
$string['headertextcolor'] = 'Kolor tekstu nagłówka';
$string['headertextcolordesc'] = 'Kolor tekstu w nagłówku raportu';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Kolor oceny celującej';
$string['gradeexcellentcolordesc'] = 'Kolor dla wskaźników doskonałych wyników ocen';
$string['gradegoodcolor'] = 'Kolor oceny dobrej';
$string['gradegoodcolordesc'] = 'Kolor dla wskaźników dobrych wyników ocen';
$string['gradeaveragecolor'] = 'Kolor oceny przeciętnej';
$string['gradeaveragecolordesc'] = 'Kolor dla wskaźników przeciętnych wyników ocen';
$string['gradepoorcolor'] = 'Kolor oceny niedostatecznej';
$string['gradepoorcolordesc'] = 'Kolor dla wskaźników słabych wyników ocen';
// Table Colors
$string['tablebordercolor'] = 'Kolor obramowania tabeli';
$string['tablebordercolordesc'] = 'Kolor obramowań tabeli i separatorów komórek';
$string['rowalternatecolor'] = 'Kolor naprzemiennych wierszy';
$string['rowalternatecolordesc'] = 'Kolor tła dla naprzemiennych wierszy tabeli';
$string['rowhovercolor'] = 'Kolor podświetlenia wiersza';
$string['rowhovercolordesc'] = 'Kolor tła po najechaniu kursorem na wiersze tabeli';
// Category Colors
$string['categoryprimarycolor'] = 'Główny kolor kategorii';
$string['categoryprimarycolordesc'] = 'Główny kolor gradientu tła wiersza kategorii';
$string['categorysecondarycolor'] = 'Drugi kolor kategorii';
$string['categorysecondarycolordesc'] = 'Drugorzędny kolor gradientu tła wiersza kategorii';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Główny kolor sumy kategorii';
$string['categorytotalprimarycolordesc'] = 'Główny kolor gradientu tła wiersza sumy kategorii';
$string['categorytotalsecondarycolor'] = 'Drugi kolor sumy kategorii';
$string['categorytotalsecondarycolordesc'] = 'Drugorzędny kolor gradientu tła wiersza sumy kategorii';
$string['coursetotalprimarycolor'] = 'Główny kolor sumy kursu';
$string['coursetotalprimarycolordesc'] = 'Główny kolor gradientu tła wiersza sumy kursu';
$string['coursetotalsecondarycolor'] = 'Drugi kolor sumy kursu';
$string['coursetotalsecondarycolordesc'] = 'Drugorzędny kolor gradientu tła wiersza sumy kursu';
// Grade Value Colors
$string['gradevaluecolor'] = 'Kolor tekstu wartości oceny';
$string['gradevaluecolordesc'] = 'Kolor tekstu dla wartości ocen';
$string['gradevaluebgcolor'] = 'Kolor tła wartości oceny';
$string['gradevaluebgcolordesc'] = 'Kolor tła dla komórek z wartościami ocen';
$string['percentagecolor'] = 'Kolor tekstu wartości procentowej';
$string['percentagecolordesc'] = 'Kolor tekstu dla wartości procentowych';
$string['percentagebgcolor'] = 'Kolor tła wartości procentowej';
$string['percentagebgcolordesc'] = 'Kolor tła dla komórek z wartościami procentowymi';
// AI Settings
$string['aisettings'] = 'Ustawienia analizy AI';
$string['aisettingsdesc'] = 'Skonfiguruj integrację z zewnętrznymi usługami AI za pośrednictwem n8n.';
$string['enableemailanalysis'] = 'Włącz analizę przez e-mail';
$string['enableemailanalysisdesc'] = 'Zezwól użytkownikom na zamawianie raportu z analizy wysyłanego na ich adres e-mail.';
$string['enableinstantanalysis'] = 'Włącz natychmiastową analizę';
$string['enableinstantanalysisdesc'] = 'Zezwól użytkownikom na natychmiastowe przeglądanie raportu analizy w oknie modalnym.';
$string['webhookurl'] = 'Adres URL webhooka n8n';
$string['webhookurldesc'] = 'Adres URL webhooka n8n, który będzie przetwarzać dane ocen studenta.';
$string['token'] = 'Token webhooka n8n';
$string['tokendesc'] = 'Bezpieczny token do uwierzytelniania w webhooku n8n (wysyłany w nagłówkach).';
$string['aiprompt'] = 'Zapytanie analizy AI';
$string['aipromptdesc'] = 'Zapytanie wysyłane do AI wraz z danymi studenta. Dostosuj je, aby zmienić ton lub cel analizy.';
$string['aicooldown'] = 'Czas oczekiwania między analizami (w minutach)';
$string['aicooldowndesc'] = 'Minimalny czas w minutach między żądaniami analizy w celu oszczędzania zasobów. Ustaw 0, aby wyłączyć.';
// Reset Information
$string['resetcolorsheading'] = 'Zresetuj kolory';
$string['resetcolorsdesc'] = 'Aby przywrócić domyślne wartości wszystkich kolorów, wyczyść każde pole koloru i zapisz ustawienia. Wtyczka automatycznie zastosuje domyślny schemat kolorów.';

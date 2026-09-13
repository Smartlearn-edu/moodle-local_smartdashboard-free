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
 * Indonesian language strings for Smart Dashboard.
 *
 * @package     local_smartdashboard
 * @copyright   2026 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Dasbor Cerdas';
$string['smartdashboard:view'] = 'Lihat Dasbor Cerdas';
$string['mycourses'] = 'Kursus Saya';
$string['nocourses'] = 'Anda belum mengajar kursus apa pun.';
$string['gotocourse'] = 'Buka Kursus';
$string['students'] = 'siswa';
$string['enrollments'] = 'Pendaftaran';
$string['activities'] = 'Aktivitas';
$string['needsgrading'] = 'Pengajuan yang perlu dinilai';
$string['section_overview'] = 'Ringkasan';
$string['section_grading'] = 'Penilaian';
$string['section_progress'] = 'Kemajuan Siswa';
$string['section_analytics'] = 'Analitik';
$string['section_settings'] = 'Pengaturan';

// Student Dashboard Settings.
$string['student_icons_heading'] = 'Ikon Dasbor Siswa';
$string['student_icons_desc'] = 'Konfigurasikan ikon yang ditampilkan pada banner selamat datang di dasbor siswa.';
$string['icon_heading'] = 'Ikon {$a}';
$string['icon_name'] = 'Nama Ikon';
$string['icon_class'] = 'Kelas Ikon (FontAwesome)';
$string['icon_class_desc'] = 'cth. "fa-book", "fa-graduation-cap"';
$string['icon_url'] = 'URL Tautan';
$string['welcomebackstudent'] = 'Selamat datang kembali, {$a}!';
$string['privacy:metadata'] = 'Plugin Dasbor Cerdas tidak menyimpan data pribadi apa pun.';

// Dashboard Replacement Settings.
$string['redirect_heading'] = 'Penggantian Dasbor';
$string['redirect_desc'] = 'Konfigurasikan apakah Dasbor Cerdas menggantikan dasbor bawaan Moodle untuk peran tertentu.';
$string['enabledirect'] = 'Aktifkan Penggantian Dasbor';
$string['enabledirect_desc'] = 'Jika diaktifkan, pengguna dengan peran yang dipilih yang mengunjungi dasbor bawaan akan dialihkan ke sini.';
$string['redirectroles'] = 'Peran yang Dialihkan';
$string['redirectroles_desc'] = 'Pilih peran yang harus dialihkan ke Dasbor Cerdas. Pengguna dengan SALAH SATU peran ini dalam konteks APA PUN akan terpengaruh.';
$string['redirectadmins'] = 'Alihkan Administrator Situs';
$string['redirectadmins_desc'] = 'Apakah Administrator Situs juga harus dialihkan?';

// Appearance Settings.
$string['appearance_heading'] = 'Tampilan';
$string['appearance_desc'] = 'Sesuaikan tampilan visual Dasbor Cerdas.';
$string['thememode'] = 'Mode Warna';
$string['thememode_desc'] = 'Pilih mode warna untuk dasbor. Gunakan "Terang" jika tema Moodle Anda berlatar belakang terang, atau "Gelap" untuk situs bertema gelap.';
$string['thememode_dark'] = 'Mode Gelap';
$string['thememode_light'] = 'Mode Terang';
$string['todays_agenda'] = 'Agenda Hari Ini';
$string['payment_calc_mode'] = 'Mode Perhitungan Pembayaran';
$string['payment_calc_mode_desc'] = 'Pilih cara analitik pembayaran menghitung pendapatan dan jumlah siswa.';
$string['save_settings'] = 'Simpan Pengaturan';
$string['latest_announcements'] = 'Pengumuman Terbaru';
$string['dont_show_again'] = 'Jangan tampilkan ini lagi';
$string['close'] = 'Tutup';
$string['magic_reports_title'] = 'Laporan Ajaib (Analisis AI)';
$string['magic_reports_desc'] = 'Ajukan pertanyaan tentang data Anda dalam bahasa sehari-hari, dan AI akan menghasilkan laporan untuk Anda.';
$string['saved_reports'] = 'Laporan Tersimpan';
$string['loading'] = 'Memuat...';
$string['ask_a_question'] = 'Ajukan pertanyaan';
$string['generate'] = 'Hasilkan';
$string['result'] = 'Hasil';
$string['save_report'] = 'Simpan Laporan';
$string['assignments_needing_grading'] = 'Tugas yang Perlu Dinilai';
$string['student_welcome_sub'] = 'Berikut adalah kemajuan dan sumber belajar Anda.';
$string['welcome_back'] = 'Selamat datang kembali!';
$string['teacher_welcome_sub'] = 'Berikut adalah kursus yang Anda ajar. Pantau kemajuan siswa, penilaian, dan wawasan keterlibatan.';
$string['parent_welcome_sub'] = 'Di sini Anda dapat memantau kemajuan dan aktivitas bimbingan Anda.';
$string['parent_mentees_title'] = 'Bimbingan Anda';
$string['parent_overall_performance'] = 'Kinerja Keseluruhan';
$string['parent_upcoming_deadlines'] = 'Tenggat Waktu Mendatang';
$string['parent_recent_results'] = 'Hasil Terbaru';
$string['parent_no_data'] = 'Tidak ada data yang tersedia';
$string['parent_view_calendar'] = 'Lihat Kalender';
$string['parent_average_grade'] = 'Nilai Rata-rata';
$string['saving'] = 'Menyimpan...';
$string['filter_by_cat'] = 'Filter berdasarkan Kategori';
$string['select_category'] = 'Pilih kategori...';
$string['show_courses'] = 'Tampilkan Kursus';
$string['total_enrollments'] = 'Total Pendaftaran';
$string['direct_sum'] = 'Jumlah Langsung';
$string['unique_students'] = 'Siswa Unik';
$string['subcategories'] = 'Subkategori';
$string['courses'] = 'Kursus';
$string['select_category_to_view'] = 'Silakan pilih kategori dan klik "Tampilkan Kursus" untuk melihat data.';
$string['select_category_to_filter'] = 'Pilih kategori tertentu untuk memfilter hasil.';
$string['no_courses_found'] = 'Tidak ditemukan kursus yang cocok dengan pilihan Anda.';
$string['dashboard'] = 'Dasbor';
$string['overview'] = 'Ringkasan';
$string['risk'] = 'Detail Risiko';
$string['detailed'] = 'Terperinci';
$string['grades_overview'] = 'Ringkasan Nilai';
$string['payments'] = 'Pembayaran';
$string['magic_reports'] = 'Laporan Ajaib';
$string['payment_analytics'] = 'Analitik Pembayaran';
$string['time_range'] = 'Rentang Waktu';
$string['all_time'] = 'Sepanjang Waktu';
$string['today'] = 'Hari Ini';
$string['past_7_days'] = '7 Hari Terakhir';
$string['past_30_days'] = '30 Hari Terakhir';
$string['past_year'] = 'Tahun Terakhir';
$string['custom_range'] = 'Rentang Kustom';
$string['from'] = 'Dari';
$string['to'] = 'Sampai';
$string['category'] = 'Kategori';
$string['system_analytics'] = 'Analitik Sistem';
$string['student_grades_will_appear'] = 'Nilai siswa akan muncul di sini.';
$string['no_pending_tasks'] = 'Anda tidak memiliki tugas tertunda atau rencana belajar adaptif untuk hari ini.';
$string['caught_up'] = 'Semua tugas Anda sudah selesai!';
$string['due_today'] = 'Jatuh Tempo Hari Ini';
$string['go_to_course'] = 'Buka Kursus';
$string['role_student'] = 'Siswa';
$string['role_teacher'] = 'Pengajar';
$string['role_parent'] = 'Orang Tua';
$string['parent_terminology'] = 'Terminologi Orang Tua';
$string['parent_terminology_desc'] = 'Pilih istilah yang digunakan untuk menggambarkan peran Orang Tua/Mentor di dasbor.';
$string['term_parent'] = 'Orang Tua';
$string['term_mentor'] = 'Mentor';
$string['term_partner'] = 'Mitra';
$string['term_supervisor'] = 'Pengawas Akademik';
$string['term_guardian'] = 'Wali';
$string['term_sponsor'] = 'Sponsor';

// Privacy API Strings — Reports table.
$string['privacy:metadata:reports'] = 'Laporan kustom tersimpan yang dihasilkan oleh AI yang dibuat oleh pengguna.';
$string['privacy:metadata:reports:userid'] = 'Pengguna yang membuat laporan.';
$string['privacy:metadata:reports:title'] = 'Nama laporan yang disimpan.';
$string['privacy:metadata:reports:description'] = 'Deskripsi opsional atau prompt AI asli.';
$string['privacy:metadata:reports:sql_query'] = 'Kueri SQL yang dihasilkan untuk laporan.';
$string['privacy:metadata:reports:timecreated'] = 'Waktu laporan dibuat.';
$string['privacy:metadata:reports:timemodified'] = 'Waktu laporan terakhir diubah.';
$string['privacy:metadata:preference:dismissed_announcements'] = 'Menyimpan ID pengumuman dasbor yang telah ditutup oleh pengguna.';

// Privacy API Strings — Risk table.
$string['privacy:metadata:risk'] = 'Snapshot skor siswa berisiko yang dihitung setiap hari oleh mesin risiko.';
$string['privacy:metadata:risk:userid'] = 'Siswa yang risikonya dievaluasi.';
$string['privacy:metadata:risk:courseid'] = 'Konteks kursus untuk evaluasi risiko.';
$string['privacy:metadata:risk:riskscore'] = 'Skor risiko yang dihitung (0-100).';
$string['privacy:metadata:risk:risklevel'] = 'Klasifikasi risiko (rendah, sedang, atau tinggi).';
$string['privacy:metadata:risk:timecreated'] = 'Waktu snapshot risiko dihitung.';

// Privacy API Strings — n8n external data link.
$string['privacy:metadata:n8n'] = 'Data siswa berisiko dapat dikirim ke webhook alur kerja n8n eksternal yang dikonfigurasikan oleh administrator.';
$string['privacy:metadata:n8n:userid'] = 'ID pengguna dari siswa yang berisiko.';
$string['privacy:metadata:n8n:courseid'] = 'ID kursus yang terkait dengan peringatan risiko.';
$string['privacy:metadata:n8n:riskscore'] = 'Skor risiko yang dikirim ke webhook eksternal.';

// Privacy API Strings — AI Grades table.
$string['privacy:metadata:ai_grades'] = 'Riwayat analisis AI dan umpan balik untuk nilai siswa.';
$string['privacy:metadata:ai_grades:userid'] = 'Siswa yang nilainya dianalisis.';
$string['privacy:metadata:ai_grades:report_html'] = 'HTML umpan balik dan rekomendasi yang dihasilkan oleh AI.';
$string['privacy:metadata:ai_grades:timecreated'] = 'Stempel waktu saat analisis dibuat.';

// At-Risk Student Alert System.
$string['task_calculate_risk'] = 'Hitung skor siswa berisiko';
$string['risk_heading'] = 'Peringatan Siswa Berisiko';
$string['risk_heading_desc'] = 'Konfigurasikan sistem peringatan dini siswa berisiko. Mesin risiko berjalan setiap hari dan memberi skor pada setiap siswa berdasarkan kriteria berbobot di bawah ini. Pengajar secara otomatis diberi tahu ketika seorang siswa menjadi berisiko tinggi.';
$string['n8n_webhook_url'] = 'URL Webhook n8n';
$string['n8n_webhook_url_desc'] = 'URL ke webhook alur kerja n8n Anda untuk mengirimkan data siswa berisiko.';
$string['n8n_webhook_token'] = 'Token Webhook n8n';
$string['n8n_webhook_token_desc'] = 'Token Bearer opsional untuk autentikasi dengan webhook n8n Anda.';
$string['risk_max_inactive_days'] = 'Hari tidak aktif maksimal';
$string['risk_max_inactive_days_desc'] = 'Jumlah hari tidak aktif sebelum skor risiko login mencapai 100%. Standar: 14 hari.';
$string['risk_weight_login'] = 'Bobot: Keterbaruan login';
$string['risk_weight_completion'] = 'Bobot: Penyelesaian kursus';
$string['risk_weight_grade'] = 'Bobot: Nilai kursus';
$string['risk_weight_overdue'] = 'Bobot: Aktivitas terlambat';
$string['risk_weight_adaptiveplan'] = 'Bobot: Kepatuhan rencana adaptif';
$string['risk_weight_desc'] = 'Bobot relatif untuk kriteria ini (nilai dinormalisasi menjadi 100%). Standar: 20.';
$string['risk_weight_adaptiveplan_desc'] = 'Bobot relatif untuk kepatuhan rencana adaptif. Didistribusikan ulang secara otomatis jika mod_adaptiveplan tidak diinstal. Standar: 20.';
$string['risk_alert_subject'] = 'Peringatan Berisiko: {$a} membutuhkan perhatian';
$string['risk_alert_body'] = 'Siswa {$a->studentname} telah ditandai sebagai berisiko dalam kursus "{$a->coursename}" dengan skor risiko {$a->riskscore}%.

Silakan periksa kemajuan siswa ini dan pertimbangkan untuk menghubunginya guna memberikan bantuan.

Lihat dasbor untuk detail lebih lanjut.';
$string['risk_alert_body_html'] = '<p><strong>Siswa {$a->studentname}</strong> telah ditandai sebagai <span style="color:#dc3545;font-weight:bold;">berisiko</span> dalam kursus "<strong>{$a->coursename}</strong>" dengan skor risiko <strong>{$a->riskscore}%</strong>.</p><p>Silakan periksa kemajuan siswa ini dan pertimbangkan untuk menghubunginya guna memberikan bantuan.</p>';
$string['risk_alert_small'] = '{$a->studentname} berisiko di {$a->coursename}';
$string['risk_level_low'] = 'Sesuai Jalur';
$string['risk_level_medium'] = 'Perlu Dipantau';
$string['risk_level_high'] = 'Berisiko';
$string['risk_score'] = 'Skor Risiko';
$string['risk_no_data'] = 'Data risiko belum tersedia. Sistem menghitung skor risiko setiap hari.';
$string['messageprovider:risk_alert'] = 'Pemberitahuan siswa berisiko';

// Subplugin definition strings
$string['subplugintype_smartdashboardrule'] = 'Aturan Risiko Dasbor Cerdas';
$string['subplugintype_smartdashboardrule_plural'] = 'Aturan-aturan Risiko Dasbor Cerdas';

// Mobile App Support.
$string['mobile_no_data'] = 'Tidak ada data yang tersedia. Tarik ke bawah untuk memuat ulang.';
$string['at_risk_students'] = 'Siswa Berisiko';
$string['risk_high'] = 'Risiko Tinggi';
$string['risk_medium'] = 'Risiko Sedang';
$string['risk_low'] = 'Risiko Rendah';
$string['grading_pending'] = 'Menunggu Penilaian';
$string['total_students'] = 'Total Siswa';
$string['total_courses'] = 'Total Kursus';
$string['due_date'] = 'Batas Waktu';

// Error messages (Issue 8: replacing hard-coded strings).
$string['error_access_denied'] = 'Akses ditolak';
$string['error_webhook_not_configured'] = 'URL Webhook n8n belum dikonfigurasi.';
$string['error_invalid_json'] = 'Muatan JSON tidak valid.';
$string['error_invalid_action'] = 'Tindakan tidak valid';
$string['error_n8n_error'] = 'Kesalahan n8n: {$a}';
$string['success_data_sent'] = 'Data berhasil dikirim ke n8n!';
$string['student_count_display'] = 'Tampilan jumlah siswa';

// Strings for overview tooltips.
$string['direct_sum_tooltip'] = 'Jumlah siswa di semua kursus (termasuk duplikat)';
$string['unique_students_tooltip'] = 'Jumlah siswa unik (tanpa duplikat)';

// Strings for magic reports.
$string['magic_prompt_placeholder'] = 'cth. Tampilkan 5 kursus dengan tingkat penyelesaian terendah...';
$string['magic_ai_description'] = 'Menggunakan AI untuk menerjemahkan bahasa alami ke dalam kueri SQL.';
$string['show_generated_sql'] = 'Tampilkan SQL yang dihasilkan';

// Chart title strings for payment analytics.
$string['chart_revenue_distribution'] = 'Distribusi Pendapatan';
$string['chart_students_revenue_category'] = 'Siswa & Pendapatan per Kategori';

// Student Overview strings.
$string['student_my_courses'] = 'Kursus Saya';
$string['student_upcoming_deadlines'] = 'Tenggat Waktu Mendatang';
$string['student_my_grades'] = 'Nilai Saya';
$string['student_overall_average'] = 'Rata-rata Keseluruhan';
$string['student_complete'] = 'selesai';
$string['student_no_deadlines'] = 'Tidak ada tenggat waktu mendatang — semua tugas Anda telah selesai!';
$string['student_no_grades'] = 'Belum ada nilai yang tersedia.';
$string['student_no_courses'] = 'Anda belum terdaftar dalam kursus apa pun.';
$string['student_no_progress'] = 'Tidak dilacak';
$string['student_due_soon'] = 'Dalam {$a} hari';
$string['student_view_course'] = 'Lihat Kursus';
$string['student_course_progress'] = 'Kemajuan Kursus';
$string['student_active_courses'] = 'Kursus Aktif';
$string['student_next_deadline'] = 'Tenggat Waktu Berikutnya';
$string['student_recent_feedback'] = 'Umpan Balik Terbaru';
$string['student_no_feedback'] = 'Belum ada umpan balik terbaru yang tersedia.';
$string['student_none'] = 'Tidak ada';
$string['student_my_badges'] = 'Lencana Terbaru Saya';
$string['student_no_badges'] = 'Anda belum mendapatkan lencana apa pun. Teruslah berusaha!';

// Strings ported from report_studentgrades.
$string['studentgrades:view'] = 'Lihat laporan nilai kursus siswa';
$string['studentgrades:viewall'] = 'Lihat laporan nilai kursus semua pengguna';
$string['selectuser'] = 'Pilih pengguna';
$string['exporthtml'] = 'Ekspor sebagai HTML';
$string['includedescription'] = 'Sertakan Deskripsi';
$string['nousers'] = 'Pengguna tidak ditemukan';
$string['student_nocourses'] = 'Siswa tidak terdaftar dalam kursus apa pun';
$string['user'] = 'Siswa';
$string['reportdate'] = 'Tanggal laporan';
$string['coursename'] = 'Kursus';
$string['gradeitem'] = 'Item penilaian';
$string['grade'] = 'Nilai';
$string['range'] = 'Rentang';
$string['percentage'] = 'Persentase';
$string['total'] = 'Total';
$string['coursetotal'] = 'Total Kursus';
$string['overallsummary'] = 'Ringkasan Keseluruhan';
$string['totalcourses'] = 'Total Kursus';
$string['viewmygrades'] = 'Lihat Nilai Saya';
$string['exportmygrades'] = 'Ekspor Nilai Saya';
// Added for marketplace compliance
$string['nocontenttoexport'] = 'Tidak ada konten untuk diekspor.';
$string['filtergrades'] = 'Filter Nilai';
$string['allcourses'] = 'Semua Kursus';
$string['categorysearch'] = 'Kategori / Cari';
$string['typetofilter'] = 'Ketik untuk memfilter...';
$string['analyzeandemail'] = 'Analisis & Kirim Email ke Saya';
$string['dailylimitreached'] = 'Batas harian tercapai. Harap tunggu {$a} menit sebelum membuat analisis baru.';
$string['viewanalysisnow'] = 'Lihat Analisis Sekarang';
$string['generatinganalysis'] = 'Menghasilkan Analisis...';
$string['talkingtocoreai'] = 'Menghubungi AI Moodle...';
$string['aianalysisresult'] = 'Hasil Analisis AI';
$string['downloadpdf'] = 'Unduh PDF';
$string['communicationerror'] = 'Kesalahan Komunikasi';
$string['analysishistory'] = 'Riwayat Analisis';
$string['defaultprompt'] = 'Anda adalah asisten AI pendidikan. Analisis data kinerja siswa berikut ini. Data tersebut mencakup deskripsi kursus, aktivitas, nilai maksimal, nilai siswa, dan deskripsi aktivitas. Berikan analisis konstruktif mengenai kekuatan dan area perbaikan siswa berdasarkan data ini.';
$string['privacy:metadata:userid'] = 'ID pengguna.';
$string['privacy:metadata:grades'] = 'Data nilai pengguna.';
$string['privacy:metadata:n8n_webhook_summary'] = 'Data nilai dikirim ke webhook n8n untuk analisis AI.';
$string['permissiondenied'] = 'Izin Ditolak. Anda masuk sebagai ID Pengguna: {$a->currentuserid} tetapi meminta data untuk ID Pengguna: {$a->userid}. Diperlukan izin yang sesuai atau akun orang tua yang terhubung.';
$string['airesponsesuccessnocontent'] = 'Respons AI berhasil tetapi tidak ada konten. Data mentah: {$a}';
$string['aiprovidererror'] = 'Kesalahan Penyedia AI: {$a}';
$string['errorinitializingai'] = 'Kesalahan saat menginisialisasi tindakan AI: {$a}';
$string['aimockresponse'] = 'Respons Sistem AI: Halo! Saya telah menerima pesan Anda. (Kelas AI Moodle Core tidak terdeteksi, menampilkan respons simulasi)';
$string['generalerror'] = 'Kesalahan: {$a}';
$string['invalidaction'] = 'Tindakan tidak valid';
$string['success'] = 'Berhasil';
$string['unknownerror'] = 'Terjadi kesalahan yang tidak diketahui';
$string['aiconfigmissing'] = 'Konfigurasi AI (URL Webhook) tidak ditemukan dalam pengaturan Laporan Nilai Siswa.';
$string['analysisrequestsent'] = 'Permintaan analisis berhasil dikirim!';
$string['failedtosenddata'] = 'Gagal mengirim data. Kode HTTP: {$a->code} Respons: {$a->response}';
// Color Settings
$string['colorsettings'] = 'Pengaturan Warna';
$string['colorsettingsdesc'] = 'Sesuaikan warna yang digunakan dalam laporan nilai ekspor HTML. Pengaturan ini memungkinkan Anda menyesuaikan dengan merek institusi Anda dan meningkatkan aksesibilitas visual.';
// Header Colors
$string['headerprimarycolor'] = 'Warna Utama Header';
$string['headerprimarycolordesc'] = 'Warna utama untuk latar belakang gradien header laporan';
$string['headersecondarycolor'] = 'Warna Sekunder Header';
$string['headersecondarycolordesc'] = 'Warna sekunder untuk latar belakang gradien header laporan';
$string['headertextcolor'] = 'Warna Teks Header';
$string['headertextcolordesc'] = 'Warna teks untuk header laporan';
// Grade Performance Colors
$string['gradeexcellentcolor'] = 'Warna Nilai Sangat Baik';
$string['gradeexcellentcolordesc'] = 'Warna untuk indikator kinerja nilai sangat baik';
$string['gradegoodcolor'] = 'Warna Nilai Baik';
$string['gradegoodcolordesc'] = 'Warna untuk indikator kinerja nilai baik';
$string['gradeaveragecolor'] = 'Warna Nilai Cukup';
$string['gradeaveragecolordesc'] = 'Warna untuk indikator kinerja nilai rata-rata/cukup';
$string['gradepoorcolor'] = 'Warna Nilai Kurang';
$string['gradepoorcolordesc'] = 'Warna untuk indikator kinerja nilai kurang';
// Table Colors
$string['tablebordercolor'] = 'Warna Batas Tabel';
$string['tablebordercolordesc'] = 'Warna untuk batas tabel dan pemisah sel';
$string['rowalternatecolor'] = 'Warna Baris Selang-Seling';
$string['rowalternatecolordesc'] = 'Warna latar belakang untuk baris tabel yang berselang-seling';
$string['rowhovercolor'] = 'Warna Baris Saat Disorot';
$string['rowhovercolordesc'] = 'Warna latar belakang saat mengarahkan kursor ke atas baris tabel';
// Category Colors
$string['categoryprimarycolor'] = 'Warna Utama Kategori';
$string['categoryprimarycolordesc'] = 'Warna utama untuk latar belakang gradien baris kategori';
$string['categorysecondarycolor'] = 'Warna Sekunder Kategori';
$string['categorysecondarycolordesc'] = 'Warna sekunder untuk latar belakang gradien baris kategori';
// Total Row Colors
$string['categorytotalprimarycolor'] = 'Warna Utama Total Kategori';
$string['categorytotalprimarycolordesc'] = 'Warna utama untuk latar belakang gradien baris total kategori';
$string['categorytotalsecondarycolor'] = 'Warna Sekunder Total Kategori';
$string['categorytotalsecondarycolordesc'] = 'Warna sekunder untuk latar belakang gradien baris total kategori';
$string['coursetotalprimarycolor'] = 'Warna Utama Total Kursus';
$string['coursetotalprimarycolordesc'] = 'Warna utama untuk latar belakang gradien baris total kursus';
$string['coursetotalsecondarycolor'] = 'Warna Sekunder Total Kursus';
$string['coursetotalsecondarycolordesc'] = 'Warna sekunder untuk latar belakang gradien baris total kursus';
// Grade Value Colors
$string['gradevaluecolor'] = 'Warna Teks Nilai Angka';
$string['gradevaluecolordesc'] = 'Warna teks untuk nilai angka';
$string['gradevaluebgcolor'] = 'Warna Latar Belakang Nilai Angka';
$string['gradevaluebgcolordesc'] = 'Warna latar belakang untuk sel nilai angka';
$string['percentagecolor'] = 'Warna Teks Persentase';
$string['percentagecolordesc'] = 'Warna teks untuk nilai persentase';
$string['percentagebgcolor'] = 'Warna Latar Belakang Persentase';
$string['percentagebgcolordesc'] = 'Warna latar belakang untuk sel persentase';
// AI Settings
$string['aisettings'] = 'Pengaturan Analisis AI';
$string['aisettingsdesc'] = 'Konfigurasikan integrasi dengan layanan AI eksternal melalui n8n.';
$string['enableemailanalysis'] = 'Aktifkan Analisis melalui Email';
$string['enableemailanalysisdesc'] = 'Izinkan pengguna meminta laporan analisis dikirimkan ke email mereka.';
$string['enableinstantanalysis'] = 'Aktifkan Analisis Instan';
$string['enableinstantanalysisdesc'] = 'Izinkan pengguna melihat laporan analisis secara instan di jendela modal.';
$string['webhookurl'] = 'URL Webhook n8n';
$string['webhookurldesc'] = 'URL webhook n8n yang akan memproses data nilai siswa.';
$string['token'] = 'Token Webhook n8n';
$string['tokendesc'] = 'Token aman untuk autentikasi dengan webhook n8n (dikirim dalam header).';
$string['aiprompt'] = 'Prompt Analisis AI';
$string['aipromptdesc'] = 'Prompt yang dikirim ke AI bersama dengan data siswa. Sesuaikan ini untuk mengubah nada atau fokus analisis.';
$string['aicooldown'] = 'Jeda Waktu Analisis (Menit)';
$string['aicooldowndesc'] = 'Waktu minimum dalam hitungan menit antara permintaan analisis untuk penghematan data penting. Atur ke 0 untuk menonaktifkan.';
// Reset Information
$string['resetcolorsheading'] = 'Atur Ulang Warna';
$string['resetcolorsdesc'] = 'Untuk mengatur ulang semua warna ke nilai standarnya, kosongkan setiap bidang warna dan simpan pengaturan. Plugin akan secara otomatis menggunakan skema warna default.';

-- =====================================================
-- INSERT DATA MASTER
-- Database: db_insurance_dashboard
-- =====================================================

USE db_insurance_dashboard;

-- =====================================================
-- MASTER ROLES
-- =====================================================

INSERT INTO roles (kode_role, nama_role, deskripsi, created_by) VALUES
('ADMIN', 'Administrator', 'Full access ke semua fitur sistem', 1),
('INTERNAL', 'Petugas Internal Asuransi', 'Dapat melakukan survey TKP dan Ahli Waris', 1),
('RS', 'Petugas Rumah Sakit', 'Input data korban dari rumah sakit', 1),
('PEJABAT', 'Pejabat Tinggi', 'Read-only access untuk dashboard dan laporan', 1);

-- =====================================================
-- MASTER PERMISSIONS
-- =====================================================

INSERT INTO permissions (kode_permission, nama_permission, modul, aksi, deskripsi) VALUES
-- Dashboard
('DASHBOARD_VIEW', 'Lihat Dashboard', 'Dashboard', 'Read', 'Akses ke halaman dashboard'),
('DASHBOARD_EXPORT', 'Export Dashboard', 'Dashboard', 'Export', 'Export data dashboard ke Excel'),

-- Kasus Kecelakaan
('KASUS_CREATE', 'Tambah Kasus', 'Kasus', 'Create', 'Membuat kasus kecelakaan baru'),
('KASUS_READ', 'Lihat Kasus', 'Kasus', 'Read', 'Melihat detail kasus'),
('KASUS_UPDATE', 'Edit Kasus', 'Kasus', 'Update', 'Mengubah data kasus'),
('KASUS_DELETE', 'Hapus Kasus', 'Kasus', 'Delete', 'Menghapus kasus'),

-- Korban
('KORBAN_CREATE', 'Tambah Korban', 'Korban', 'Create', 'Input data korban dari RS'),
('KORBAN_READ', 'Lihat Korban', 'Korban', 'Read', 'Melihat data korban'),
('KORBAN_UPDATE', 'Edit Korban', 'Korban', 'Update', 'Mengubah data korban'),
('KORBAN_DELETE', 'Hapus Korban', 'Korban', 'Delete', 'Menghapus data korban'),

-- Survey TKP
('SURVEY_TKP_CREATE', 'Buat Survey TKP', 'Survey', 'Create', 'Membuat survey TKP'),
('SURVEY_TKP_READ', 'Lihat Survey TKP', 'Survey', 'Read', 'Melihat hasil survey TKP'),
('SURVEY_TKP_UPDATE', 'Edit Survey TKP', 'Survey', 'Update', 'Mengubah survey TKP'),

-- Survey Ahli Waris
('SURVEY_AW_CREATE', 'Buat Survey Ahli Waris', 'Survey', 'Create', 'Membuat survey ahli waris'),
('SURVEY_AW_READ', 'Lihat Survey Ahli Waris', 'Survey', 'Read', 'Melihat hasil survey ahli waris'),
('SURVEY_AW_UPDATE', 'Edit Survey Ahli Waris', 'Survey', 'Update', 'Mengubah survey ahli waris'),

-- Laporan
('LAPORAN_VIEW', 'Lihat Laporan', 'Laporan', 'Read', 'Melihat berbagai laporan'),
('LAPORAN_EXPORT', 'Export Laporan', 'Laporan', 'Export', 'Export laporan ke Excel/PDF'),

-- Master Data
('MASTER_MANAGE', 'Kelola Master Data', 'Master', 'All', 'CRUD master data'),

-- User Management
('USER_MANAGE', 'Kelola User', 'User', 'All', 'CRUD user dan permission');

-- =====================================================
-- ROLE PERMISSIONS MAPPING
-- =====================================================

-- Admin: Full Access
INSERT INTO role_permissions (role_id, permission_id, created_by)
SELECT 1, id, 1 FROM permissions;

-- Petugas Internal: Survey + View
INSERT INTO role_permissions (role_id, permission_id, created_by)
SELECT 2, id, 1 FROM permissions 
WHERE kode_permission IN (
    'DASHBOARD_VIEW', 'DASHBOARD_EXPORT',
    'KASUS_READ', 'KORBAN_READ', 'KORBAN_UPDATE',
    'SURVEY_TKP_CREATE', 'SURVEY_TKP_READ', 'SURVEY_TKP_UPDATE',
    'SURVEY_AW_CREATE', 'SURVEY_AW_READ', 'SURVEY_AW_UPDATE',
    'LAPORAN_VIEW', 'LAPORAN_EXPORT'
);

-- Petugas RS: Input Korban Only
INSERT INTO role_permissions (role_id, permission_id, created_by)
SELECT 3, id, 1 FROM permissions 
WHERE kode_permission IN (
    'DASHBOARD_VIEW',
    'KASUS_READ',
    'KORBAN_CREATE', 'KORBAN_READ', 'KORBAN_UPDATE'
);

-- Pejabat: Read Only
INSERT INTO role_permissions (role_id, permission_id, created_by)
SELECT 4, id, 1 FROM permissions 
WHERE kode_permission IN (
    'DASHBOARD_VIEW', 'DASHBOARD_EXPORT',
    'KASUS_READ', 'KORBAN_READ',
    'SURVEY_TKP_READ', 'SURVEY_AW_READ',
    'LAPORAN_VIEW', 'LAPORAN_EXPORT'
);

-- =====================================================
-- MASTER PROVINSI (Contoh Data DKI Jakarta & Sekitarnya)
-- =====================================================

INSERT INTO master_provinsi (kode_provinsi, nama_provinsi, created_by) VALUES
('31', 'DKI Jakarta', 1),
('32', 'Jawa Barat', 1),
('33', 'Jawa Tengah', 1),
('35', 'Jawa Timur', 1),
('36', 'Banten', 1);

-- =====================================================
-- MASTER KABUPATEN/KOTA (Contoh DKI Jakarta)
-- =====================================================

INSERT INTO master_kabupaten_kota (provinsi_id, kode_kabkota, nama_kabkota, jenis, created_by) VALUES
-- DKI Jakarta
(1, '3171', 'Jakarta Selatan', 'Kota', 1),
(1, '3172', 'Jakarta Timur', 'Kota', 1),
(1, '3173', 'Jakarta Pusat', 'Kota', 1),
(1, '3174', 'Jakarta Barat', 'Kota', 1),
(1, '3175', 'Jakarta Utara', 'Kota', 1),
(1, '3176', 'Kepulauan Seribu', 'Kabupaten', 1);

-- =====================================================
-- MASTER KECAMATAN (Contoh Jakarta Pusat)
-- =====================================================

INSERT INTO master_kecamatan (kabkota_id, kode_kecamatan, nama_kecamatan, created_by) VALUES
-- Jakarta Pusat
(3, '3173010', 'Gambir', 1),
(3, '3173020', 'Tanah Abang', 1),
(3, '3173030', 'Menteng', 1),
(3, '3173040', 'Senen', 1),
(3, '3173050', 'Cempaka Putih', 1),
(3, '3173060', 'Johar Baru', 1),
(3, '3173070', 'Kemayoran', 1),
(3, '3173080', 'Sawah Besar', 1);

-- =====================================================
-- MASTER KELURAHAN (Contoh Kemayoran & Sawah Besar)
-- =====================================================

INSERT INTO master_kelurahan (kecamatan_id, kode_kelurahan, nama_kelurahan, created_by) VALUES
-- Kemayoran
(7, '3173070001', 'Gunung Sahari Selatan', 1),
(7, '3173070002', 'Kemayoran', 1),
(7, '3173070003', 'Kebon Kosong', 1),
(7, '3173070004', 'Harapan Mulia', 1),
(7, '3173070005', 'Cempaka Baru', 1),
(7, '3173070006', 'Sumur Batu', 1),
(7, '3173070007', 'Serdang', 1),
(7, '3173070008', 'Utan Panjang', 1),
-- Sawah Besar
(8, '3173080001', 'Pasar Baru', 1),
(8, '3173080002', 'Karang Anyar', 1),
(8, '3173080003', 'Kartini', 1),
(8, '3173080004', 'Gunung Sahari Utara', 1),
(8, '3173080005', 'Mangga Dua Selatan', 1);

-- =====================================================
-- MASTER LOKET
-- =====================================================

-- Level 1: Kanwil
INSERT INTO master_loket (parent_id, kode_loket, nama_loket, kategori, level, created_by) VALUES
(NULL, 'KANWIL-JKT', 'Kantor Wilayah Jakarta', 'Kanwil', 1, 1);

-- Level 2: Wilayah (under Kanwil)
INSERT INTO master_loket (parent_id, kode_loket, nama_loket, kategori, level, created_by) VALUES
(1, 'WIL-JKTPST', 'Wilayah Jakarta Pusat', 'Wilayah', 2, 1),
(1, 'WIL-JKTUT', 'Wilayah Jakarta Utara', 'Wilayah', 2, 1);

-- Level 3: Cabang
INSERT INTO master_loket (parent_id, kode_loket, nama_loket, kategori, level, created_by) VALUES
(NULL, 'CAB-JKTTIM', 'Cabang Jakarta Timur', 'Cabang', 3, 1),
(NULL, 'CAB-JKTSEL', 'Cabang Jakarta Selatan', 'Cabang', 3, 1),
(NULL, 'CAB-JKTBAR', 'Cabang Jakarta Barat', 'Cabang', 3, 1);

-- =====================================================
-- MASTER PROFESI
-- =====================================================

INSERT INTO master_profesi (kode_profesi, nama_profesi, created_by) VALUES
('PROF01', 'Swasta', 1),
('PROF02', 'Pelajar', 1),
('PROF03', 'Mahasiswa', 1),
('PROF04', 'Polri', 1),
('PROF05', 'TNI', 1),
('PROF06', 'PNS', 1),
('PROF07', 'BUMN/BUMD', 1),
('PROF08', 'Ibu Rumah Tangga', 1),
('PROF09', 'Dokter', 1),
('PROF10', 'Guru', 1),
('PROF11', 'Buruh', 1),
('PROF12', 'Perawat', 1),
('PROF13', 'Bidan', 1),
('PROF14', 'Pengacara', 1),
('PROF15', 'Pengemudi Kendaraan Umum', 1),
('PROF16', 'Pengemudi Kendaraan Non Umum', 1),
('PROF17', 'Wiraswasta/Pengusaha', 1),
('PROF18', 'Pekerjaan Lainnya', 1);

-- =====================================================
-- MASTER JENIS KENDARAAN
-- =====================================================

INSERT INTO master_jenis_kendaraan (kode_jenis, nama_jenis, kategori, created_by) VALUES
('KD01', 'Sepeda Motor', 'Roda 2', 1),
('KD02', 'Becak Motor', 'Roda 3', 1),
('KD03', 'Mobil Sedan', 'Roda 4', 1),
('KD04', 'Mobil MPV', 'Roda 4', 1),
('KD05', 'Mobil SUV', 'Roda 4', 1),
('KD06', 'Mobil Pick Up', 'Roda 4', 1),
('KD07', 'Bus Umum', 'Bus', 1),
('KD08', 'Bus Pariwisata', 'Bus', 1),
('KD09', 'Truk Kecil', 'Truk', 1),
('KD10', 'Truk Besar', 'Truk', 1),
('KD11', 'Kereta Api', 'Kereta Api', 1),
('KD12', 'Kapal Laut', 'Kapal', 1),
('KD13', 'Kapal Feri', 'Kapal', 1),
('KD14', 'Pesawat Udara', 'Pesawat', 1),
('KD15', 'Lainnya', 'Lainnya', 1);

-- =====================================================
-- MASTER JENIS CIDERA
-- =====================================================

INSERT INTO master_jenis_cidera (kode_cidera, nama_cidera, tingkat_keparahan, created_by) VALUES
('CID01', 'Luka Ringan', 'Ringan', 1),
('CID02', 'Luka Sedang', 'Sedang', 1),
('CID03', 'Luka Berat', 'Berat', 1),
('CID04', 'Meninggal Dunia', 'Meninggal Dunia', 1),
('CID05', 'Luka Luka', 'Sedang', 1),
('CID06', 'Cacat Tetap', 'Berat', 1),
('CID07', 'Meninggal Dunia & Luka Luka', 'Meninggal Dunia', 1),
('CID08', 'Luka Luka & Cacat Tetap', 'Berat', 1),
('CID09', 'Penguburan', 'Meninggal Dunia', 1),
('CID10', 'Luka Luka & Penguburan', 'Meninggal Dunia', 1);

-- =====================================================
-- MASTER KASUS LAKA (JENIS KECELAKAAN)
-- =====================================================

INSERT INTO master_kasus_laka (kode_kasus, nama_kasus, deskripsi, created_by) VALUES
('001', 'Tabrakan Depan - Depan', 'Tabrakan frontal antar kendaraan', 1),
('002', 'Tabrakan Depan - Samping', 'Tabrakan bagian depan dengan samping', 1),
('003', 'Tabrakan Depan - Belakang', 'Tabrakan bagian depan dengan belakang', 1),
('004', 'Tabrakan Belakang - Samping', 'Tabrakan bagian belakang dengan samping', 1),
('005', 'Tabrakan Samping - Samping', 'Tabrakan antar samping kendaraan', 1),
('006', 'Tabrakan Beruntun/Ganda', 'Kecelakaan melibatkan banyak kendaraan', 1),
('007', 'Tabrakan Dengan Kereta API', 'Kendaraan menabrak kereta api', 1),
('008', 'Menabrak Pejalan Kaki/Sejenisnya', 'Kendaraan menabrak pejalan kaki', 1),
('009', 'Kecelakaan Tunggal', 'Kecelakaan tanpa melibatkan kendaraan lain', 1),
('010', 'Kendaraan Terbakar', 'Kendaraan mengalami kebakaran', 1),
('011', 'Kendaraan Tertimpa Benda Keras', 'Kendaraan tertimpa pohon, batu, dll', 1),
('012', 'Kendaraan Menabrak Property', 'Menabrak pagar, tiang, dll', 1),
('013', 'Kendaraan Masuk Jurang', 'Kendaraan terjun ke jurang', 1),
('014', 'Jatuh dari Kendaraan Alat Angkutan', 'Penumpang jatuh dari kendaraan', 1),
('015', 'Ditabrak Kereta API', 'Kendaraan ditabrak kereta api', 1),
('016', 'Tabrakan Kereta Api Dengan Kereta API', 'Kecelakaan antar kereta api', 1),
('017', 'Kereta Api Terbalik', 'Kereta api mengalami terbalik', 1),
('018', 'Kecelakaan Dalam Kapal Laut', 'Kecelakaan di dalam kapal', 1),
('019', 'Kapal Laut Tenggelam', 'Kapal mengalami tenggelam', 1),
('020', 'Kapal Laut Terbakar', 'Kapal mengalami kebakaran', 1),
('021', 'Jatuh Dari Kapal Laut', 'Penumpang jatuh dari kapal', 1),
('022', 'Benturan Dengan Badan Kapal', 'Benturan dengan bagian kapal', 1),
('023', 'Benturan Dengan Benda Di Kapal', 'Benturan dengan benda di kapal', 1),
('024', 'Pesawat Udara Jatuh', 'Pesawat mengalami jatuh', 1),
('025', 'Pesawat Terbakar', 'Pesawat mengalami kebakaran', 1),
('026', 'Pesawat Udara Tabrakan', 'Tabrakan antar pesawat', 1),
('027', 'Tenggelam di Laut/Sungai', 'Korban tenggelam di perairan', 1),
('028', 'Meninggal Karena Penyakitnya', 'Meninggal akibat penyakit bawaan', 1);

-- =====================================================
-- MASTER RUANG LINGKUP JAMINAN
-- =====================================================

INSERT INTO master_ruang_lingkup_jaminan (kode_jaminan, nama_jaminan, kategori, created_by) VALUES
('RLJ01', '33/64 KBU Bus', 'KBU Bus', 1),
('RLJ02', '33/64 KBU Non Bus', 'KBU Non Bus', 1),
('RLJ03', '33/64 Kereta API', 'Kereta API', 1),
('RLJ04', '33/64 Kapal Laut', 'Kapal Laut', 1),
('RLJ05', '33/64 Kapal Perairan Darat', 'Kapal Perairan Darat', 1),
('RLJ06', '33/64 Pesawat Udara', 'Pesawat Udara', 1),
('RLJ07', '34/64 KB Sipil', 'KB Sipil', 1),
('RLJ08', '34/64 KB TNI/Polri', 'KB TNI/Polri', 1),
('RLJ09', '34/64 KR Api', 'KR Api', 1);

-- =====================================================
-- MASTER STATUS KORBAN
-- =====================================================

INSERT INTO master_status_korban (kode_status, nama_status, created_by) VALUES
('SK01', 'Penumpang', 1),
('SK02', 'Pilot', 1),
('SK03', 'Nahkoda Kapal', 1),
('SK04', 'Pengemudi Kendaraan Non Bermotor', 1),
('SK05', 'Kernet', 1),
('SK06', 'Anak Buah Kapal', 1),
('SK07', 'Crew Pesawat Udara', 1),
('SK08', 'Pembonceng', 1),
('SK09', 'Pejalan Kaki/Sejenisnya', 1),
('SK10', 'Masinis', 1),
('SK11', 'Pengendara Kendaraan Roda Dua', 1),
('SK12', 'Pengendara Kendaraan Roda Tiga', 1),
('SK13', 'Pengendara Kendaraan Roda Empat', 1),
('SK14', 'Pengendara Kendaraan Roda Lebih dari Empat', 1),
('SK15', 'Lainnya/Belum Diketahui', 1);

-- =====================================================
-- MASTER HUBUNGAN DENGAN KORBAN
-- =====================================================

INSERT INTO master_hubungan_korban (kode_hubungan, nama_hubungan, kategori, created_by) VALUES
-- Untuk Pembawa Korban
('HUB01', 'Korban Sendiri', 'Pembawa', 1),
('HUB02', 'Keluarga/Kerabat', 'Pembawa', 1),
('HUB03', 'Polisi/TNI', 'Pembawa', 1),
('HUB04', 'Ambulance RS', 'Pembawa', 1),
('HUB05', 'Ambulance Relawan', 'Pembawa', 1),
('HUB06', 'Warga Sekitar TKP', 'Pembawa', 1),
('HUB07', 'Pihak Penabrak', 'Pembawa', 1),
('HUB08', 'Lainnya', 'Pembawa', 1),

-- Untuk Saksi
('HUB09', 'Warga Sekitar Domisili', 'Saksi', 1),
('HUB10', 'Kerabat Korban', 'Saksi', 1),
('HUB11', 'Keluarga Lain', 'Saksi', 1),
('HUB12', 'Pamong Praja (RT/RW/Kelurahan/Kecamatan)', 'Saksi', 1),

-- Untuk Ahli Waris
('HUB13', 'Suami Korban', 'Ahli Waris', 1),
('HUB14', 'Istri Korban', 'Ahli Waris', 1),
('HUB15', 'Anak', 'Ahli Waris', 1),
('HUB16', 'Orang Tua', 'Ahli Waris', 1),
('HUB17', 'Keluarga Lainnya', 'Ahli Waris', 1);

-- =====================================================
-- MASTER ASAL KORBAN
-- =====================================================

INSERT INTO master_asal_korban (kode_asal, nama_asal, created_by) VALUES
('ASL01', 'Dari TKP', 1),
('ASL02', 'Rujukan dari RS Lain di Jakarta', 1),
('ASL03', 'Rujukan dari RS Lain Luar Kota', 1);

-- =====================================================
-- MASTER JENIS KENDARAAN PEMBAWA
-- =====================================================

INSERT INTO master_jenis_kendaraan_pembawa (kode_pembawa, nama_pembawa, created_by) VALUES
('PBW01', 'Kendaraan Roda 4', 1),
('PBW02', 'Kendaraan Roda 2', 1),
('PBW03', 'Ambulance', 1),
('PBW04', 'Angkutan Umum', 1),
('PBW05', 'Lainnya', 1);

-- =====================================================
-- MASTER STATUS KETERJAMINAN
-- =====================================================

INSERT INTO master_status_keterjaminan (kode_status, nama_status, warna, deskripsi, created_by) VALUES
('STK01', 'Terjamin', 'Hijau', 'Korban memenuhi syarat jaminan', 1),
('STK02', 'Tidak Terjamin', 'Merah', 'Korban tidak memenuhi syarat jaminan', 1),
('STK03', 'Penelitian Lebih Lanjut', 'Kuning', 'Memerlukan penelitian lebih lanjut', 1);

-- =====================================================
-- MASTER STATUS RUMAH TINGGAL
-- =====================================================

INSERT INTO master_status_rumah (kode_status, nama_status, created_by) VALUES
('RMH01', 'Rumah Sendiri', 1),
('RMH02', 'Rumah Sewa', 1),
('RMH03', 'Rumah Orang Tua/Keluarga', 1);

-- =====================================================
-- MASTER STATUS SAKSI PERISTIWA
-- =====================================================

INSERT INTO master_status_saksi_peristiwa (kode_status, nama_status, created_by) VALUES
('SSP01', 'Melihat', 1),
('SSP02', 'Mendengar', 1),
('SSP03', 'Menolong Korban', 1),
('SSP04', 'Terlibat dalam Kecelakaan', 1);

-- =====================================================
-- SAMPLE USER DATA
-- =====================================================
-- Password default untuk semua user: "password123" (harus di-hash di aplikasi)
-- Berikut adalah contoh hash bcrypt untuk "password123": $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

INSERT INTO users (username, password, email, nama_lengkap, role_id, loket_id, no_telepon, created_by) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@jasaraharja.co.id', 'Administrator System', 1, NULL, '08123456789', 1),
('petugas_internal', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas@jasaraharja.co.id', 'Petugas Survey Internal', 2, 2, '08123456790', 1),
('petugas_rs', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rs@jasaraharja.co.id', 'Petugas Rumah Sakit', 3, 2, '08123456791', 1),
('pejabat', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pejabat@jasaraharja.co.id', 'Pejabat Tinggi', 4, NULL, '08123456792', 1);

-- =====================================================
-- END OF INSERT DATA MASTER
-- =====================================================

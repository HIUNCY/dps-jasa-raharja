<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Stored Procedure: Generate Nomor Kasus
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generate_nomor_kasus");
        DB::unprepared("
            CREATE PROCEDURE sp_generate_nomor_kasus(
                IN p_tahun YEAR,
                IN p_bulan TINYINT,
                OUT p_nomor_kasus VARCHAR(30)
            )
            BEGIN
                DECLARE v_sequence INT;
                DECLARE v_nomor_urut VARCHAR(3);
                
                INSERT INTO sequence_numbers (tipe, tahun, bulan, last_number)
                VALUES ('KASUS', p_tahun, p_bulan, 1)
                ON DUPLICATE KEY UPDATE last_number = last_number + 1;
                
                SELECT last_number INTO v_sequence
                FROM sequence_numbers
                WHERE tipe = 'KASUS' AND tahun = p_tahun AND bulan = p_bulan;
                
                SET v_nomor_urut = LPAD(v_sequence, 3, '0');
                SET p_nomor_kasus = CONCAT('LAKA-', p_tahun, LPAD(p_bulan, 2, '0'), '-', v_nomor_urut);
            END
        ");

        // 2. Stored Procedure: Generate Nomor Korban
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generate_nomor_korban");
        DB::unprepared("
            CREATE PROCEDURE sp_generate_nomor_korban(
                IN p_tahun YEAR,
                IN p_bulan TINYINT,
                OUT p_nomor_korban VARCHAR(30)
            )
            BEGIN
                DECLARE v_sequence INT;
                DECLARE v_nomor_urut VARCHAR(3);
                
                INSERT INTO sequence_numbers (tipe, tahun, bulan, last_number)
                VALUES ('KORBAN', p_tahun, p_bulan, 1)
                ON DUPLICATE KEY UPDATE last_number = last_number + 1;
                
                SELECT last_number INTO v_sequence
                FROM sequence_numbers
                WHERE tipe = 'KORBAN' AND tahun = p_tahun AND bulan = p_bulan;
                
                SET v_nomor_urut = LPAD(v_sequence, 3, '0');
                SET p_nomor_korban = CONCAT('KORBAN-', p_tahun, LPAD(p_bulan, 2, '0'), '-', v_nomor_urut);
            END
        ");

        // 3. Stored Procedure: Update Jumlah Korban (Adapted for deleted_at)
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_update_jumlah_korban");
        DB::unprepared("
            CREATE PROCEDURE sp_update_jumlah_korban(
                IN p_kasus_id INT
            )
            BEGIN
                UPDATE kasus_kecelakaan
                SET jumlah_korban = (
                    SELECT COUNT(*) 
                    FROM korban 
                    WHERE kasus_kecelakaan_id = p_kasus_id AND deleted_at IS NULL
                )
                WHERE id = p_kasus_id;
            END
        ");

        // 4. Trigger: Korban After Insert
        DB::unprepared("DROP TRIGGER IF EXISTS trg_korban_after_insert");
        DB::unprepared("
            CREATE TRIGGER trg_korban_after_insert
            AFTER INSERT ON korban
            FOR EACH ROW
            BEGIN
                CALL sp_update_jumlah_korban(NEW.kasus_kecelakaan_id);
            END
        ");

        // 5. Trigger: Korban After Update (Adapted for deleted_at)
        DB::unprepared("DROP TRIGGER IF EXISTS trg_korban_after_update");
        DB::unprepared("
            CREATE TRIGGER trg_korban_after_update
            AFTER UPDATE ON korban
            FOR EACH ROW
            BEGIN
                IF (OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL) OR (OLD.deleted_at IS NOT NULL AND NEW.deleted_at IS NULL) THEN
                    CALL sp_update_jumlah_korban(NEW.kasus_kecelakaan_id);
                END IF;
            END
        ");

        // 6. Trigger: Survey TKP After Insert
        DB::unprepared("DROP TRIGGER IF EXISTS trg_survey_tkp_after_insert");
        DB::unprepared("
            CREATE TRIGGER trg_survey_tkp_after_insert
            AFTER INSERT ON survey_tkp
            FOR EACH ROW
            BEGIN
                UPDATE korban
                SET is_survey_tkp = TRUE,
                    status_keterjaminan_setelah_tkp = NEW.status_keterjaminan_id,
                    status_keterjaminan_final = NEW.status_keterjaminan_id
                WHERE id = NEW.korban_id;
            END
        ");

        // 7. Trigger: Survey Ahli Waris After Insert
        DB::unprepared("DROP TRIGGER IF EXISTS trg_survey_ahli_waris_after_insert");
        DB::unprepared("
            CREATE TRIGGER trg_survey_ahli_waris_after_insert
            AFTER INSERT ON survey_ahli_waris
            FOR EACH ROW
            BEGIN
                UPDATE korban
                SET is_survey_ahli_waris = TRUE
                WHERE id = NEW.korban_id;
            END
        ");

        // 8. View: Detail Korban (Adapted for deleted_at)
        DB::unprepared("DROP VIEW IF EXISTS vw_detail_korban");
        DB::unprepared("
            CREATE VIEW vw_detail_korban AS
            SELECT
                ko.id,
                ko.nomor_korban,
                ko.nama_korban,
                ko.jenis_kelamin,
                ko.usia,
                mp.nama_profesi,
                ko.no_telepon,
                k.nomor_kasus,
                k.tanggal_kejadian,
                k.lokasi_kejadian,
                CONCAT(prov.nama_provinsi, ', ', kab.nama_kabkota) AS wilayah_tkp,
                mkl.nama_kasus AS jenis_kecelakaan,
                mjc.nama_cidera,
                mjc.tingkat_keparahan,
                msk.nama_status AS status_keterjaminan,
                msk.warna AS warna_status,
                ko.is_survey_tkp,
                ko.is_survey_ahli_waris,
                ko.is_meninggal,
                ml.nama_loket,
                ko.created_at,
                ko.updated_at
            FROM korban ko
            LEFT JOIN kasus_kecelakaan k ON ko.kasus_kecelakaan_id = k.id
            LEFT JOIN master_profesi mp ON ko.profesi_id = mp.id
            LEFT JOIN master_provinsi prov ON k.provinsi_tkp_id = prov.id
            LEFT JOIN master_kabupaten_kota kab ON k.kabkota_tkp_id = kab.id
            LEFT JOIN master_kasus_laka mkl ON k.kasus_laka_id = mkl.id
            LEFT JOIN master_jenis_cidera mjc ON ko.jenis_cidera_id = mjc.id
            LEFT JOIN master_status_keterjaminan msk ON ko.status_keterjaminan_final = msk.id
            LEFT JOIN master_loket ml ON ko.loket_id = ml.id
            WHERE ko.deleted_at IS NULL
        ");

         // 9. View: Statistik Kasus Bulanan
        DB::unprepared("DROP VIEW IF EXISTS vw_statistik_kasus_bulanan");
        DB::unprepared("
            CREATE VIEW vw_statistik_kasus_bulanan AS
            SELECT 
                YEAR(k.tanggal_kejadian) AS tahun,
                MONTH(k.tanggal_kejadian) AS bulan,
                DATE_FORMAT(k.tanggal_kejadian, '%Y-%m') AS periode,
                COUNT(DISTINCT k.id) AS jumlah_kasus,
                COUNT(DISTINCT ko.id) AS jumlah_korban,
                SUM(CASE WHEN ko.is_meninggal = TRUE THEN 1 ELSE 0 END) AS jumlah_meninggal,
                SUM(CASE WHEN ko.is_meninggal = FALSE THEN 1 ELSE 0 END) AS jumlah_luka_luka
            FROM kasus_kecelakaan k
            JOIN korban ko ON k.id = ko.kasus_kecelakaan_id
            WHERE k.deleted_at IS NULL AND ko.deleted_at IS NULL
            GROUP BY YEAR(k.tanggal_kejadian), MONTH(k.tanggal_kejadian), DATE_FORMAT(k.tanggal_kejadian, '%Y-%m')
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS vw_statistik_kasus_bulanan");
        DB::unprepared("DROP VIEW IF EXISTS vw_detail_korban");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_survey_ahli_waris_after_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_survey_tkp_after_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_korban_after_update");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_korban_after_insert");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_update_jumlah_korban");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generate_nomor_korban");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generate_nomor_kasus");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_ahli_waris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korban_id')->constrained('korban')->onDelete('restrict');
            $table->foreignId('kasus_kecelakaan_id')->constrained('kasus_kecelakaan')->onDelete('restrict');
            $table->foreignId('petugas_survey_id')->constrained('users')->onDelete('restrict')->comment('User ID petugas survey');
            
            // Data Saksi (keluarga/kerabat/tetangga)
            $table->foreignId('saksi_1_id')->nullable()->constrained('saksi')->onDelete('set null');
            $table->foreignId('saksi_2_id')->nullable()->constrained('saksi')->onDelete('set null');
            $table->foreignId('hubungan_saksi_1_id')->nullable()->constrained('master_hubungan_korban')->onDelete('set null');
            $table->foreignId('hubungan_saksi_2_id')->nullable()->constrained('master_hubungan_korban')->onDelete('set null');
            
            // Data Ahli Waris
            $table->string('nama_ahli_waris', 150);
            $table->foreignId('hubungan_ahli_waris_id')->constrained('master_hubungan_korban')->onDelete('restrict');
            $table->foreignId('profesi_ahli_waris_id')->nullable()->constrained('master_profesi')->onDelete('set null');
            $table->string('no_telepon_ahli_waris', 20)->nullable();
            
             // Lokasi Ahli Waris
            $table->text('alamat_lengkap_ahli_waris')->nullable();
            $table->foreignId('kelurahan_ahli_waris_id')->nullable()->constrained('master_kelurahan')->onDelete('set null');
            $table->foreignId('kecamatan_ahli_waris_id')->nullable()->constrained('master_kecamatan')->onDelete('set null');
            $table->foreignId('kabkota_ahli_waris_id')->nullable()->constrained('master_kabupaten_kota')->onDelete('set null');
            $table->foreignId('provinsi_ahli_waris_id')->nullable()->constrained('master_provinsi')->onDelete('set null');
            $table->text('koordinat_domisili')->comment('Google Maps Link');
            $table->foreignId('status_rumah_id')->nullable()->constrained('master_status_rumah')->onDelete('set null');
            
            // Ruang Lingkup Jaminan
            $table->foreignId('ruang_lingkup_jaminan_id')->nullable()->constrained('master_ruang_lingkup_jaminan')->onDelete('set null');

            // Kesimpulan
            $table->text('keterangan_survey');
            $table->enum('kesimpulan_akhir', ['Memiliki Ahli Waris', 'Tidak Memiliki Ahli Waris', 'Penelitian Lebih Lanjut']);
            
            $table->date('tanggal_survey');
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('korban_id');
            $table->index('kasus_kecelakaan_id');
            $table->index('petugas_survey_id');
            $table->index('tanggal_survey');
            $table->index('kesimpulan_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_ahli_waris');
    }
};

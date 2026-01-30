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
        Schema::create('survey_tkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korban_id')->constrained('korban')->onDelete('restrict');
            $table->foreignId('kasus_kecelakaan_id')->constrained('kasus_kecelakaan')->onDelete('restrict');
            $table->foreignId('petugas_survey_id')->constrained('users')->onDelete('restrict')->comment('User ID petugas survey');
            
            // Data Saksi
            $table->foreignId('saksi_1_id')->nullable()->constrained('saksi')->onDelete('set null');
            $table->foreignId('saksi_2_id')->nullable()->constrained('saksi')->onDelete('set null');
            $table->foreignId('status_saksi_peristiwa_id')->nullable()->constrained('master_status_saksi_peristiwa')->onDelete('set null');
            $table->foreignId('hubungan_saksi_1_id')->nullable()->constrained('master_hubungan_korban')->onDelete('set null');
            $table->foreignId('hubungan_saksi_2_id')->nullable()->constrained('master_hubungan_korban')->onDelete('set null');
            
            // Lokasi Survey
            $table->text('koordinat_tkp')->comment('Google Maps Link');
            
            // Data Kendaraan
            $table->foreignId('kendaraan_penyebab_id')->nullable()->constrained('kendaraan')->onDelete('set null');
            
            // Ruang Lingkup Jaminan
            $table->foreignId('ruang_lingkup_jaminan_id')->nullable()->constrained('master_ruang_lingkup_jaminan')->onDelete('set null');
            
            // Kesimpulan
            $table->text('uraian_kejadian');
            $table->text('kesimpulan_sementara')->nullable();
            $table->foreignId('status_keterjaminan_id')->constrained('master_status_keterjaminan')->onDelete('restrict');
            
            $table->date('tanggal_survey');
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('korban_id');
            $table->index('kasus_kecelakaan_id');
            $table->index('petugas_survey_id');
            $table->index('tanggal_survey');
            $table->index('status_keterjaminan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_tkp');
    }
};

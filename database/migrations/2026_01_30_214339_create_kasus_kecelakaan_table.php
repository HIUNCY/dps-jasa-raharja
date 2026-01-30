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
        Schema::create('kasus_kecelakaan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kasus', 30)->unique()->comment('Format: LAKA-YYYYMM-001');
            $table->foreignId('loket_id')->constrained('master_loket')->onDelete('restrict');
            $table->dateTime('tanggal_kejadian');
            $table->time('waktu_kejadian');
            $table->string('hari_kejadian', 20)->nullable();
            
            // Lokasi Kejadian
            $table->text('lokasi_kejadian');
            $table->foreignId('kelurahan_tkp_id')->nullable()->constrained('master_kelurahan')->onDelete('set null');
            $table->foreignId('kecamatan_tkp_id')->nullable()->constrained('master_kecamatan')->onDelete('set null');
            $table->foreignId('kabkota_tkp_id')->nullable()->constrained('master_kabupaten_kota')->onDelete('set null');
            $table->foreignId('provinsi_tkp_id')->nullable()->constrained('master_provinsi')->onDelete('set null');
            $table->text('koordinat_tkp')->comment('Google Maps Link');
            
            // Informasi Kecelakaan
            $table->foreignId('kasus_laka_id')->constrained('master_kasus_laka')->onDelete('restrict');
            $table->text('kronologi_kejadian');
            
            // Laporan Polisi
            $table->date('tanggal_laporan_polisi')->nullable();
            $table->string('nomor_laporan_polisi', 100)->nullable();
            
            // Status
            $table->integer('jumlah_korban')->default(0);
            $table->enum('status_kasus', ['Draft', 'On Progress', 'Completed', 'Closed'])->default('Draft');
            
            $table->softDeletes(); // is_deleted
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('tanggal_kejadian');
            $table->index('status_kasus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasus_kecelakaan');
    }
};

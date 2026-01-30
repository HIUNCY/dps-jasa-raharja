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
        Schema::create('korban', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_korban', 30)->unique()->comment('Format: KORBAN-YYYYMM-001');
            $table->foreignId('kasus_kecelakaan_id')->constrained('kasus_kecelakaan')->onDelete('restrict');
            $table->foreignId('loket_id')->constrained('master_loket')->onDelete('restrict');

            // Data Pribadi
            $table->string('nama_korban', 150);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->integer('usia');
            $table->foreignId('profesi_id')->nullable()->constrained('master_profesi')->onDelete('set null');
            $table->string('no_telepon', 20)->nullable();

            // Alamat Korban
            $table->text('alamat_lengkap')->nullable();
            $table->foreignId('kelurahan_id')->nullable()->constrained('master_kelurahan')->onDelete('set null');
            $table->foreignId('kecamatan_id')->nullable()->constrained('master_kecamatan')->onDelete('set null');
            $table->foreignId('kabkota_id')->nullable()->constrained('master_kabupaten_kota')->onDelete('set null');
            $table->foreignId('provinsi_id')->nullable()->constrained('master_provinsi')->onDelete('set null');
            $table->string('nama_jalan', 200)->nullable();

            // Data Kejadian dari RS
            $table->dateTime('waktu_masuk_rs');
            $table->foreignId('asal_korban_id')->nullable()->constrained('master_asal_korban')->onDelete('set null');
            $table->foreignId('jenis_kendaraan_pembawa_id')->nullable()->constrained('master_jenis_kendaraan_pembawa')->onDelete('set null');
            $table->string('nama_pembawa_korban', 150)->nullable();
            $table->foreignId('hubungan_pembawa_id')->nullable()->constrained('master_hubungan_korban')->onDelete('set null');

            // Cidera & Status
            $table->foreignId('jenis_cidera_id')->nullable()->constrained('master_jenis_cidera')->onDelete('set null');
            $table->foreignId('status_korban_id')->nullable()->constrained('master_status_korban')->onDelete('set null')->comment('Penumpang, Pengendara, dll');
            $table->foreignId('kendaraan_korban_id')->nullable()->constrained('kendaraan')->onDelete('set null');

            // Status Keterjaminan
            $table->foreignId('status_keterjaminan_id')->default(3)->constrained('master_status_keterjaminan')->onDelete('restrict')->comment('Default: Penelitian Lebih Lanjut (Kuning)');
            $table->foreignId('status_keterjaminan_setelah_tkp')->nullable()->constrained('master_status_keterjaminan')->onDelete('set null');
            $table->foreignId('status_keterjaminan_final')->nullable()->constrained('master_status_keterjaminan')->onDelete('set null');

            // Survey Status
            $table->boolean('is_survey_tkp')->default(false);
            $table->boolean('is_survey_ahli_waris')->default(false);
            $table->boolean('is_meninggal')->default(false);

            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('nama_korban');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korban');
    }
};

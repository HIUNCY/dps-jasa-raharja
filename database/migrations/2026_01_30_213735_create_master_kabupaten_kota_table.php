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
        Schema::create('master_kabupaten_kota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained('master_provinsi')->onDelete('restrict');
            $table->string('kode_kabkota', 10)->unique();
            $table->string('nama_kabkota', 100);
            $table->enum('jenis', ['Kabupaten', 'Kota']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kabupaten_kota');
    }
};

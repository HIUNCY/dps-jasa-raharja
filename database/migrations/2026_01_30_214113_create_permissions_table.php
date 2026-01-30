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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_permission', 50)->unique();
            $table->string('nama_permission', 100);
            $table->string('modul', 50)->comment('Dashboard, Kasus, Korban, Survey, Laporan, dll');
            $table->string('aksi', 50)->comment('Create, Read, Update, Delete, Export');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('modul');
            $table->index('aksi');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

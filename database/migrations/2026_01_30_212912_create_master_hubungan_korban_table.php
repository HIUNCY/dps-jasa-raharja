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
        Schema::create('master_hubungan_korban', function (Blueprint $table) {
            $table->id();
            $table->string('kode_hubungan', 10)->unique();
            $table->string('nama_hubungan', 100);
            $table->enum('kategori', ['Pembawa', 'Saksi', 'Ahli Waris']);
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
        Schema::dropIfExists('master_hubungan_korban');
    }
};

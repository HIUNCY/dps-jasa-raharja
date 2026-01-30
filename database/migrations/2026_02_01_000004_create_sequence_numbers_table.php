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
        Schema::create('sequence_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('tipe', 50)->comment('KASUS, KORBAN, etc');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->unsignedBigInteger('last_number')->default(0);
            $table->timestamps(); // created_at, updated_at

            $table->unique(['tipe', 'tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sequence_numbers');
    }
};

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
        Schema::create('saksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_saksi', 150);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->integer('usia')->nullable();
            $table->foreignId('profesi_id')->nullable()->constrained('master_profesi')->onDelete('set null');
            $table->string('no_telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('nama_saksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saksi');
    }
};

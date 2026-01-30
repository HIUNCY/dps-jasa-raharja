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
        Schema::create('master_loket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('master_loket')->onDelete('restrict');
            $table->string('kode_loket', 20)->unique();
            $table->string('nama_loket', 150);
            $table->enum('kategori', ['Kanwil', 'Cabang', 'Wilayah']);
            $table->integer('level')->comment('1=Kanwil, 2=Cabang, 3=Wilayah');
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
        Schema::dropIfExists('master_loket');
    }
};

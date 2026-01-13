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
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->string('juz'); // Juz 1-30
            $table->string('surah');
            $table->string('ayat_mulai');
            $table->string('ayat_selesai');
            $table->enum('status', ['setoran', 'murajaah', 'lulus'])->default('setoran');
            $table->integer('nilai')->nullable(); // 1-100
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->foreignId('ustadz_id')->constrained('users'); // Ustadz penguji
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan');
    }
};

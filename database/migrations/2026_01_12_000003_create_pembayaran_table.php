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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('tagihan_id')->nullable()->constrained('tagihan')->nullOnDelete();
            $table->enum('jenis', ['dpp', 'spp', 'seragam', 'lainnya']);
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_bayar');
            $table->enum('metode', ['tunai', 'transfer'])->default('tunai');
            $table->string('bukti_transfer')->nullable(); // Path to uploaded file
            $table->foreignId('recorded_by')->constrained('users'); // Admin/Pengurus yang input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

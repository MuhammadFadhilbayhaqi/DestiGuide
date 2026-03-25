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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();

            // Ubah baris ini dengan menambahkan nama tabel 'wisata' di dalam constrained()
            $table->foreignId('wisata_id')->constrained('wisata');

            $table->string('nama_lengkap');
            $table->string('nomor_handphone');
            $table->string('email');
            $table->string('ktp');
            $table->string('metode_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

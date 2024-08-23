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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('norm'); // Nomor Rekam Medis
            $table->date('tanggal'); // Tanggal Lahir
            // $table->integer('kunjungan'); // Jumlah Kunjungan
            $table->string('nama'); // Nama
            $table->date('lahir'); // Tanggal Lahir
            $table->integer('age'); // Tanggal Lahir
            $table->string('gender'); // Nama
            $table->text('kelurahan')->nullable(); // Alamat
            $table->text('kecamatan')->nullable(); // Alamat
            $table->text('kota')->nullable(); // Alamat
            $table->string('telepon'); // No Telepon
            $table->string('email'); // Email
            $table->text('fulladress')->nullable(); // Alamat
            $table->text('adminNote')->nullable(); // Catatan
            $table->string('rujukan')->nullable(); // Rujukan
            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};

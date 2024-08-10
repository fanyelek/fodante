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
        Schema::create('detail_service_pasiens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->unsignedBigInteger('dentist_id');
            $table->foreign('dentist_id')->references('id')->on('data_dokters')->onDelete('cascade');
            $table->date('tanggal');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('data_services')->onDelete('cascade');
            $table->decimal('biaya', 10, 2);
            $table->text('catatan')->nullable(); // Catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_service_pasiens');
    }
};

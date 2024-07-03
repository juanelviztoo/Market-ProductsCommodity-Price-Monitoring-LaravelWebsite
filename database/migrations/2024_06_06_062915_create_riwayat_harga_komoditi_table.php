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
        Schema::create('riwayat_harga_komoditi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasar_id')->constrained('pasar')->onDelete('cascade');
            $table->foreignId('komoditi_id')->constrained('komoditi')->onDelete('cascade');
            $table->foreignId('produk_komoditi_id')->nullable();
            $table->date('tanggal_update');
            $table->decimal('harga', 10, 2);
            $table->enum('status', ['Harga Naik', 'Harga Tetap', 'Harga Turun']);
            $table->timestamps();
        });

        Schema::table('riwayat_harga_komoditi', function (Blueprint $table) {
            $table->foreign('produk_komoditi_id')->references('id')->on('produk_komoditi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_harga_komoditi', function (Blueprint $table) {
            $table->dropForeign(['produk_komoditi_id']);
            $table->dropColumn('produk_komoditi_id');
        });

        Schema::dropIfExists('riwayat_harga_komoditi');
    }
};

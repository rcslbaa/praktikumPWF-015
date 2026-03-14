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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghindari error 'Foreign key constraint fails' saat proses drop
        Schema::disableForeignKeyConstraints();
        
        // Sesuaikan nama tabel dengan yang ada di fungsi up (kategori, bukan kategoris)
        Schema::dropIfExists('kategori');
        
        Schema::enableForeignKeyConstraints();
    }
};
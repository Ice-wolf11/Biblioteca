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
        Schema::create('copia_libros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->enum('estado', ['disponible', 'prestado', 'extraviado'])->default('activo');
            $table->foreignId('id_libro')->constrained('libros')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copia_libros');
    }
};

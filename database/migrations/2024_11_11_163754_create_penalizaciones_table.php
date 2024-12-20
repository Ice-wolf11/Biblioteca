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
        Schema::create('penalizaciones', function (Blueprint $table) {
            $table->id();
            #$table->date('fecha_inicio');
            $table->decimal('monto', 10,2)->unsigned();
            $table->enum('estado', ['activo', 'pagado','anulado'])->default('activo');
            $table->foreignId('id_prestamo')->constrained('prestamos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalizaciones');
    }
};

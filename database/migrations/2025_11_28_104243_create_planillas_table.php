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
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->date('mes_anio'); // Ej: 2025-11-01
            $table->decimal('total_ingresos', 10, 2);
            $table->decimal('total_deducciones', 10, 2);
            $table->decimal('sueldo_neto', 10, 2);
            $table->string('estado', 20)->default('Pendiente'); // Generada, Pagada, etc.
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planillas');
    }
};

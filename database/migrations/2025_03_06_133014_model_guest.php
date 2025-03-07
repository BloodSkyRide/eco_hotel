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
        Schema::create('alquiler_habitaciones', function (Blueprint $table) {

            $table->id("id_habitacion");
            $table->string("nombre_huesped",255)->nullable();
            $table->string("apellido_huesped",255)->nullable();
            $table->string("cedula_huesped",255)->nullable();
            $table->date("nacimiento")->nullable();
            $table->text("email")->nullable();
            $table->text("origen")->nullable();
            $table->text("destino")->nullable();
            $table->string("estado_civil",255)->nullable();
            $table->string("celular",255)->nullable();
            $table->time("hora")->nullable();
            $table->string("habitacion",10)->nullable();
            $table->string("estadia",10)->nullable();
            $table->bigInteger("total_venta")->nullable();
            $table->date("fecha")->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquiler_habitaciones');
    }
};

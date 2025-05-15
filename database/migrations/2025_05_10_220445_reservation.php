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
        Schema::create('reservaciones', function (Blueprint $table) {

            $table->id("id_reservacion");
            $table->bigInteger("monto_reservado")->nullable();
            $table->bigInteger("monto_adeudado")->nullable();
            $table->bigInteger("valor_paquete")->nullable();
            $table->string("titular")->nullable();
            $table->string("fecha",50)->nullable();
            $table->string("chat",50)->nullable();
            $table->date("fecha_reservacion")->nullable();
            $table->string("cedula",50)->nullable();
            $table->string("medio_pago",20)->nullable();
            $table->string("contacto",20)->nullable();
            $table->integer("numero_huespedes")->nullable();
            $table->text("descripcion_reserva",10)->nullable();
            $table->time("hora_reserva")->nullable();
            $table->string("id_reserva_unit",30)->nullable();
            $table->string("estado",30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};

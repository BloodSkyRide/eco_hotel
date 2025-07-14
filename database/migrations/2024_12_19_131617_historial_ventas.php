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
        Schema::create('historial_ventas', function (Blueprint $table) {

            $table->id("id_venta");
            $table->integer("id_producto_venta")->nullable();
            $table->string("nombre_producto_venta",255)->nullable();
            $table->text("descripcion_producto_venta")->nullable();
            $table->integer("unidades_venta")->nullable();
            $table->string("id_user_cajero")->nullable();
            $table->string("nombre_cajero")->nullable();
            $table->time("hora")->nullable();
            $table->date("fecha")->nullable();
            $table->bigInteger("total_venta")->nullable();
            $table->string("categoria")->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_ventas');
    }
};

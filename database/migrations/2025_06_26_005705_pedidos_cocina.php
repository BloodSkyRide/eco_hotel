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
            Schema::create('cocina_pedidos', function (Blueprint $table) {

            $table->id("id_pedido");
            $table->string("nombre_producto")->nullable();
            $table->integer("cantidad")->nullable();
            $table->text("descripcion")->nullable();
            $table->text("auxiliar")->nullable();
            $table->time("hora")->nullable();
            $table->string("estado",30)->nullable();
            $table->date("fecha")->nullable();
            $table->string("nombre_cajero")->nullable();
            $table->string("id_cajero",50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cocina_pedidos');
    }
};

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
        Schema::create('inventario', function (Blueprint $table) {

            $table->id("id_item");
            $table->string("nombre",255);
            $table->float("unidades_disponibles")->nullable();
            $table->date("fecha_creacion")->nullable();
            $table->time('hora_creacion')->nullable();
            $table->integer('tope_min')->nullable();
            $table->string('abastecimiento')->nullable();
            $table->float('precio_costo')->nullable();
            $table->string('estado',100)->nullable();
            $table->string('categoria',100)->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};

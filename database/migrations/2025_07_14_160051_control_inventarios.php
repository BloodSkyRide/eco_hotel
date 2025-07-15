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
            Schema::create('control_inventarios', function (Blueprint $table) {

            $table->id("id_item");
            $table->string("id_original",20);
            $table->string("nombre",255);
            $table->float("unidades_disponibles")->nullable();
            $table->date("fecha_reporte")->nullable();
            $table->time('hora_reporte')->nullable();
            $table->string('categoria',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_inventarios');
    }
};

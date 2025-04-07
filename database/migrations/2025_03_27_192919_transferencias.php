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
        Schema::create('transferencias', function (Blueprint $table) {

            $table->id("id_transferencias");
            $table->date("fecha")->nullable();
            $table->time("hora")->nullable();
            $table->string("cajero_responsable",255)->nullable();
            $table->string("id_cajero",255)->nullable();
            $table->bigInteger("valor")->nullable();
            $table->text("url_imagen")->nullable();
            $table->text("entidad")->nullable();
            $table->text("descripcion")->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencias');
    }
};

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
        Schema::create('egresos', function (Blueprint $table) {

            $table->id("id_egreso");
            $table->date("fecha")->nullable();
            $table->bigInteger("valor")->nullable();
            $table->text("descripcion")->nullable();
            $table->text("url_imagen")->nullable();
            $table->string("nombre",255)->nullable();
            $table->string("cedula",255)->nullable();
            $table->boolean("caja")->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};

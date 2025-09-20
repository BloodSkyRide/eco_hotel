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
            Schema::create('chat_bot', function (Blueprint $table) {

            $table->id('id_chat');
            $table->string('telefono')->unique();
            $table->text('ultimo_mensaje')->nullable();
            $table->string('estado_conversacion')->nullable();
            $table->boolean('consentimiento')->default(false);
            $table->date('fecha');
            $table->time('hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_bot');
    }
};

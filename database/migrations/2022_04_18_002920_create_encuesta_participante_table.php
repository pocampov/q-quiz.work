<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaParticipanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_participante', function (Blueprint $table) {
			$table->timestamps();
			$table->foreignId('encuesta_id')->constrained();
			$table->foreignId('participante_id')->constrained();
			$table->foreignId('publica_id')->constrained();
			$table->string('estado_inicial',100)->nullable(); //su estado de animo, opcional
			$table->string('estado_final',100)->nullable(); //su estado de animo, opcional
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuesta_participante');
    }
}

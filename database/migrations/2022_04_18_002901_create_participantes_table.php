<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->foreignId('encuesta_id')->constrained();
			$table->foreignId('publica_id')->constrained();
			$table->string('estado_inicial',100)->nullable(); //su estado de animo, opcional
			$table->string('estado_final',100)->nullable(); //su estado de animo, opcional
			$table->string('nickname',50);
			$table->string('estado',100)->nullable(); //su estado de animo, opcional
			$table->integer('ultimo_contestado')->default(-1)->nullable(); // #de pregunta lanzada			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participantes');
    }
}

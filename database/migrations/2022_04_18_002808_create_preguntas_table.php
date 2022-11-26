<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
			$table->foreignId('encuesta_id')->constrained();
            $table->timestamps();
			$table->string('enunciado');
			$table->string('tipo',2); // A:Abierta O:Opcion multiple
			$table->boolean('correcta')->nullable(); //Solo es verdadera la correcta
			$table->integer('tiempo')->nullable(); //Tiempo en segundos al aire
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
}

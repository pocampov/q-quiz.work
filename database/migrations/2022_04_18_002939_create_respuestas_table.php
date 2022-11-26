<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
			$table->foreignId('participante_id')->constrained();
			$table->foreignId('pregunta_id')->constrained();
            $table->timestamps();
			$table->string('respuesta')->nullable(); //Para la pregunta abierta. Si la pregunta es de opcion multiple se almacenara el texto de la opcion
			$table->bigInteger('opcion_id')->nullable(); //Si la pregunta es de opcion multiple se almacenara opcion_id seleccionada
			$table->integer('puesto')->default(1000)->nullable();
			$table->integer('tiempo_responder')->default(0)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicas', function (Blueprint $table) {
            $table->id();
			$table->foreignId('encuesta_id')->constrained();
            $table->timestamps();
			$table->string('token',8); //Nombre para que un participante la encuentre
			$table->boolean('activo')->default(true); // true: Activo false:Inactivo
			$table->bigInteger('pregunta_lanzada_id')->unsigned()->nullable();
			$table->dateTimeTz('launching', $precision = 0)->nullable();
			$table->dateTimeTz('landing', $precision = 0)->nullable();
			$table->string('launchingTZ', 50)->nullable();
			$table->boolean('xpregunta')->default(true)->nullable(); // true: el creador define cuando lanzar la pregunta
			$table->integer('consecutivo')->default(0)->nullable(); // #de pregunta lanzada
			$table->integer('ultimo_contestado')->default(-1)->nullable(); // #de pregunta lanzada
			$table->string('preguntas_lanzadas')->default("[]")->nullable(); // JSON con las preguntas lanzadas cuando es xpregunta
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('pregunta_id')->constrained();
            $table->timestamps();
			$table->string('text',250);
			$table->integer('position')->unsigned()->default(0); //En caso de ser obligatorio el orden, sino es cero(0)
			$table->boolean('correcto')->nullable();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opcions');
    }
}

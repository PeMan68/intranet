<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('area_id')->unsigned();
			$table->foreign('area_id')->references('id')->on('areas');
			$table->integer('prio_id')->unsigned();
			$table->foreign('prio_id')->references('id')->on('priorities');
			$table->string('task');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
	}
}

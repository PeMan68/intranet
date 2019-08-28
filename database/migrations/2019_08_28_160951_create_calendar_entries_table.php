<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
			$table->date('start');
			$table->date('stop');
			$table->string('description');
			$table->bigInteger('calendarcategory_id')->nullable();
			$table->bigInteger('user_id')->nullable();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_entries');
    }
}

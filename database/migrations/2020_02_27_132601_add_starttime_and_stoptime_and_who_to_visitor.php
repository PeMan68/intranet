<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStarttimeAndStoptimeAndWhoToVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
			$table->BigInteger('user_id');
			$table->dateTime('startTime');
			$table->dateTime('stopTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('startTime');
            $table->dropColumn('stopTime');
        });
    }
}

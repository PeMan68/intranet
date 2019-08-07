<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Issues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task')->nullable();
            $table->string('userCreate')->nullable();
            $table->string('userCurrent')->nullable();
            $table->string('customer')->nullable();
            $table->string('customerNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('customerTel')->nullable();
            $table->string('customerMail')->nullable();
			$table->boolean('paused')->nullable();
			$table->boolean('waitingForReply')->nullable();
			$table->boolean('vip')->nullable();
			$table->integer('prio')->nullable();
			$table->integer('nextIssueID')->nullable();
			$table->integer('previousIssueID')->nullable();
            $table->text('description')->nullable();
            $table->text('descriptionInternal')->nullable();
            $table->timestamps();
            $table->timestamp('timeClosed')->nullable();
            $table->timestamp('timeInit')->nullable();
            $table->timestamp('timeEstimatedcallback')->nullable();
            $table->timestamp('timeCustomercallback')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}

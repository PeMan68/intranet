<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTables extends Migration
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
            $table->integer('taskPersonal_id')->nullable();
			$table->integer('task_id')->nullable();
            $table->integer('userCreate_id')->nullable();
            $table->integer('userCurrent_id')->nullable();
            $table->string('customer')->nullable();
            $table->string('customerNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('customerTel')->nullable();
            $table->string('customerMail')->nullable();
			$table->boolean('paused')->nullable();
			$table->boolean('waitingForReply')->nullable();
			$table->boolean('vip')->nullable();
			$table->integer('nextIssue_id')->nullable();
			$table->integer('previousIssue_id')->nullable();
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

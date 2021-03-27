<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
			$table->dateTime('checkout');
			$table->dateTime('checkin')->nullable();
			$table->integer('issue_id');
			$table->integer('user_id');
			// $table->text('comment')->nullable();
			$table->text('comment_external')->nullable();
			$table->text('comment_internal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_comments');
    }
}

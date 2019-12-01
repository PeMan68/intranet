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
			$table->integer('issue_id');
			$table->integer('user_id');
			$table->text('comment_internal');
			$table->text('comment_external');
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

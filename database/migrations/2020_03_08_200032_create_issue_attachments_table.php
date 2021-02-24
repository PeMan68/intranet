<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('issue_id');
            $table->integer('user_id');
			$table->string('path');
			$table->string('filename');
			$table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_attachments');
    }
}

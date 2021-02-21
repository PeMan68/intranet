<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactAndDirectionToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_comments', function (Blueprint $table) {
            $table->bigInteger('contact_id')->default('0');
            $table->integer('direction')->default('0');
            $table->integer('type')->default('0');
            $table->dropColumn('comment_external');
            $table->renameColumn('comment_internal', 'comment');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_comments', function (Blueprint $table) {
            $table->dropColumn('contact_id');
            $table->dropColumn('direction');
            $table->dropColumn('type');
            $table->text('comment_external')->nullable();
            $table->renameColumn('comment', 'comment_internal');
        });
    }
}

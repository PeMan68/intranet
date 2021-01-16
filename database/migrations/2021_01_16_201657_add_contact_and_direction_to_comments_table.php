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
            $table->bigInteger('contact_id');
            $table->boolean('outbound')->default('1');
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
            $table->dropColumn('outbound');
        });
    }
}

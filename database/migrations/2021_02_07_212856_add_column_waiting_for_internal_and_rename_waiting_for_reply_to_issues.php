<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnWaitingForInternalAndRenameWaitingForReplyToIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->renameColumn('waitingForReply', 'waitingForCustomer');
            $table->boolean('waitingForInternal')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->renameColumn('waitingForCustomer', 'waitingForReply');
            $table->dropColumn('waitingForInternal');
            //
        });
    }
}

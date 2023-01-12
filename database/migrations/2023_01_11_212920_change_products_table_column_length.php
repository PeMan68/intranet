<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProductsTableColumnLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// Change from 50 chars to 255, due to some longer descriptions
        Schema::table('products', function (Blueprint $table) {
			$table->string('item_description_eng',255)->change();
			$table->string('item_description_swe',255)->change();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
		{
			// don't go back to 50 chars, it will generate an error if data stored is longer than 50 chars
		}
}

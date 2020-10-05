<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
			$table->string('item',50);
			$table->string('item_description_eng',50)->nullable();
			$table->string('item_description_swe',50)->nullable();
			$table->float('transferprice')->default(0);
			$table->string('currency',10)->nullable();
            $table->float('listprice')->default(0);
            $table->string('group',3)->nullable();
            $table->string('family',3)->nullable();
            $table->string('subfamily',3)->nullable();
            $table->integer('safety')->default(0);
            $table->string('sourcing')->nullable();
            $table->string('status')->nullable();
            $table->string('abc',1)->nullable();
            $table->string('ean',20)->nullable();
            $table->string('enummer',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

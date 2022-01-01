<?php

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsReplacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_replacements', function (Blueprint $table) {
            $table->timestamps();
            $table->primary(['product_id','replacement_product_id']);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('replacement_product_id');
            $table->text('comment')->nullable();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('replacement_product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_replacements');
    }
}

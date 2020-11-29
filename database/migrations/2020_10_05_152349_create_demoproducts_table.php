<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demoproducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('product_id');
            $table->integer('location_id');
            $table->integer('status_id');
            $table->text('comment')->nullable();
            $table->boolean('original_box')->default(0);
            $table->boolean('original_docs')->default(0);
            $table->boolean('tested')->default(0);
            $table->string('serial')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('version')->nullable();
            $table->integer('used_by_user_id')->nullable();
            $table->integer('used_by_customer_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demoproducts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackDemoproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_demoproducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('demoproduct_id');
            $table->integer('to_location_id');
            $table->integer('from_location_id');
            $table->integer('user_id');
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_demoproducts');
    }
}

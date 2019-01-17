<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->text('address');
            $table->integer('layer_id')->unsigned();
            $table->text('description');
            $table->double('latitude');
            $table->double('longitude');

            $table->foreign('layer_id')
                ->references('id')
                ->on('layers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}

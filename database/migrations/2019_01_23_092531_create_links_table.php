<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');

            $table->double('heading');
            $table->integer('origin_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->unique(['origin_id', 'destination_id']);

            $table->foreign('origin_id')
                ->references('id')
                ->on('panoramas');

            $table->foreign('destination_id')
                ->references('id')
                ->on('panoramas');

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
        Schema::dropIfExists('links');
    }
}

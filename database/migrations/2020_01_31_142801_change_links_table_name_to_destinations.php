<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLinksTableNameToDestinations extends Migration
{
    const TARGET_TABLE_NAME = 'destinations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->rename(static::TARGET_TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(static::TARGET_TABLE_NAME, function (Blueprint $table) {
            $table->rename('links');
        });
    }
}

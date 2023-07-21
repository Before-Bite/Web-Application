<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondTimeColumnInRestaurentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurent', function (Blueprint $table) {
            $table->string('lat')->after('dish_picture');
            $table->string('long')->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurent', function (Blueprint $table) {
            $table->string('lat')->after('dish_picture');
            $table->string('long')->after('lat');
        });
    }
}

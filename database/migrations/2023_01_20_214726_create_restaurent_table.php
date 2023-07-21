<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurent', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('restaurant_name')->nullable();
            $table->string('food_category')->nullable();
            $table->string('food_item')->nullable();
            $table->string('rating')->nullable();
            $table->longText('review')->nullable();
            $table->string('dish_name')->nullable();
            $table->string('dish_picture')->nullable();
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
        Schema::dropIfExists('restaurent');
    }
}

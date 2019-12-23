<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods_cart', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('food_additive_id');
            $table->integer('user_id');
            $table->integer('u_id');
            $table->integer('food_id');
            $table->integer('additive_id');
            $table->integer('count');
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
        Schema::dropIfExists('foods_cart');
    }
}

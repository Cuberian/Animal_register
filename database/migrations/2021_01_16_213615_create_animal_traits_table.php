<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalTraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_traits', function (Blueprint $table) {
            $table->id();
            $table->enum('size',['big','medium','small']);
            $table->enum('category',['cat','dog']);
            $table->enum('wool',['short_wool','long_wool', 'hard_wool', 'сurly_wool']);
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
        Schema::dropIfExists('animal_traits');
    }
}

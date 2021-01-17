<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id('card_id');
            $table->string('animal_name');
            $table->enum('animal_category',['dog', 'cat']);
            $table->boolean('gender');
            $table->date('date_birth');
            $table->integer('identify_mark');
            $table->integer('chip_number');
            $table->string('owner_signs');
            $table->string('municipality');
            $table->string('place');
            $table->string('picture');
            $table->string('scan_frame');
            $table->string('sterilisation_date');
            $table->date('vaccination_date');
            $table->enum('current_status',['0', '1']);
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
        Schema::dropIfExists('cards');
    }
}

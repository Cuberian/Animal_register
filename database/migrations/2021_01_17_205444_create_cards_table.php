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
            $table->id();
            $table->string('animal_name');
            $table->boolean('gender');
            $table->date('date_birth');
            $table->bigInteger('animal_traits_id')->unsigned();
            $table->foreign('animal_traits_id')->references('id')->on('animal_traits');
            $table->integer('identify_mark');
            $table->integer('chip_number');
            $table->string('owner_signs');
            $table->string('animal_signs');
            $table->string('municipality');
            $table->string('place');
            $table->longText('picture')->nullable();
            $table->string('scan_frame_name')->nullable();
            $table->longText('scan_frame')->nullable();
            $table->string('sterilisation_date');
            $table->date('vaccination_date');
            $table->boolean('current_status');
            $table->boolean('publicity_status');
            $table->date('change_status_date');
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

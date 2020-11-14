<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokedexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokedex', function (Blueprint $table) {
            $table->id();
            $table->string('poke_name');
            $table->timestamps();
            $table->bigInteger('poketype_id')->unsigned()->index()->nullable();
            $table->foreign('poketype_id')->references('id')->on('pokedex')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE pokedex AUTO_INCREMENT = 1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokedex');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poke_type', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('type_url');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE poke_type AUTO_INCREMENT = 1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poke_type');
    }
}

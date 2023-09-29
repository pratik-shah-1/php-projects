<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroCardTable extends Migration{

    public function up()
    {
        Schema::create('intro_card', function (Blueprint $table) {
            $table->id();
            $table->text('details');
            $table->timestamps();
        });
    }

    public function down(){

        Schema::dropIfExists('intro_card');
    }
}

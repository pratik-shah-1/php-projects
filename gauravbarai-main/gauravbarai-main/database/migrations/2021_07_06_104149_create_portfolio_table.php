<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioTable extends Migration{

    public function up(){

        Schema::create('portfolio', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->string('title');
            $table->string('icon');
            $table->string('background');
            $table->text('description');
            $table->string('slider_type');
            $table->json('slider_images');
            $table->json('credits');
            $table->json('button_links');
            $table->timestamps();
        });
    }

    public function down(){

        Schema::dropIfExists('portfolio');
    }
}

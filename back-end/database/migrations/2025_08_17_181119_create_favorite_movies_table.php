<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_movies', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->integer('tmdb_id');
            $table->string('title');
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->text('overview')->nullable();
            $table->json('genres')->nullable();
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_movies');
    }
};
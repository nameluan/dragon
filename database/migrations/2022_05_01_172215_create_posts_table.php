<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->string('urlString');
            $table->string('status');
            $table->string('isImage');
            $table->string('isVideo');
            $table->bigInteger('view')->nullable();
            $table->bigInteger('like')->nullable();
            $table->bigInteger('share')->nullable();
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
        Schema::dropIfExists('posts');
    }
};

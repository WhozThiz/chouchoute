<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('authors');
            $table->string('keywords');
            $table->string('abstract');
            $table->string('introduction');
            $table->text('body');
            $table->text('references');
            $table->date('publish_time');
            $table->boolean('publish_status');
            $table->boolean('comment_status');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });

        Schema::create('article_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('article_id');
            $table->string('article_image_path');
            $table->string('article_image_caption')->nullable();
            $table->string('article_image_source')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_images');
    }
}

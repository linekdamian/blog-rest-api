<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->boolean('draft')->default(false);
            $table->bigInteger('category_id');
            $table->timestamps();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('post_id');
            $table->bigInteger('language_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('body')->nullable();
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
        Schema::dropIfExists('post_translations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('user_name');
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            $table->integer('likes')->default(0)->change();
            $table->timestamps();

            // $table->foreign('user_id')
            //         ->references('id')
            //         ->on('users');
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
}

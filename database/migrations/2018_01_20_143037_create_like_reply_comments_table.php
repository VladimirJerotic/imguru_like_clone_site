<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeReplyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_reply_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('reply_comment_id')->unsigned();
            $table->foreign('reply_comment_id')->references('id')->on('reply_comments')->onDelete('cascade');
            $table->boolean('like');
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
        Schema::table('like_reply_comments',function(Blueprint $table){
            $table->dropForeign('like_reply_comments_user_id_foreign');
            $table->dropForeign('like_reply_comments_post_id_foreign');
            $table->dropForeign('like_reply_comments_reply_comment_id_foreign');
        });
        Schema::dropIfExists('like_reply_comments');
    }
}

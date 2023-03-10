<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_replays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('comment')->nullable();
            $table->longText('audio')->nullable();
            $table->longText('image')->nullable();
            $table->enum('type',['text','audio','file']);
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('comment_id');
            $table->enum('user_type',['student','teacher'])->default('student');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('teacher_id')->references('id')->on('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('comment_id')->references('id')->on('comments')->cascadeOnUpdate()->cascadeOnDelete();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_replays');
    }
}

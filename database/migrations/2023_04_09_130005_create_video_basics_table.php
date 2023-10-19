<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //رفع فيديوهات اساسيات الفيزياء لكل المراحل
        Schema::create('video_basics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->integer('time')->comment('زمن الفيديو');
            $table->longText('video_link');
            $table->tinyInteger('like_active')->default(0);
            $table->tinyInteger('view_active')->default(0);
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
        Schema::dropIfExists('video_basics');
    }
}

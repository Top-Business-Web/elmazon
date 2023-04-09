<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoBasicPdfUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //رفع العديد من الملفات ال pdf لفيديوهات اساسيات الفيزياء والمراجعه النهائيه لكل المراحل
        Schema::create('video_basic_pdf_uploads', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->json('pdf_links');
            $table->enum('type', array('video_basic','video_resource'));
            $table->unsignedBigInteger('video_basic_id')->nullable();
            $table->unsignedBigInteger('video_resource_id')->nullable();
            $table->timestamps();
            $table->foreign('video_basic_id')->references('id')->on('video_basics')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('video_resource_id')->references('id')->on('video_resources')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_basic_pdf_uploads');
    }
}

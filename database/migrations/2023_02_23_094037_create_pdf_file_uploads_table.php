<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_file_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('pdf');
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('pdf_file_uploads');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapelSheetExamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papel_sheet_exam_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('papel_sheet_exam_id');
            $table->timestamps();
            $table->foreign('papel_sheet_exam_id')->references('id')->on('papel_sheet_exams')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papel_sheet_exam_users');
    }
}

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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('papel_sheet_exam_id');
            $table->unsignedBigInteger('papel_sheet_exam_time_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('papel_sheet_exam_id')->references('id')->on('papel_sheet_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('papel_sheet_exam_time_id')->references('id')->on('papel_sheet_exam_times')->cascadeOnUpdate()->cascadeOnDelete();

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

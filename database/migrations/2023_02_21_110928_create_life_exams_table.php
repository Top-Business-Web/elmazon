<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLifeExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('life_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->date('date_exam');
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('quiz_minute');
            $table->integer('trying')->default(1);
            $table->integer('degree');
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('term_id')->nullable();
            $table->text('note')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('life_exams');
    }
}

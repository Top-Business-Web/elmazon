<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapelSheetExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papel_sheet_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->date('from');
            $table->date('to');
            $table->enum('status',['open','closed'])->default('open');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('term_id');
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papel_sheet_exams');
    }
}

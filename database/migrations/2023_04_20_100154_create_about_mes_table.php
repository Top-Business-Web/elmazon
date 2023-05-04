<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_mes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_name_ar')->comment('اسم المدرس');
            $table->string('teacher_name_en')->comment('اسم المدرس');
            $table->string('department_ar')->comment('التخصص');
            $table->string('department_en')->comment('التخصص');
            $table->json('qualifications_ar')->comment('المؤهلات');
            $table->json('qualifications_en')->comment('المؤهلات');
            $table->json('experience_ar');
            $table->json('experience_en');
            $table->json('social');
            $table->json('skills_ar')->comment('المهارات');
            $table->json('skills_en')->comment('المهارات');
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
        Schema::dropIfExists('about_mes');
    }
}

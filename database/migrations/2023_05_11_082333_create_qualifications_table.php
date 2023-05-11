<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_name_ar')->comment('اسم المدرس بالعربي');
            $table->string('teacher_name_en')->comment('اسم المدرس بالانجليزي');
            $table->string('department_ar')->comment('اسم التخصص بالعربي');
            $table->string('department_en')->comment('اسم التخصص بالانجليزي');
            $table->json('qualifications_ar')->comment('المؤهلات بالعربي');
            $table->json('qualifications_en')->comment('المؤهلات بالانجليزي');
            $table->json('experience_ar');
            $table->json('experience_en');
            $table->json('skills_ar')->comment('المهارات بالعربي');
            $table->json('skills_en')->comment('المهارات بالانجليزي');
            $table->text('facebook_link');
            $table->text('youtube_link');
            $table->text('instagram_link');
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
        Schema::dropIfExists('qualifications');
    }
}

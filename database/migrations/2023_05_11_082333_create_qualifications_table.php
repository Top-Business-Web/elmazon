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
            $table->enum('type',['qualifications','experience','skills']);
            $table->text('qualifications_title_ar');
            $table->text('qualifications_title_en');
            $table->text('qualifications_description_ar');
            $table->text('qualifications_description_en');
            $table->string('qualifications_year')->nullable();

            $table->text('experience_title_ar');
            $table->text('experience_title_en');
            $table->text('experience_description_ar');
            $table->text('experience_description_en');
            $table->string('experience_year')->nullable();


            $table->text('skills_title_ar');
            $table->text('skills_title_en');
            $table->text('skills_description_ar');
            $table->text('skills_description_en');
            $table->string('skills_year')->nullable();


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

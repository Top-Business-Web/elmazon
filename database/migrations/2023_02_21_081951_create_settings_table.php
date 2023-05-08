<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('facebook_link');
            $table->text('youtube_link');
            $table->text('twitter_link');
            $table->text('instagram_link');
            $table->text('website_link');
            $table->json('share_ar');
            $table->json('share_en');
            $table->enum('lang',['not_active', 'active'])->default('not_active');
            $table->enum('videos_resource_active',['not_active', 'active'])->default('not_active');
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
        Schema::dropIfExists('settings');
    }

    protected $casts = [

        'share_ar' => 'json',
        'share_en' => 'json',

    ];
}

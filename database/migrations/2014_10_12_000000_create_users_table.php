<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('country_id');
            $table->string('phone');
            $table->string('father_phone');
            $table->enum('user_type',['student','teacher'])->default('student');
            $table->longText('image')->nullable();
            $table->enum('login_status',['login','logout'])->default('login');
            $table->enum('user_status',['active','not_active'])->default('active');
            $table->string('code')->unique();
            $table->date('date_start_code')->comment('تاريخ بدايه الاشتراك');
            $table->date('date_end_code')->comment('تاريخ نهايه الاشتراك');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegreeAndDegreeStatusToOnlineExamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_exam_users', function (Blueprint $table) {

            $table->integer('degree')->default(0)->after('life_exam_id');
            $table->enum('degree_status',['completed'])->after('degree')->default('completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_exam_users', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegreeAndDegreeStatusToTextExamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('text_exam_users', function (Blueprint $table) {

            $table->integer('degree')->default(0)->after('answer_type');
            $table->enum('degree_status',['completed','un_completed'])->after('degree')->default('un_completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_exam_users', function (Blueprint $table) {
            //
        });
    }
}

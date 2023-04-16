<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndPdfToVideoResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_resources', function (Blueprint $table) {

            $table->enum('type',['video','pdf'])->after('video_link')->default('video');
            $table->text('pdf_file')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_resources', function (Blueprint $table) {
            //
        });
    }
}

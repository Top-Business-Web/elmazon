<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoBasicIdAndVideoResourceIdToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {

            $table->unsignedBigInteger('video_basic_id')->nullable()->after('video_part_id');
            $table->unsignedBigInteger('video_resource_id')->nullable()->after('video_basic_id');
            $table->foreign('video_basic_id')->references('id')->on('video_basics')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('video_resource_id')->references('id')->on('video_resources')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
}

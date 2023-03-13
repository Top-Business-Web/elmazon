<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('price_in_center',10,2);
            $table->double('price_out_center',10,2);
            $table->integer('month');
            $table->enum('free',['yes','no'])->default('no');
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
        Schema::dropIfExists('subscribes');
    }
}

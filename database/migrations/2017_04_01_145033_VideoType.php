<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideoType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->index()->comment("类型名称");
            $table->string('remark')->default('')->comment("备注");
            $table->integer('sort')->default(0)->comment("排序");
            $table->integer('status')->default(1)->comment("状态：1正常");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_types');
    }
}

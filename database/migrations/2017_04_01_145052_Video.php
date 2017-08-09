<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Video extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->increments('id');
            $table->string('title')->nullable()->index()->comment("标题");
            $table->integer('type_id')->default(1)->comment("类型ID");
            $table->string('parse_type')->nullable()->comment("类型ID");
            $table->string('source_url')->nullable()->comment("资源地址");
            $table->string('thumb')->nullable()->comment("缩略图");
            $table->string('file_url')->nullable()->comment("文件地址");
            $table->string('remark')->nullable()->comment("备注");
            $table->integer('sort')->default(0)->comment("排序");
            $table->integer('status')->default(1)->comment("状态：1正常");
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
        Schema::dropIfExists('videos');
    }
}

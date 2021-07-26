<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 微信公众平台-媒体管理
 *
 * Class CreateWechatMaterialsTable
 */
class CreateWechatMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('素材标题');
            $table->string('type')->default('image')->comment('素材类型 image video voice thumb');
            $table->string('file_path')->comment('素材本地路径');
            $table->string('oss_url')->nullable()->comment('OSS 文件地址');
            $table->string('media_id')->nullable()->comment('微信素材编号');
            $table->string('media_url')->nullable()->comment('微信素材地址 只有 image 时才有');
            $table->softDeletes();
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
        Schema::dropIfExists('wechat_materials');
    }
}

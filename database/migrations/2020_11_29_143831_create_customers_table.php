<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('unionid')->comment('统一编号');
            $table->string('openid')->nullable()->comment('小程序OPENID');
            $table->string('mp_openid')->nullable()->comment('公众号OPENID');
            $table->string('session_key')->nullable()->comment('小程序解密秘钥');
            $table->string('phone')->nullable()->comment('手机号码');
            $table->string('nickname')->nullable()->comment('微信昵称');
            $table->string('avatar_url')->nullable()->comment('头像');
            $table->dateTime('subscribe_time')->nullable()->comment('关注时间');
            $table->string('subscribe_scene')->nullable()->comment('关注渠道来源');
            $table->string('qr_scene')->nullable()->comment('二维码扫码场景');
            $table->string('qr_scene_str')->nullable()->comment('二维码扫码场景描述');
            $table->string('microapp_scene')->nullable()->comment('小程序场景');
            $table->string('qrcode_url')->nullable()->comment('小程序码');
            $table->string('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('customers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 短信发送状态表
 *
 * Class CreateSmsSendMessageReportsTable
 */
class CreateSmsSendMessageReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_send_message_reports', function (Blueprint $table) {
            $table->id();
            $table->char('message_uuid', 32)->comment('唯一消息 ID');
            $table->string('task_id')->comment('短信发送任务编号');
            $table->string('code')->comment('状态码');
            $table->string('message')->comment('状态描述');
            $table->string('phone')->comment('手机号码');
            $table->dateTime('received_time')->comment('接收时间');
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
        Schema::dropIfExists('sms_send_message_reports');
    }
}

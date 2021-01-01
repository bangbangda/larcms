<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 短信内容表
 *
 * Class CreateSmsSendMessagesTable
 */
class CreateSmsSendMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_send_messages', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 32)->comment('唯一消息ID');
            $table->string('content')->comment('短信内容');
            $table->string('state')->nullable()->comment('发送状态');
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
        Schema::dropIfExists('sms_send_messages');
    }
}

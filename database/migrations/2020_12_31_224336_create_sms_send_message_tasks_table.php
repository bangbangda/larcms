<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 短信系统任务管理表
 *
 * Class CreateSmsSendMessageTasksTable
 */
class CreateSmsSendMessageTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_send_message_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sms_send_message_id')->comment('短信发送编号');
            $table->string('task_id')->comment('任务编号');
            $table->integer('total')->default(1)->comment('发送数量');
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
        Schema::dropIfExists('sms_send_message_tasks');
    }
}

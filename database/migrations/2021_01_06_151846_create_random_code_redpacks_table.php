<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 随机码红包
 *
 * Class CreateRandomCodeRedpacksTable
 */
class CreateRandomCodeRedpacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('random_code_redpacks', function (Blueprint $table) {
            $table->id();
            $table->char('code', 13)->comment('随机领取码');
            $table->integer('amount')->default('888')->comment('红包金额 单位 分');
            $table->dateTime('receive_time')->nullable()->comment('领取时间');
            $table->bigInteger('customer_id')->nullable()->comment('领取人编号');
            $table->string('nickname', 50)->nullable()->comment('领取人昵称');
            $table->string('receive_status', 10)->nullable()->comment('领取状态 success error');
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
        Schema::dropIfExists('random_code_redpacks');
    }
}

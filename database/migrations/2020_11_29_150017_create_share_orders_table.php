<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->comment('客户编号');
            $table->integer('sub_customer_id')->comment('下级用户编号');
            $table->string('sub_openid')->comment('下级用户小程序openid');
            $table->boolean('pay_state')->default(false)->comment('支付状态');
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
        Schema::dropIfExists('share_orders');
    }
}

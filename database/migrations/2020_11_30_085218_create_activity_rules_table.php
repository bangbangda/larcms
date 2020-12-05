<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['title', 'detail'])->default('detail')->comment('规则标题');
            $table->string('image_url')->comment('规则图片');
            $table->tinyInteger('sort_order')->comment('排序');
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
        Schema::dropIfExists('activity_rules');
    }
}

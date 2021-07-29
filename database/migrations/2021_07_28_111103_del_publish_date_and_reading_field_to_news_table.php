<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 新闻表
 * 删除发布时间和阅读量字段
 *
 * Class DelPublishDateAndReadingFieldToNewsTable
 */
class DelPublishDateAndReadingFieldToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['publish_date', 'reading']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->date('publish_date')->after('cover_url')->comment('发布时间');
            $table->integer('reading')->after('publish_date')->comment('阅读量');
        });
    }
}

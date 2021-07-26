<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 获取小程序新增或活跃用户的画像分布数据
 *   性别分布
 *
 * Class UserPortraitGender
 * @package App\Models
 */
class UserPortraitGender extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_portrait_id', 'name', 'visit_uv'];
}

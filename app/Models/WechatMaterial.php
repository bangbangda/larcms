<?php

namespace App\Models;

use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 微信素材管理
 *   图片、视频、语音和缩略图
 *
 * Class WechatMaterial
 * @package App\Models
 */
class WechatMaterial extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['title', 'type', 'file_path'];
}

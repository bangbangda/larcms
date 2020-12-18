<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * 获取小程序新增或活跃用户的画像分布数据
 *
 * Class UserPortrait
 * @package App\Models
 */
class UserPortrait extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'date_type', 'ref_date'];

    /**
     * 年龄分布
     *   包括17岁以下、18-24岁等区间
     *
     * @return HasMany
     */
    public function ages(): HasMany
    {
        return $this->hasMany('App\Models\UserPortraitAge');
    }

    /**
     * 性别分布
     *   男 女 未知
     *
     * @return HasMany
     */
    public function genders(): HasMany
    {
        return $this->hasMany('App\Models\UserPortraitGender');
    }

    /**
     * 平台分布
     *   Android IOS
     *
     * @return HasMany
     */
    public function platforms(): HasMany
    {
        return $this->hasMany('App\Models\UserPortraitPlatform');
    }

    /**
     * 设备分布
     *   iPhone HuaWei等
     *
     * @return HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany('App\Models\UserPortraitDevice');
    }
}

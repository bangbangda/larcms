<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 获取用户关注公众号数据概况
 *
 * Class MpDailySummary
 * @package App\Models
 */
class MpDailySummary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ref_date', 'user_source', 'new_user', 'cancel_user', 'cumulate_user'];
}

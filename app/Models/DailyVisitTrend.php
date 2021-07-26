<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 获取用户访问小程序数据日趋势
 *
 * Class DailyVisitTrend
 * @package App\Models
 */
class DailyVisitTrend extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type', 'ref_date', 'session_cnt', 'visit_pv', 'visit_uv', 'visit_uv_new',
        'stay_time_uv', 'stay_time_session', 'visit_depth'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 用户访问小程序数据概况
 *
 * Class DailySummary
 * @package App\Models
 */
class DailySummary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ref_date', 'visit_total', 'share_pv', 'share_uv'];
}

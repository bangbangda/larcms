<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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


    /**
     * 获取小程序用户及分享数据
     *
     * @return array
     */
    public function weekData() : array
    {
        $data = $this->select('ref_date', 'visit_total', 'share_pv', 'share_uv')
            ->orderBy('ref_date')
            ->limit(7)
            ->get();

        $weekData = [];
        foreach ($data as $val) {
            $weekData['ref_date'][] = Str::substr($val['ref_date'], 5);
            $weekData['visit_total'][] = $val['visit_total'];
            $weekData['share_pv'][] = $val['share_pv'];
            $weekData['share_uv'][] = $val['share_uv'];
        }

        return $weekData;
    }
}

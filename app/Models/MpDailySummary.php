<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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


    /**
     * 最近一周的用户关注数据
     *
     * @return array
     */
    public function weekData() : array
    {
        $data = $this->select('ref_date', DB::raw('sum(new_user), sum(cancel_user), max(cumulate_user)'))
            ->groupBy('ref_date')
            ->orderBy('ref_date')
            ->limit(7)
            ->get();

        $weekData = [];
        foreach ($data as $val) {
            $weekData['ref_date'][] = Str::substr($val['ref_date'], 5);
            $weekData['new_user'][] = $val['sum(new_user)'];
            $weekData['cancel_user'][] = $val['sum(cancel_user)'];
            $weekData['cumulate_user'][] = $val['max(cumulate_user)'];
        }

        return $weekData;
    }
}

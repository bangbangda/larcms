<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TransferLog extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * 获取支付状态
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return is_null($this->payment_no) ? 'error' : 'success';
    }

    /**
     * 红包总计
     *
     * @return array
     */
    public function scopeTotalRedpack() : array
    {
        $totalQuantity = $this->whereNotNull('payment_no')->count();
        $totalAmount = $this->whereNotNull('payment_no')->sum('amount') / 100;

        return compact('totalQuantity', 'totalAmount');
    }

    /**
     * 发放红包周数据图标
     *
     * @return array
     */
    public function weekData() : array
    {
        $data = $this->select('type', DB::raw("count(type) as num, sum(amount)  / 100 as amount, date(created_at) as create_date"))
            ->whereNotNull('payment_no')
            ->whereDate('created_at', '>',  Carbon::parse('-7 days')->toDateString())
            ->groupBy('type')
            ->groupBy('create_date')
            ->orderBy('create_date')
            ->get();

        // 时间
        $sendDate = array_values(array_unique(Arr::pluck($data, 'create_date')));

        $basisData = [];
        $teamData = [];
        $newcomerData = [];

        foreach ($data as $val) {
            switch ($val['type']) {
                case 'basis':
                    $basisData[] = $val['amount'];
                    break;
                case 'team':
                    $teamData[] = $val['amount'];
                    break;
                case 'newcomer':
                    $newcomerData[] = $val['amount'];
                    break;
            }
        }

        return compact('sendDate', 'basisData', 'teamData', 'newcomerData');
    }
}

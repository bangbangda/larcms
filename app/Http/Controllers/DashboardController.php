<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DailySummary;
use App\Models\MpDailySummary;
use App\Models\TransferLog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // 红包信息
        $totalRedpack = TransferLog::totalRedpack();
        // 总用户数
        $totalUser = Customer::totalUser();
        // 小程序用户数
        $dailySummary = DailySummary::latest()->first();
        // 公众号图表数据
        $mpDailySummary = new MpDailySummary();
        $mpWeekData = $mpDailySummary->weekData();
        // 小程序图表数据
        $miniWeekData = (new DailySummary)->weekData();

        return view('dashboard', compact(
            'totalRedpack', 'totalUser', 'dailySummary', 'mpWeekData', 'miniWeekData'
        ));
    }



}

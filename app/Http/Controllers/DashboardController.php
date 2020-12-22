<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DailySummary;
use App\Models\TransferLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $totalRedpack = TransferLog::totalRedpack();

        $totalUser = Customer::totalUser();

        $dailySummary = DailySummary::latest()->first();

        return view('dashboard', compact('totalRedpack', 'totalUser', 'dailySummary'));
    }



}

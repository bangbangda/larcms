<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 短信发送回调
 *
 * Class SmsReportController
 * @package App\Http\Controllers
 */
class SmsReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Log::debug($request->post());
        Log::debug($request->all());
        Log::debug($request->all());
    }
}

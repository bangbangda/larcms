<?php

namespace App\Http\Controllers;

use App\Models\SmsSendMessageReport;
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
        // 保存发送报告数据
        $reportModel = new SmsSendMessageReport();
        $reportModel->insert($this->getInsertData($request->post()));

        echo 'SUCCESS';
    }


    /**
     * 重新整理发送报告数据
     *
     * @param  array  $reports
     * @return array
     */
    private function getInsertData(array $reports) : array
    {
        $insertData = [];
        foreach ($reports as $report) {
            $insertData[] = [
                'message_uuid' => $report['messageid'],
                'task_id' => $report['taskid'],
                'code' => $report['code'],
                'message' => $report['msg'],
                'phone' => $report['mobile'],
                'received_time' => $report['time'],
            ];
        }

        return $insertData;
    }
}

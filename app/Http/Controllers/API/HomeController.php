<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\HomeRequest;
use App\Models\Banner;
use App\Models\Customer;
use App\Models\CustomerIncome;
use App\Models\GroupRedPacket;
use App\Models\House;
use App\Models\News;
use App\Models\RandomCodeRedpack;
use App\Models\TransferLog;
use App\Services\Wechat\TransferMoney;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'banners' => Banner::select('jump_path', 'jump_url', 'image_url')->orderBy('weight')->get(),
            'houses' => (new House())->homeData(),
            'news' => News::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * 发放随机码红包红包
     *
     * @param  HomeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function randomCodeRedpack(HomeRequest $request)
    {
        // 验证是否关注公众号
        if (is_null($request->user()->mp_openid)) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => ['请先关注公众号在来领取红包'],
                    'code' => 'E10002',
                ])
            );
        }

        $randomCode = $request->post('randomCode');

        if (! Cache::tags('randomCode')->has($randomCode) &&
            ! Cache::tags('randomCode')->has($request->user()->id)) {

            try {
                // 获取红包金额
                $amount = (new RandomCodeRedpack())->getAmount($randomCode);

                // 发放红包
                $pay = new TransferMoney(Customer::find($request->user()->id));
                $logId = $pay->toBalance($amount, 'video');

                $transferLog = TransferLog::find($logId);

                if ($transferLog->status == 'success') {
                    Cache::tags('randomCode')->put($randomCode, 'true');
                    Cache::tags('randomCode')->put($request->user()->id, 'true');
                }

                RandomCodeRedpack::where('code', $randomCode)
                    ->update([
                        'amount' => $transferLog->amount,
                        'receive_time' => $transferLog->payment_time,
                        'customer_id' => $request->user()->id,
                        'nickname' => $request->user()->nickname,
                        'receive_status' => $transferLog->status,
                    ]);

                return response()->json([
                    'status' => $transferLog->status,
                    'message' => $transferLog->status == 'success' ? '红包领取成功' : '红包领取失败',
                ]);
            } catch (ModelNotFoundException $ex) {
                Log::error("随机红包码查询失败。 {$randomCode}");

                throw new HttpResponseException(
                    response()->json([
                        'errors' => ['随机红包码查询失败'],
                        'code' => 'E10001',
                    ])
                );
            }
        } else {
            throw new HttpResponseException(
                response()->json([
                    'errors' => ['您已经领过红包啦'],
                    'code' => 'E20001',
                ])
            );
        }
    }

    /**
     * 小程序端保存海报成功通知
     */
    public function saveImageNotification(Request $request)
    {
        $customer = $request->user();
        // 参与活动时间在指定日期之前
        if ($customer->created_at > '2021-09-01 00:00:00') {
            return ;
        }

        // 已经关注公众号且绑定手机号
        if (! $customer->hasSubscribeMp() && ! $customer->hasBindPhone()) {
            return ;
        }

        // 已经分享过海报且得过红包
        if (CustomerIncome::where('customer_id' , $customer->id)->doesntExist()) {
            return ;
        }

        $key = 'group.'.$customer->id;

        if (! Cache::tags('group')->has($key)) {
            Cache::tags('group')->put($key, time());
            // 记录裂变红包数据
            GroupRedPacket::create([
                'bill_no' => Str::random(),
                'openid' => $customer->mp_openid,
                'total_amount' => 666,
                'total_num' => 6,
            ]);
        }
    }
}

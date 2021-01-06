<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\HomeRequest;
use App\Models\Customer;
use App\Models\News;
use App\Models\PopupAd;
use App\Models\RandomCodeRedpack;
use App\Models\ShareImage;
use App\Models\TransferLog;
use App\Services\Wechat\TransferMoney;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        $images = ShareImage::select('url')->active()->get();

        $news = News::orderBy('publish_date', 'desc')->get();

        $popupAd = PopupAd::select(['url', 'auto_close', 'close_second'])->active()->first();

        return response()->json([
            'customer' => [
                'id' => $request->user()->id,
                'avatar_url' => $request->user()->avatar_url,
                'qrCode' => $request->user()->qrcode_url
            ],
            'headImage' => 'https://larcms.bangbangda.me/storage/P2Ang8E2H9.jpg',
            'popupAd' => $popupAd ?? [],
            'shareImages' => $images,
            'news' => $news
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
}

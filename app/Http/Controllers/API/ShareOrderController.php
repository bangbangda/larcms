<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShareOrder;
use App\Services\GdIpSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * 邀请记录
 *   绑定上下级关系
 *
 * Class ShareOrderController
 * @package App\Http\Controllers\API
 */
class ShareOrderController extends Controller
{

    /**
     * 邀请记录列表
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = $request->user();

        $orders = $customer->shareOrders()->with('customer')->paginate();

        foreach ($orders as &$order) {
            $order['nickname'] = $order->customer->nickname ?? '神秘人';
            unset($order['customer']);
        }

        return response()->json(array_merge(['data' => $orders->toArray()['data']], [
            'total' => $orders->total(),
            'hasMorePages' => $orders->hasMorePages()
        ]));
    }

    /**
     * 保存邀请记录
     *
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        $customer = $request->user();
        // 上级用户编号
        $parentUserId = request()->post('parent_id') ?? null;

        if (! is_null($parentUserId) &&
            ! Cache::tags('share')->has($customer->openid) &&
            ! Cache::tags('black')->has($request->ip())) {

            Cache::tags('share')->put($customer->openid, 1);

            // IP地址查询
            $ipSearch = new GdIpSearch();
            $ipInfo = $ipSearch->getInfo($request->ip());

            if ($ipInfo['city'] == '包头市') {
                ShareOrder::firstOrCreate([
                    'sub_openid' => $customer->openid,
                ], [
                    'customer_id' => $parentUserId,
                    'sub_customer_id' => $customer->id,
                ]);
            } else {
                Cache::tags('black')->put($request->ip(), "1");
            }
        }
    }
}

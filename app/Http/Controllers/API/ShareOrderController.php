<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShareOrder;
use Illuminate\Http\Request;

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

        $parentUserId = request()->post('parent_id') ?? null;
        if (! is_null($parentUserId)) {
            ShareOrder::firstOrCreate([
                'sub_openid' => $customer->openid,
            ], [
                    'customer_id' => $parentUserId,
                    'sub_customer_id' => $customer->id,
            ]);
        }
    }
}

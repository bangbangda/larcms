<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShareOrderCollection;
use App\Models\ShareOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShareOrderController extends Controller
{

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
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerRequest;
use App\Models\Customer;
use App\Models\ShareOrder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(CustomerRequest $request)
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        $wxUser = $miniApp->auth->session($request->post('code'));

        $wxUser= $this->initWxUser();

        if (isset($wxUser['errcode']) && !empty($wxUser['errcode'])) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => [$wxUser['errmsg']],
                    'code' => $wxUser['errcode']
                ])
            );
        }

        $customer = Customer::firstOrCreate(
            ['unionid' => $wxUser['unionid']],
            [
                'openid' => $wxUser['openid'],
                'session_key' => $wxUser['session_key'],
            ]
        );

        $this->shareOrder($customer->id);

        return response()->json([
            'token' => $customer->updateToken('mini-app')->plainTextToken,
            'bindPhone' => $customer->hasBindPhone(),
            'bindMp' => $customer->hasBindMp(),
        ]);
    }

    /**
     * 保存上级分享者
     *
     * @param  int  $customerId
     */
    private function shareOrder(int $customerId)
    {
        $parentUserId = request()->post('parent_id') ?? null;
        if (! is_null($parentUserId)) {
            ShareOrder::firstOrCreate([
                    'customer_id' => $parentUserId,
                    'sub_customer_id' => $customerId
                ]
            );
        }
    }


    private function initWxUser() {
        return [
            'openid' => '555',
            'unionid' => '555',
            'session_key' => '555'
        ];
    }


}

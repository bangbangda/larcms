<?php

namespace App\Http\Controllers\API;

use App\Events\CustomerPhoneBound;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerRequest;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ShareOrder;
use App\Http\Resources\ProjectResource;
use App\Services\Wechat\TransferMoney;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  CustomerRequest  $request
     * @return JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(CustomerRequest $request)
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        $wxUser = $miniApp->auth->session($request->post('code'));

        if (isset($wxUser['errcode']) && !empty($wxUser['errcode'])) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => [$wxUser['errmsg']],
                    'code' => $wxUser['errcode']
                ])
            );
        }
        // 创建用户
        $customer = Customer::firstOrCreate([
                'unionid' => $wxUser['unionid']
            ], [
                'openid' => $wxUser['openid'],
                'session_key' => $wxUser['session_key'],
            ]
        );
        // 更新用户小程序 session_key
        $customer->update([
            'session_key' => $wxUser['session_key']
        ]);

        $this->shareOrder($customer->id);
        Log::debug('token->' . $customer->updateToken('mini-app')->plainTextToken);
        return response()->json([
            'token' => $customer->updateToken('mini-app')->plainTextToken,
            'bindPhone' => $customer->hasBindPhone(),
            'bindMp' => $customer->hasSubscribeMp(),
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
                    'sub_customer_id' => $customerId
                ], [
                    'customer_id' => $parentUserId,
                ]
            );
        }
    }

    /**
     * 解密手机号
     *
     * @param  CustomerRequest  $request
     */
    public function decryptPhone(CustomerRequest $request)
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));
        Log::debug($request->post());
        try {
            $customer = $request->user();

            $decryptedData = $miniApp->encryptor->decryptData(
                $customer->session_key, $request->post('iv'), $request->post('encryptedData')
            );
            // 更新手机号码
            $customer->update([
                'phone' => $decryptedData['phoneNumber']
            ]);

            // 触发绑定手机号事件
            event(new CustomerPhoneBound($customer));

        } catch (DecryptException $e) {
            Log::error('解密手机号码失败：' . $e->getMessage());
            throw new HttpResponseException(
                response()->json([
                    'errors' => ['解密手机号码失败'],
                    'code' => '10023'
                ])
            );
        }
    }

    /**
     * 是否关注公众号
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function hasSubscribeMp(Request $request)
    {
        return response()->json([
            'hasSubscribeMp' => $request->user()->hasSubscribeMp(),
            'customer' => [
                'id' => $request->user()->id,
                'avatar_url' => $request->user()->avatar_url,
                'qrCode' => $request->user()->qrcode_url
            ]
        ]);
    }

    /**
     * 个人中心
     *
     * @param  Request  $request
     */
    public function show(Request $request)
    {
        $customer = $request->user();
        return response()->json([
            'customer' => [
                'nickname' => $customer->nickname,
                'avatar_url' => $customer->avatar_url,
                'income' => $customer->income->amount ?? 0
            ],
            'project' => new  ProjectResource(Project::first())
        ]);
    }
}

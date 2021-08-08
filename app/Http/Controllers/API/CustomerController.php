<?php

namespace App\Http\Controllers\API;

use App\Events\CustomerPhoneBound;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerRequest;
use App\Models\Customer;
use App\Models\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Services\GdIpSearch;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        if (Customer::where('unionid', $wxUser['unionid'])->exists()) {
            Customer::where('unionid', $wxUser['unionid'])->update([
                'openid' => $wxUser['openid'],
                'session_key' => $wxUser['session_key']
            ]);

            $notParentId = Customer::where('unionid', $wxUser['unionid'])
                ->whereNull('parent_id');

            if ($notParentId->exists()) {
                $notParentId->update(['parent_id' => $request->post('parent_id')]);
            }
        } else {
            Customer::create([
                'unionid' => $wxUser['unionid'],
                'openid' => $wxUser['openid'],
                'session_key' => $wxUser['session_key'],
                'parent_id' => $request->post('parent_id')
            ]);
        }
        $customer = Customer::where('unionid', $wxUser['unionid'])->first();

        Log::debug('token->' . $customer->updateToken('mini-app')->plainTextToken);
        return response()->json([
            'token' => $customer->updateToken('mini-app')->plainTextToken,
            'bindPhone' => $customer->hasBindPhone(),
            'bindMp' => $customer->hasSubscribeMp(),
            'distance' => 32 * 1000, // 可领取红包距离 单位米
        ]);
    }

    /**
     * 解密手机号
     *
     * @param  CustomerRequest  $request
     */
    public function decryptPhone(CustomerRequest $request)
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        try {
            $customer = $request->user();
            Log::debug("解密手机号: {$request->ip()} {$request->userAgent()} {$customer->id}" );

            $decryptedData = $miniApp->encryptor->decryptData(
                $customer->session_key, $request->post('iv'), $request->post('encryptedData')
            );

            // 更新手机号码
            $customer->update([
                'phone' => $phone = $decryptedData['phoneNumber'],
            ]);
            Log::debug("手机号: {$phone}");

            // 屏蔽非常州市IP发放红包 && 一个手机号只发一次
            if (! Cache::tags('black')->has($request->ip()) &&
                ! Cache::tags('phone')->has($phone)) {

                Cache::tags('phone')->put($phone, "1");

                // IP地址验证
                $ipSearch = new GdIpSearch();

                if ($ipSearch->isValid($request->ip())) {
                    // 触发绑定手机号事件
                    event(new CustomerPhoneBound($customer));
                } else {
                    Cache::tags('black')->put($request->ip(), "1");
                }
            }
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
     * 通过 code 判断是否关注公众号
     *
     * @param  CustomerRequest  $request
     * @return JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function hasSubscribeMpByCode(CustomerRequest $request)
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        $wxUser = $miniApp->auth->session($request->post('code'));

        return response()->json([
            'hasSubscribeMp' => Customer::where('openid', $wxUser['openid'])
                ->first()
                ->hasSubscribeMp()
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
                'income' => $customer->income->amountRmb ?? 0
            ],
            'project' => new ProjectResource(Project::first())
        ]);
    }
}

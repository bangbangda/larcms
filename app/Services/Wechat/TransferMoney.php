<?php
namespace App\Services\Wechat;

use App\Models\Customer;
use App\Models\CustomerIncome;
use App\Models\ShareOrder;
use App\Models\TransferLog;
use EasyWeChat\Factory;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 微信转账
 *
 * Class TransferMoney
 * @package App\Services\Wechat
 */
class TransferMoney
{

    private $miniApp;

    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->miniApp = Factory::payment(config('wechat.pay'));
        $this->customer = $customer;
    }


    /**
     * 微信转账功能
     *   调用微信企业付款接口
     *
     * @param  int  $amount
     * @param  string  $type
     * @return int
     */
    public function toBalance(int $amount, string $type): int
    {
        if (is_null($this->customer)) {
            Log::error('发放红包出错，未找到用户');
            throw new HttpResponseException(
                response()->json([
                    'errors' => ['发放红包出错，未找到用户'],
                    'code' => 'E10002',
                ])
            );
        }

        Log::debug("开始发放红包 {$type} {$this->customer->mp_openid}");

        $result = $this->miniApp->transfer->toBalance([
            'partner_trade_no' => $tradeNo = Str::random(10), // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $this->customer->mp_openid,
            'check_name' => 'NO_CHECK',
            'amount' => $amount, // 付款金额，单位为分
            'desc' => $this->getTypeName($type), // 企业付款操作说明信息。必填
        ]);

        if ($this->isSuccess($result)) {
            // 增加用户收益金额
            $income = CustomerIncome::firstOrCreate([
                'customer_id' => $this->customer->id
            ], [
                'amount' => $amount
            ]);

            if (! $income->wasRecentlyCreated) {
                $income->update([
                    'amount' => $income->amount + $amount
                ]);
            }
            // 更新付款状态
            if ($type == 'basis') {
                ShareOrder::where([
                    'sub_openid' => $this->customer->openid
                ])->update([
                    'pay_state' => 1
                ]);
            }
        }

        // 创建转账日志
        return $this->createLog($result, $amount, $type);
    }


    /**
     * 创建转账日志
     *
     * @param  array  $result
     * @param  int  $amount
     * @param  string  $type
     * @return int
     */
    private function createLog(array $result, int $amount, string $type): int
    {
        $transferLog = new TransferLog;
        $transferLog->customer_id = $this->customer->id;
        $transferLog->amount = $amount;
        $transferLog->type = $type;
        if ($this->isSuccess($result)) {
            $transferLog->payment_no = $result['payment_no'];
            $transferLog->payment_time = $result['payment_time'];
        }
        $transferLog->api_result = json_encode($result);

        $transferLog->save();

        return $transferLog->id;
    }


    /**
     * 确认接口是否执行成功
     *
     * @param  array  $result
     * @return bool
     */
    private function isSuccess(array $result) : bool
    {
        Log::debug($result);

        return $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }

    /**
     * 获取红包类型名称
     *    12-07： 红包备注统一了，不需要根据类型单独设置
     *
     * @param  string  $type
     * @return string
     */
    private function getTypeName(string $type) : string
    {
        switch ($type) {
            case 'newcomer' :
            case 'top' :
            case 'basis' :
                return '汝悦春秋分享红包礼';
            case 'team':
                return '汝悦春秋分享红包礼（团队红包）';
            default :
                return '';
        }
    }
}
<?php
namespace App\Services\Wechat;

use App\Models\Customer;
use App\Models\TransferLog;
use EasyWeChat\Factory;
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
     */
    public function toBalance(int $amount, string $type)
    {

        $result = $this->miniApp->transfer->toBalance([
            'partner_trade_no' => $tradeNo = Str::random(10), // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $this->customer->mp_openid,
            'check_name' => 'NO_CHECK',
            'amount' => $amount, // 付款金额，单位为分
            'desc' => $this->getTypeName($type), // 企业付款操作说明信息。必填
        ]);

        Log::debug($result);
        // 创建转账日志
        $this->createLog($result, $amount, $type);
    }


    /**
     * 创建转账日志
     *
     * @param  array  $result
     * @param  int  $amount
     * @param  string  $type
     */
    private function createLog(array $result, int $amount, string $type)
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
    }


    /**
     * 确认接口是否执行成功
     *
     * @param  array  $result
     * @return bool
     */
    private function isSuccess(array $result) : bool
    {
        return $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }

    /**
     * 获取红包类型名称
     *
     * @param  string  $type
     * @return string
     */
    private function getTypeName(string $type) : string
    {
        switch ($type) {
            case 'newcomer' :
                return '新人红包';
            case 'top' :
                return '排行榜红包';
            case 'basis' :
                return '分享红包';
            default :
                return '';
        }
    }
}
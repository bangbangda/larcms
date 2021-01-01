<?php
namespace App\Services;

use App\Models\SmsSendMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * 微格短信接口
 *
 * Class VgSms
 * @package App\Services
 */
class VgSms
{
    // 接口网关
    private string $apiUrl = 'http://47.110.195.237:8081';

    /**
     * 发送短信
     *   支持批量进件，单次最多支持1000个手机号
     *
     * @param  SmsSendMessage  $message 短信内容
     * @param  array  $mobile  接受手机号码
     * @return array 结果
     */
    public function send(SmsSendMessage $message, array $mobile) : array
    {
        $result = Http::asForm()->post($this->apiUrl . '/api/sms/send', [
            'userid' => config('vgsms.user_id'),
            'ts' => $ts = Carbon::now()->getPreciseTimestamp(3),
            'sign' => $this->generateSign($ts),
            'mobile' => implode(',', $mobile),
            'msgcontent' => $message->content,
            'messageid' => $message->uuid,
        ])->json();

        if ($result['code'] > 0) {
            Log::error("短信发送失败：{$result['msg']}");
        }

        return $result;
    }


    /**
     * 短信剩余条数查询
     *
     * @return array
     */
    public function balance() : array
    {
        $result = Http::asForm()->post($this->apiUrl . '/api/sms/balance', [
            'userid' => config('vgsms.user_id'),
            'ts' => $ts = Carbon::now()->getPreciseTimestamp(3),
            'sign' => $this->generateSign($ts),
        ])->json();

        if ($result['code'] > 0) {
            Log::error("短信剩余条数查询失败：{$result['msg']}");
        }

        return $result;
    }

    /**
     * 短信内容敏感词验证
     *
     * @param  string  $content 短信内容
     * @return array
     */
    public function contentSecCheck(string $content) : array
    {
        $result = Http::asForm()->post($this->apiUrl . '/api/sms/keyword', [
            'userid' => config('vgsms.user_id'),
            'ts' => $ts = Carbon::now()->getPreciseTimestamp(3),
            'sign' => $this->generateSign($ts),
            'msgcontent' => $content,
        ])->json();

        if ($result['code'] > 0) {
            Log::error("短信敏感词检验失败：{$result['msg']}");
        }

        return $result;
    }

    /**
     * 查询短信发送状态
     *
     * @return array
     */
    public function query() : array
    {
        $result = Http::asForm()->post($this->apiUrl . '/api/v2/sms/query', [
            'userid' => config('vgsms.user_id'),
            'ts' => $ts = Carbon::now()->getPreciseTimestamp(3),
            'sign' => $this->generateSign($ts),
        ])->json();

        if ($result['code'] > 0) {
            Log::error("短信状态查询失败：{$result['msg']}");
        }

        return $result;
    }

    /**
     * 加密签名
     *
     * @param  string  $ts
     * @return string
     */
    private function generateSign(string $ts) : string
    {
        return md5(config('vgsms.user_id') . $ts . config('vgsms.api_key'));
    }
}
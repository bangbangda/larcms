<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TenCaptcha
{
    private string $secretId;

    private string $secretKey;

    public function __construct()
    {
        $this->secretId = config('tencentcloud.secret_id');
        $this->secretKey = config('tencentcloud.secret_key');
    }

    /**
     * 验证小程序端验证码
     *
     * @param string $ticket
     * @param string $ip
     * @return bool
     */
    public function verifyCaptcha(string $ticket, string $ip)
    {
        $httpQuery = [
            'Action' => 'DescribeCaptchaMiniResult',
            'Version' => '2019-07-22',
            'CaptchaType' => 9,
            'Ticket' => $ticket,
            'UserIp' => $ip,
            'CaptchaAppId' => config('tencentcloud.captcha.app_id'),
            'AppSecretKey' => config('tencentcloud.captcha.app_secret'),
            'Nonce' => rand(),
            'Timestamp' => time(),
            'SecretId' => $this->secretId,
        ];
        ksort($httpQuery);
        $signStr = "GETcaptcha.tencentcloudapi.com/?";
        foreach ( $httpQuery as $key => $value ) {
            $signStr = $signStr . $key . "=" . $value . "&";
        }
        $signStr = substr($signStr, 0, -1);
        $signature = base64_encode(hash_hmac("sha1", $signStr, $this->secretKey, true));

        $result = Http::get('https://captcha.tencentcloudapi.com/',
            array_merge($httpQuery, ['Signature' => $signature])
        )->json();

        Log::info($result);

        if (isset($result['Response']['Error'])) {
             return false;
        }

        return $result['Response']['CaptchaCode'] == 1;
    }
}
<?php

namespace App\Services\Tencent;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * 腾讯云接口核心类
 *
 * @author HaoLiang
 * @version 1.0.0
 * @date 2021-08-23
 */
class CloudApi
{
    private string $secretId;
    private string $secretKey;
    // UTC 时间
    private int $timestamp;
    // 签名算法，目前固定为 TC3-HMAC-SHA256
    private string $algorithm = 'TC3-HMAC-SHA256';
    // 域名地址
    private string $basicHost = 'tencentcloudapi.com';
    // URI 参数，API 3.0 固定为正斜杠（/）
    private string $canonicalUri = '/';

    private string $requestMethod;

    /**
     * @param string $action 接口方法名
     * @param string $service 产品名
     * @param string $version 接口版本
     */
    public function __construct(public string $action, public string $service, public string $version)
    {
        $this->secretId = config('tencentcloud.secret_id');
        $this->secretKey = config('tencentcloud.secret_key');
        $this->timestamp = now('UTC')->timestamp;
    }

    /**
     * Post 请求接口
     *
     * @param array $data
     * @return array
     */
    public function post(array $data): array
    {
        $this->requestMethod = 'post';

        $result = Http::withHeaders($this->headers($data))
            ->post($this->getHost(true), $data)
            ->json();

        if (isset($result['Response']['Error'])) {
            Log::error($result['Response']['Error']);
        }

        return $result;
    }

    /**
     * Get 请求接口
     *
     * @param array $data 请求数据
     * @return array
     */
    public function get(array $data): array
    {
        $this->requestMethod = 'get';

        $result = Http::withHeaders($this->headers($data))
            ->get($this->getHost(true), $data)
            ->json();

        if (isset($result['Response']['Error'])) {
            Log::error($result['Response']['Error']);
        }

        return $result;
    }

    /**
     * 获取接口头部信息
     *
     * @param array $data
     * @return array
     */
    public function headers(array $data): array
    {
        $signature = $this->sign($data);

        return [
            'Authorization' => $this->getAuthorization($signature),
            'Content-Type' => $this->getContentType(),
            'Host' => $this->getHost(),
            'X-TC-Action' => $this->action,
            'X-TC-Timestamp' => $this->timestamp,
            'X-TC-Version' => $this->version,
        ];
    }

    /**
     * 获取授权信息
     *
     * @param string $signature 签名
     * @return string
     */
    public function getAuthorization(string $signature): string
    {
        return $this->algorithm
            ." Credential=".$this->secretId."/".$this->getCredentialScope()
            .", SignedHeaders=content-type;host, Signature=".$signature;
    }

    /**
     * 签名
     *
     * @param array $data
     * @return string
     */
    public function sign(array $data): string
    {
        $hashedCanonical = $this->hashedCanonicalRequest($data);

        $secretDate = hash_hmac("SHA256", gmdate("Y-m-d", $this->timestamp), "TC3".$this->secretKey, true);
        $secretService = hash_hmac("SHA256", $this->service, $secretDate, true);
        $secretSigning = hash_hmac("SHA256", "tc3_request", $secretService, true);

        return hash_hmac("SHA256", $this->stringSign($hashedCanonical), $secretSigning);;
    }

    /**
     * 签名字符串
     *
     * @param string $hashedCanonical
     * @return string
     */
    private function stringSign(string $hashedCanonical): string
    {
        return $this->algorithm . "\n" . $this->timestamp . "\n" .
            $this->getCredentialScope() . "\n" . $hashedCanonical;
    }

    /**
     * 加密请求参数
     *
     * @param array $data
     * @return string
     */
    private function hashedCanonicalRequest(array $data): string
    {
        if ($this->requestMethod == 'get') {
            $canonicalQueryString = http_build_query($data);
            $postPayload = hash("SHA256", '');
        } else {
            $canonicalQueryString = '';
            $postPayload =  hash("SHA256", json_encode($data));
        }

        $canonicalRequest = strtoupper($this->requestMethod)."\n"
            .$this->canonicalUri."\n"
            .$canonicalQueryString."\n"
            .$this->getCanonicalHeaders()."\n"
            .$this->getSignedHeaders()."\n"
            .$postPayload;

        return hash("SHA256", $canonicalRequest);
    }

    /**
     * 获取加密字段
     *
     * @return string
     */
    private function getCanonicalHeaders(): string
    {
        $headers = [
            'content-type' => $this->getContentType(),
            'host' => $this->getHost(),
        ];

        $strHeader = '';
        foreach ($headers as $key => $val) {
            $strHeader .= $key . ':' . $val . "\n";
        }

        return $strHeader;
    }

    /**
     * 参与签名的头部信息
     *
     * @return string
     */
    private function getSignedHeaders(): string
    {
        return 'content-type;host';
    }

    /**
     * 凭证范围
     *
     * @return string
     */
    private function getCredentialScope(): string
    {
        $date = gmdate("Y-m-d", $this->timestamp);

        return "{$date}/{$this->service}/tc3_request";
    }

    /**
     * 获取编码类型
     *
     * @return string
     */
    private function getContentType(): string
    {
        return $this->requestMethod == 'get' ?
            'application/x-www-form-urlencoded' : 'application/json';
    }

    /**
     * 获取接口域名
     *
     * @param bool $isHttps
     * @return string
     */
    private function getHost(bool $isHttps = false): string
    {
        if ($isHttps) {
            return 'https://' . $this->service . '.' . $this->basicHost;
        } else {
            return $this->service . '.' . $this->basicHost;
        }
    }

}
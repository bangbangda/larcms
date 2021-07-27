<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * 高德接口获取IP地址归属地
 *
 * Class GdIpSearch
 * @package App\Services
 */
class GdIpSearch
{
    private string $key;

    private string $url = 'https://restapi.amap.com/v5/ip';

    /**
     * 设置接口Token
     *
     * IpSearch constructor.
     */
    public function __construct()
    {
        $this->key = config('ipsearch.key');
    }

    /**
     * 获取IP归属地
     *
     * @param  string  $ip
     * @return array
     */
    public function getInfo(string $ip): array
    {
        $ipResult = Http::get($this->url, [
            'key' => $this->key,
            'type' => 4,
            'ip' => $ip,
        ])->json();

        if ($ipResult['status'] === '1') {
            Log::debug($ipResult);

            return $ipResult;
        }

        Log::error("IP地址归属地查询错误  {$ipResult['msg']}");

        return [];
    }
}
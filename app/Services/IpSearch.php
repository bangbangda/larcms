<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;

/**
 * Ip 归属地查询
 *
 * Class IpSearch
 * @package App\Services
 */
class IpSearch
{
    private string $token;

    private string $url = 'https://api.ip138.com/ipv4/';

    /**
     * 设置接口Token
     *
     * IpSearch constructor.
     */
    public function __construct()
    {
        $this->token = config('ipsearch.token');
    }

    /**
     * 获取IP归属地
     *
     * @param  string  $ip
     * @return array
     */
    public function getInfo(string $ip) : array
    {
        $ipResult = Http::withHeaders([
            'token' => $this->token
        ])->get($this->url, [
            'ip' => $ip,
            'datatype' => 'jsonp'
        ])->json();

        if ($ipResult['ret'] == 'ok') {
            Log::debug($ipResult['data']);

            return $ipResult['data'];
        }

        Log::error("IP地址归属地查询错误  {$ipResult['msg']}");

        return [];
    }

}
<?php

namespace App\Http\Middleware;

use App\Services\IpSearch;
use Closure;
use Illuminate\Http\Request;

class IpVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // IP地址查询
        $ipSearch = new IpSearch();
        $ipInfo = $ipSearch->getInfo($request->ip());

        if ($ipInfo[2] == '常州') {
            return $next($request);
        }
    }
}

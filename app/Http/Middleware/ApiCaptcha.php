<?php

namespace App\Http\Middleware;

use App\Services\TenCaptcha;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiCaptcha
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
        $ticket = $request->post('ticket');

        if ($request->has('ticket') && ! Cache::tags('captcha')->has(Str::substr($ticket, 0, 10))) {
            Cache::tags('captcha')->put(Str::substr($ticket, 0, 10), 1);

            $tenCaptcha = new TenCaptcha();
            if ($tenCaptcha->verifyCaptcha($ticket, $request->ip())) {
                return $next($request);
            }
            Log::error('【ApiCaptcha】验证码错误');
        }
        Log::error('【ApiCaptcha】验证码重复请求错误');

        echo 'bmo98695@yuoia.com';
    }
}

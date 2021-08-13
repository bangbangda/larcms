<?php

namespace App\Http\Middleware;

use App\Services\TenCaptcha;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 腾讯验证码
 */
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

        $ticketKey = Str::substr($ticket, -10);

        if ($request->has('ticket') && ! Cache::tags('captcha')->has($ticketKey)) {
            Cache::tags('captcha')->put($ticketKey, 1);

            $tenCaptcha = new TenCaptcha();
            if ($tenCaptcha->verifyCaptcha($ticket, $request->ip())) {
                return $next($request);
            }
        }
        Log::error('【ApiCaptcha】活动验证码验证失败');

        return response('非法的验证码', 401);
    }
}

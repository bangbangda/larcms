<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CustomerRegistered;
use App\Events\CustomerPhoneBound;
use App\Listeners\CreateCustomerQrcode;
use App\Listeners\NewcomerRedpack;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 客户注册成功后触发事件
        CustomerRegistered::class => [
            // 生成小程序码
            CreateCustomerQrcode::class
        ],
        CustomerPhoneBound::class => [
            NewcomerRedpack::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

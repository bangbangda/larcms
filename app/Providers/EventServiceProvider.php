<?php

namespace App\Providers;

use App\Events\CustomerSubscribed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CustomerRegistered;
use App\Events\CustomerPhoneBound;
use App\Events\CustomerInvitationCompleted;
use App\Events\SmsMessageSaved;
use App\Listeners\CreateCustomerQrcode;
use App\Listeners\NewcomerRedpack;
use App\Listeners\InvitatioPedpack;
use App\Listeners\TeamRedpack;
use App\Listeners\SendSmsMessageTask;
use App\Listeners\SendMiniProgramPage;

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
        // 绑定手机号后触发事件
        CustomerPhoneBound::class => [
            // 发放新人红包
            NewcomerRedpack::class,
        ],
        CustomerInvitationCompleted::class => [
            InvitatioPedpack::class, // 发放邀请红包
            TeamRedpack::class,      // 发放团队红包
        ],
        SmsMessageSaved::class => [
            SendSmsMessageTask::class
        ],
        // 用户关注公众号
        CustomerSubscribed::class => [
            // 公众号自动发送小程序
            SendMiniProgramPage::class,
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

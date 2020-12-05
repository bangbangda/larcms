<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use \Illuminate\Support\Facades\Log;

class EventMessageHandler implements EventHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle($payload = null)
    {
        $app = Factory::officialAccount(config('wechat.mp'));

        $message = $app->server->getMessage();

        Log::debug($message);
    }
}
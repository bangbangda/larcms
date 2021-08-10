<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use App\Jobs\SendMiniProgramPage;

/**
 * 微信推送文本消息
 *
 * Class TextMessageHandler
 * @package App\Services\Wechat
 */
class TextMessageHandler implements EventHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle($payload = null)
    {
        $app = Factory::officialAccount(config('wechat.mp'));
        // 对应 octane
        $app->request->initialize(request()->query(), request()->post(), [], [], [], request()->server(), request()->getContent());

        $message = $app->server->getMessage();

        // 关键词回复
        if (str_contains($message['Content'], '红包')) {
            // 自动发送小程序卡片
            SendMiniProgramPage::dispatch($message['FromUserName']);
        }
    }
}
<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Image;
use Illuminate\Support\Facades\Log;

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
        $app->request->initialize(request()->query(), request()->post());

        $message = $app->server->getMessage();

        Log::debug($message);
        // 关键词回复
        if ($message['Content'] == '红包') {
            return new Image('Ll2fS-iivndSj1wHzgPKjThzlHky4a2qsHf0-iVhesQ');
        }
    }
}
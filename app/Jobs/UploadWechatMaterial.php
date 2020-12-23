<?php

namespace App\Jobs;

use App\Models\WechatMaterial;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/**
 * 将素材上传至微信服务器
 *
 * Class UploadWechatMaterial
 * @package App\Jobs
 */
class UploadWechatMaterial implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected WechatMaterial $wechatMaterial;

    /**
     * Create a new job instance.
     *
     * @param  WechatMaterial  $wechatMaterial
     */
    public function __construct(WechatMaterial $wechatMaterial)
    {
        $this->wechatMaterial = $wechatMaterial;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app = Factory::officialAccount(config('wechat.mp'));
        switch ($this->wechatMaterial->type) {
            case 'image':
                $result = $app->material->uploadImage($this->getFilePath());
                break;
            case 'video':
                $result = $app->material->uploadVideo($this->getFilePath(), $this->wechatMaterial->title, "视频描述");
                break;
            case 'voice':
                $result = $app->material->uploadVoice($this->getFilePath());
                break;
            case 'thumb':
                $result = $app->material->uploadThumb($this->getFilePath());
                break;
        }

        // 微信服务器素材编号
        $this->wechatMaterial->media_id = $result['media_id'];
        // 图片素材时
        if ($this->wechatMaterial->type == 'image') {
            // 保存图片地址
            $this->wechatMaterial->media_url = $result['url'];
        }
        $this->wechatMaterial->save();
    }

    /**
     * 获取素材文件路径
     *
     * @return string
     */
    private function getFilePath() : string
    {
        return Storage::path($this->wechatMaterial->file_path);
    }
}

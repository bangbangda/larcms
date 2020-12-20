<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WechatMaterialResource;
use App\Models\WechatMaterial;
use Illuminate\Http\Request;

/**
 * 视频管理
 *
 * Class VideoController
 * @package App\Http\Controllers\API
 */
class VideoController extends Controller
{
    /**
     * 列表
     */
    public function index()
    {
        $videoMaterial = WechatMaterial::where('type', 'video')
            ->orderBy('updated_at', 'DESC')
            ->paginate();

        return response()->json([
            'headImage' => 'https://larcms.bangbangda.me/storage/P2Ang8E2H9.jpg',
            'videos' => WechatMaterialResource::collection($videoMaterial),
            'footerImage' => 'https://vision-image.oss-cn-shanghai.aliyuncs.com/mvkfxZf7bZ.jpg',
        ]);
    }
}

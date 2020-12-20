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

        return response()->json(WechatMaterialResource::collection($videoMaterial));
    }
}

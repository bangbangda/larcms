<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PopupAd;
use App\Models\ShareImage;
use Illuminate\Http\Request;

/**
 * 分享海报
 *
 * Class ShareImageController
 * @package App\Http\Controllers\API
 */
class ShareImageController extends Controller
{
    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $images = ShareImage::select('url')->active()->orderBy('updated_at')->get();

        $news = News::orderBy('updated_at', 'desc')->get();

        $popupAd = PopupAd::select(['url', 'auto_close', 'close_second'])->active()->first();

        return response()->json([
            'customer' => [
                'id' => $request->user()->id,
                'avatar_url' => $request->user()->avatar_url,
                'qrCode' => $request->user()->qrcode_url
            ],
            'headImage' => 'https://baotou-yz.oss-cn-huhehaote.aliyuncs.com/ARoNwpdhmORu9Ru9AuY2.jpg',
            'popupAd' => $popupAd ?? [],
            'shareImages' => $images,
            'news' => [],
            'subscribe_url' => "https://mp.weixin.qq.com/s/YKfHifcGDUQoDw_MMffpgQ",
            'ad' => [
                'image' => 'https://baotou-yz.oss-cn-huhehaote.aliyuncs.com/Ef4q6KUXoqxx.jpeg',
                'url' => 'https://mp.weixin.qq.com/s/URqeKtsAQ8Mfo4A5PBRH0A',
            ]
        ]);
    }
}

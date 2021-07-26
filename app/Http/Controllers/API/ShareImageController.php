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
        $images = ShareImage::select('url')->active()->get();

        $news = News::orderBy('publish_date', 'desc')->get();

        $popupAd = PopupAd::select(['url', 'auto_close', 'close_second'])->active()->first();

        return response()->json([
            'customer' => [
                'id' => $request->user()->id,
                'avatar_url' => $request->user()->avatar_url,
                'qrCode' => $request->user()->qrcode_url
            ],
            'headImage' => 'https://larcms.bangbangda.me/storage/P2Ang8E2H9.jpg',
            'popupAd' => $popupAd ?? [],
            'shareImages' => $images,
            'news' => []
        ]);
    }
}

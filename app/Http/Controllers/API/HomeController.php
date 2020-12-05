<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PopupAd;
use App\Models\ShareImage;
use EasyWeChat\Factory;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
            'popupAd' => $popupAd ?? [],
            'shareImages' => $images,
            'news' => $news
        ]);
    }


}

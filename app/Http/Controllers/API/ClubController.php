<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'head_image_url' => 'https://vision-image.oss-cn-shanghai.aliyuncs.com/banner/FABrRY4vTjxz8bjovwDZ.jpg',
            'clubs' => Club::all()
        ]);
    }
}

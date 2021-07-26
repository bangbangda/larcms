<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Salesman;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    public function index()
    {
        return response()->json([
            'head_image_url' => 'https://vision-image.oss-cn-shanghai.aliyuncs.com/banner/ARoNwpdhmORu9Ru9AuY2.jpg',
            'salesmen' => Salesman::all()
        ]);
    }
}

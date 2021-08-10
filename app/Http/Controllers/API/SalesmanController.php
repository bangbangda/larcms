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
            'head_image_url' => 'https://baotou-yz.oss-cn-huhehaote.aliyuncs.com/wpdhmORu9.jpeg',
            'salesmen' => Salesman::all()
        ]);
    }
}

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
            'head_image_url' => 'https://baotouyuanzhou.oss-cn-huhehaote.aliyuncs.com/wx/ARoNwpdhmORu9Ru9AuY2.jpg',
            'salesmen' => Salesman::all()
        ]);
    }
}

<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class HouseController extends Controller
{

    public function show(House $house)
    {
        return response()->json([
            'images' => Arr::pluck($house->images, 'image_url'),
            'name' => $house->name,
            'area' => $house->area,
            'tags' => Arr::pluck($house->tags, 'name'),
            'rooms' => $house->rooms()->select('name', 'image_url')
                ->get(),
            'details' => Arr::pluck($house->details, 'image_url'),
        ]);
    }

}
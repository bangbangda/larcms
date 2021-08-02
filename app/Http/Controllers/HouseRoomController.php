<?php
namespace App\Http\Controllers;

use Anan\Oss\Facades\EasyOss;
use App\Models\House;
use App\Models\HouseRoom;
use Illuminate\Http\Request;

class HouseRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(House $house)
    {
        return view('room.index', compact('house'));
    }

    public function json()
    {
        return (new HouseRoom)->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(House $house)
    {
        return view('room.create', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, House $house)
    {
        $path = $request->file('image')->store('room');

        $house->rooms()->create([
            'name' => $request->post('name'),
            'weight' => $request->post('weight'),
            'image_url' => EasyOss::uploadFile(storage_path('app/public/'.$path)),
        ]);

        return redirect()->route('house.rooms.index', $house->id)->with('success', '保存成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house, HouseRoom $room)
    {
        $room->delete();

        return redirect()->route('house.rooms.index', $house->id)->with('success', '删除成功');
    }
}

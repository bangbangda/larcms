<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * 户型管理
 *
 * Class HouseController
 * @package App\Http\Controllers
 */
class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('house.index');
    }

    public function json()
    {
        return (new House())->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('house.create');
    }

    /**
     * 保存图片
     *
     * @param Request $request
     * @return mixed
     */
    public function storeImage(Request $request)
    {
        $filePath = $request->file('image')->store('house');

        return response()->json([
            'status' => 'success',
            'fileUrl' => Storage::disk('public')->url($filePath),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HouseRequest $request)
    {
        (new House())->storeAll($request->post());

        return redirect()->route('house.index')->with('success', '添加成功');
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
    public function destroy(House $house)
    {
        $house->delete();

        return redirect()->route('house.index')->with('success', '删除成功');
    }
}

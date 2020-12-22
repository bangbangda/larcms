<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareImageReqeust;
use App\Models\ShareImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShareImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('share-image.index');
    }


    public function json()
    {
        return (new ShareImage())->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('share-image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ShareImageReqeust  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShareImageReqeust $request)
    {
        ShareImage::create([
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'url' => Storage::url($request->file('image')->store('share-images')),
        ]);

        return redirect()->route('activity.shareImage.index')
            ->with('success', '保存成功');
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
     * @param  ShareImage  $shareImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ShareImage $shareImage)
    {
        return view('share-image.edit', compact('shareImage'));
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
        $image = [];
        if ($request->hasFile('image')) {
            $image['url'] = Storage::url($request->file('image')->store('share-images'));
        }
        ShareImage::where('id', $id)->update(array_merge(
            $image,
            [
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
            ]
        ));

        return redirect()->route('activity.shareImage.index')
            ->with('success', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShareImage  $shareImage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ShareImage $shareImage)
    {
        $shareImage->delete();

        return redirect()->route('activity.shareImage.index')
            ->with('success', '删除成功');
    }
}

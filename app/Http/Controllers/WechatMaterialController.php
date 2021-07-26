<?php

namespace App\Http\Controllers;

use App\Http\Requests\WechatMaterialRequest;
use App\Jobs\UploadWechatMaterial;
use App\Models\WechatMaterial;
use Illuminate\Http\Request;

class WechatMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wechat-material.index');
    }


    public function json()
    {
        return (new WechatMaterial())->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wechat-material.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WechatMaterialRequest $request)
    {
        $path = $request->file('material')->store('material');
        // 保存微信素材
        $wechatMaterial = WechatMaterial::create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        // 添加队列-上传素材至微信服务器
        UploadWechatMaterial::dispatch($wechatMaterial);

        return redirect()->route('material.wechatMaterial.index')
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
     * @param  WechatMaterial  $wechatMaterial
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(WechatMaterial $wechatMaterial)
    {
        $wechatMaterial->delete();

        return redirect()->route('material.wechatMaterial.index')
            ->with('success', '删除成功');
    }
}

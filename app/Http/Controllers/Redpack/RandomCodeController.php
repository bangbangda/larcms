<?php

namespace App\Http\Controllers\Redpack;

use App\Http\Controllers\Controller;
use App\Models\RandomCodeRedpack;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * 随机码发放红包
 *
 * Class RandomCodeRedpack
 * @package App\Http\Controllers
 */
class RandomCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('redpack.randomCode.index');
    }

    /**
     * 列表
     */
    public function json()
    {
        return (new RandomCodeRedpack())->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RandomCodeRedpack::create([
            'code' => Str::random('13'),
            'amount' => 880,
        ]);

        return redirect()->route('redpack.randomCode.index')
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

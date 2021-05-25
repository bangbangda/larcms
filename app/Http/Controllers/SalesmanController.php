<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesmanRequest;
use App\Models\Salesman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('salesman.index');
    }

    public function json()
    {
        return (new Salesman)->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('salesman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SalesmanRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SalesmanRequest $request)
    {
        Salesman::create([
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'avatar_url' => Storage::url($request->file('image')->store('salesman-images')),
            'phone' => $request->post('phone'),
            'wechat' => $request->post('wechat'),
        ]);

        return redirect()->route('salesman.index')
            ->with('success', '保存成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Salesman $salesman
     * @return \Illuminate\Http\Response
     */
    public function edit(Salesman $salesman)
    {
        return view('salesman.edit', compact('salesman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SalesmanRequest $request, $id)
    {
        $data = [];
        if ($request->has('image')) {
            $data['avatar_url'] = Storage::url($request->file('image')->store('club-images'));
        }

        Salesman::find($id)->update(array_merge($data,[
            'name' => $request->post('name'),
            'position' => $request->post('position'),
            'phone' => $request->post('phone'),
            'wechat' => $request->post('wechat'),
        ]));

        return redirect()->route('salesman.index')
            ->with('success', '保存成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Salesman $salesman)
    {
        $salesman->delete();

        return redirect()->route('salesman.index')
            ->with('success', '删除成功');
    }
}

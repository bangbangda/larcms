<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubRequest;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('club.index');
    }


    public function json()
    {
        return (new Club)->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('club.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClubRequest $request
     * @return Response
     */
    public function store(ClubRequest $request)
    {
        Club::create([
            'name' => $request->post('name'),
            'image_url' => Storage::url($request->file('image')->store('club-images')),
            'weight' => $request->post('weight'),
        ]);

        return redirect()->route('club.index')
            ->with('success', '保存成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Club $club)
    {
        return view('club.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClubRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClubRequest $request, $id)
    {
        $data = [];
        if ($request->has('image')) {
            $data['image_url'] = Storage::url($request->file('image')->store('club-images'));
        }

        Club::find($id)
            ->update(array_merge($data, [
            'name' => $request->post('name'),
            'weight' => $request->post('weight'),
        ]));

        return redirect()->route('club.index')
            ->with('success', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Club $club
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()->route('club.index')
            ->with('success', '删除成功');
    }
}

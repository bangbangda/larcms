<?php

namespace App\Http\Controllers;

use Anan\Oss\Facades\EasyOss;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * 首页-新闻管理
 *
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('news.index');
    }

    /**
     * Bs Table
     */
    public function json()
    {
        return (new News)->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        News::create([
            'title' => $request->post('title'),
            'original_url' => $request->post('original_url'),
            'cover_url' => EasyOss::uploadFile(Storage::path($request->file('image')->store('news'))),
        ]);

        return redirect()->route('activity.news.index')
            ->with('success', '保存成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = News::find($id);

        $news->title = $request->title;
        $news->original_url = $request->original_url;

        if ($request->hasFile('image')) {
            $news->cover_url = EasyOss::uploadFile(Storage::path($request->file('image')->store('news')));
        }

        $news->save();

        return redirect()->route('activity.news.index')
            ->with('success', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('activity.news.index')
            ->with('success', '删除成功');
    }
}

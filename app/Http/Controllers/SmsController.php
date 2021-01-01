<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmsRequest;
use App\Models\SmsSendMessage;
use App\Services\VgSms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * 短信发送管理
 *
 * Class SmsController
 * @package App\Http\Controllers
 */
class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sms.index');
    }

    /**
     * BsTable
     */
    public function json()
    {
        return (new SmsSendMessage())->bsTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sms.create');
    }

    /**
     * 验证短信内容是否合法
     * @param  Request  $request
     */
    public function checkContent(Request $request) : JsonResponse
    {
        $content = $request->post('content');

        // 验证短息是否合法
        $vgSms = new VgSms();
        $result = $vgSms->contentSecCheck($content);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SmsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SmsRequest $request)
    {
        SmsSendMessage::create([
            'uuid' => Str::random(32),
            'content' => $request->post('content') . ' 退订回T',
        ]);

        return redirect()->route('sms.index')->with(['success', '短信任务提交成功']);
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
        dd($id);
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

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $questions = Question::where('content', 'like', "%{$request->post('search_key')}%")
            ->select(['type', 'content', 'correct_answer'])
            ->get();

        return response()->json([
            'code' => 0,
            'message' => '成功',
            'data' => $questions,
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivityRule;
use Illuminate\Http\Request;

class ActivityRuleController extends Controller
{
    public function index()
    {
        $rules = ActivityRule::select('title', 'content')
            ->orderBy('sort_field', 'desc')
            ->get();

        return response()->json($rules);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityRuleCollection;
use App\Models\ActivityRule;
use Illuminate\Http\Request;

class ActivityRuleController extends Controller
{
    public function index()
    {
        $rules = ActivityRule::orderBy('sort_field', 'desc')->get();

        return response()->json(
            new ActivityRuleCollection($rules)
        );
    }
}

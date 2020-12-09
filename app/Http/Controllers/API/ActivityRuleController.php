<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityRule as ActivityRuleResource;
use App\Models\ActivityRule;

class ActivityRuleController extends Controller
{
    public function index()
    {
        $rules = ActivityRule::orderBy('sort_field', 'desc')
            ->get();

        return response()->json(
            ActivityRuleResource::collection($rules)
        );
    }
}

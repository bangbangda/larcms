<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerIncomeController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['income' => function($query) {
            $query->orderBy('amount', 'DESC');
        }])->get();

        $incomes = [];

        foreach ($customers as $customer) {
            $incomes[] = [
                'amount' => $customer->income->amount,
                'nickname' => $customer->nickname,
                'avatar_url' => $customer->avatar_url,
            ];
        }

        return response()->json($incomes);
    }
}

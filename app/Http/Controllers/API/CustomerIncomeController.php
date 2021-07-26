<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerIncome;
use Illuminate\Support\Facades\Log;

class CustomerIncomeController extends Controller
{
    public function index()
    {

        $customerIncomes = CustomerIncome::with('customer')
            ->orderBy('amount', 'DESC')
            ->limit(20)
            ->get();

//        $customers = Customer::with(['income' => function($query) {
//            $query->orderBy('amount', 'DESC');
//        }])->get();

        $incomes = [];

        foreach ($customerIncomes as $income) {
            $incomes[] = [
                'amount' => $income->amountRmb,
                'nickname' => $income->customer->nickname ?? '',
                'avatar_url' => $income->customer->avatar_url ?? '',
            ];
        }

        return response()->json($incomes);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferLog extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 红包总计
     *
     * @return array
     */
    public function scopeTotalRedpack() : array
    {
        $totalQuantity = $this->whereNotNull('payment_no')->count();
        $totalAmount = $this->whereNotNull('payment_no')->sum('amount') / 100;

        return compact('totalQuantity', 'totalAmount');
    }
}

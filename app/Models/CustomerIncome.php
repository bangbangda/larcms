<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerIncome extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['amount', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function getAmountRmbAttribute($value)
    {
        return ($this->attributes['amount'] / 100) . '元';
    }
}

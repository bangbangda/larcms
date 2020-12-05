<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareOrder extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'sub_customer_id'];

    protected $hidden = ['pay_state', 'sub_customer_id', 'deleted_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'sub_customer_id');
    }
}

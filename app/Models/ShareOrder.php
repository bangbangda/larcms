<?php

namespace App\Models;

use App\Events\CustomerInvitationCompleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShareOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'sub_customer_id', 'sub_openid'];

    protected $hidden = ['pay_state', 'sub_customer_id', 'deleted_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected $dispatchesEvents = [
        'created' => CustomerInvitationCompleted::class
    ];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'sub_customer_id');
    }

}

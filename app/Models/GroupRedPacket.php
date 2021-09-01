<?php

namespace App\Models;

use App\Jobs\SendGroupRedPacket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 裂变红包
 */
class GroupRedPacket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['bill_no', 'openid', 'total_amount', 'total_num'];

    protected static function booted()
    {
        static::created(function ($groupRedPacket) {
            // 发送裂变红包
            SendGroupRedPacket::dispatch($groupRedPacket);
        });
    }

    /**
     * 裂变红包领取明细
     *
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(GroupRedPacketDetail::class);
    }
}

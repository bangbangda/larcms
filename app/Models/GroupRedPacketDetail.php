<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 裂变红包领取明细
 */
class GroupRedPacketDetail extends Model
{
    use HasFactory, SoftDeletes;
}

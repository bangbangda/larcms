<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 短信任务状态
 *
 * Class SmsSendMessageReport
 * @package App\Models
 */
class SmsSendMessageReport extends Model
{
    use HasFactory, SoftDeletes;
}

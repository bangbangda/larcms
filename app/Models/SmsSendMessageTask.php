<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 短信任务管理
 *
 * Class SmsSendMessageTask
 * @package App\Models
 */
class SmsSendMessageTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['task_id', 'total'];
}

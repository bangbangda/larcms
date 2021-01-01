<?php
namespace App\Models;

use App\Events\SmsMessageSaved;
use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 短信管理
 *
 * Class SmsSendMessage
 * @package App\Models
 */
class SmsSendMessage extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['uuid', 'content', 'state'];

    protected $dispatchesEvents = [
        'created' => SmsMessageSaved::class
    ];

    /**
     * 任务列表
     *
     * @return HasMany
     */
    public function tasks() : HasMany
    {
        return $this->hasMany('App\Models\SmsSendMessageTask');
    }
}

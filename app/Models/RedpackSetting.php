<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 红包配置表
 *
 * Class RedpackSettings
 * @package App\Models
 */
class RedpackSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * 基础红包
     *
     * @param $query
     * @param  string  $type
     *
     * @return
     */
    public function scopeType($query, $type = 'basis')
    {
        return $query->where('type', $type);
    }

}

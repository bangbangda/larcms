<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * 指定红包类型
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

    /**
     * 查询有效的红包设置
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereNull('start_date')->whereNull('end_date')
            ->orWhere(function (Builder $query) {
                $day = date('Y-m-d H:i:s');
                $query->where('start_date', '<=', $day)
                    ->where('end_date', '>=', $day);
            });
    }

}

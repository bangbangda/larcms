<?php

namespace App\Models;

use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShareImage extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['start_date', 'end_date', 'url'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * 格式化开始时间
     *
     * @param $value
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value . ' 00:00:01';
    }

    /**
     * 格式化结束时间
     *
     * @param $value
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value . ' 23:59:30';
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getStartDateAttribute($value)
    {
        return substr($value, 0 , 10);
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getEndDateAttribute($value)
    {
        return substr($value, 0 , 10);
    }

    /**
     * 查询有效期内的海报
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

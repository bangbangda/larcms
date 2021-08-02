<?php

namespace App\Models;

use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseRoom extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['name', 'image_url', 'weight'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('weight', function(Builder $builder) {
            $builder->orderBy('weight');
        });
    }

    public function getBsTableRows()
    {
        $param = $this->getBsTableParam();

        return $this->with('house:id,name,area')
            ->where($this->_where)
            ->orderBy($param['sort'], $param['order'])
            ->offset($param['offset'])
            ->limit($param['limit'])
            ->get();
    }
}

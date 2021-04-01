<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image_url', 'weight'];

    protected static function booted()
    {
        static::addGlobalScope('weight', function(Builder $builder) {
            $builder->orderBy('weight');
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'image_url', 'weight'];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope('weight', function(Builder $builder) {
            $builder->orderBy('weight');
        });
    }
}

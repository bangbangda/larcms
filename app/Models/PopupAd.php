<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PopupAd extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'auto_close' => 'boolean',
    ];

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

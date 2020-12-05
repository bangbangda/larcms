<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareImage extends Model
{
    use HasFactory;

    protected $hidden = [
        'start_date', 'end_date'
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

<?php

namespace App\Models;

use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 新闻表
 *
 * @package App\Models
 */
class News extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = ['title', 'cover_url', 'original_url'];
}

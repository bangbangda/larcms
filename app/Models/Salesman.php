<?php

namespace App\Models;

use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $fillable = ['name', 'position', 'avatar_url', 'phone', 'wechat'];
}

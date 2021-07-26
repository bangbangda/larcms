<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\This;

class House extends Model
{
    use HasFactory, SoftDeletes;

    public function images(): HasMany
    {
        return $this->hasMany('App\Models\HouseImage');
    }

    public function tags(): HasMany
    {
        return $this->hasMany('App\Models\HouseTag');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany('App\Models\HouseRoom');
    }

    public function details(): HasMany
    {
        return $this->hasMany('App\Models\HouseDetail');
    }

    /**
     * 首页数据
     *
     * @return array
     */
    public function homeData(): array
    {
        $houses = $this->with(['tags:house_id,name', 'images:house_id,image_url'])
            ->orderBy('weight')->get();

        foreach ($houses as $house) {
            $data[] = [
                'id' => $house->id,
                'name' => $house->name,
                'area' => $house->area,
                'tags' => Arr::pluck($house->tags, 'name'),
                'image' => $house->images[0]->image_url,
            ];
        }

        return $data;
    }
}

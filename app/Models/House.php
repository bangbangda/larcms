<?php

namespace App\Models;

use Anan\Oss\Facades\EasyOss;
use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Request;

class House extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['name', 'area', 'weight'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

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

    /**
     * 保存户型信息
     *
     * @param array $postData
     * @return mixed
     */
    public function storeAll(array $postData): mixed
    {
        return DB::transaction(function () use ($postData) {
            // 户型基本信息
            $house = $this->create([
                'name' => $postData['name'],
                'area' => $postData['area'],
                'weight' => $postData['weight'],
            ]);

            // 户型标签
            $weight = 1;
            foreach (explode(',', $postData['tag']) as $tag) {
                $house->tags()->create([
                    'name' => $tag,
                    'weight' => $weight++,
                ]);
            }

            // 户型详情
            $weight = 1;
            foreach ($postData['imageUrl'] as $imageUrl) {
                $ossFileUrl = EasyOss::uploadFile(storage_path('app/public/' . Str::afterLast($imageUrl, 'storage/')));

                $house->details()->create([
                    'image_url' => $ossFileUrl,
                    'weight' => $weight,
                ]);
            }

            return true;
        });
    }
}

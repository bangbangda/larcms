<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WechatMaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'src' => $this->oss_url
        ];
    }
}

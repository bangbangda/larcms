<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityRuleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->collection as &$data) {
            unset($data['sort_field']);
            unset($data['deleted_at']);
            unset($data['created_at']);
            unset($data['updated_at']);
        }

        return parent::toArray($request);
    }
}

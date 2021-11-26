<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Warehouse extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'capacity' => $this->capacity,
            'area' => $this->area->name
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->productphoto->isEmpty()){
            $photo_url= URL::to('storage/product/default.png');
        } else{
            $photo_url= URL::to('storage/'.$this->productphoto[0]->photo_url);
        }
        return [
            'id'=> $this->id,
            'type' => $this->type->name,
            'size' => $this->size->width.'X'.$this->size->height,
            'factory' => $this->factories->name,
            'weight' => $this->weight,
            'gross_weight' => $this->gross_weight,
            'colour' => $this->colour->name,
            'logo' => $this->logo->name,
            'photo' => $photo_url,
            'cost' => $this->cost,
        ];
    }
}

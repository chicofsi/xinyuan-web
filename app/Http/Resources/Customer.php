<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->customerphoto->isEmpty()){
            $photo_url=URL::to('storage/user_photo/default_user.jpg');
        }else{
            $photo_url=URL::to('storage/'.$this->customerphoto[0]->photo_url);
        }
        return [
            "id"=> $this->id,
            "id_area"=> $this->id_area,
            "invited_by"=> $this->invited_by,
            "company_name"=> $this->company_name,
            "company_address"=> $this->company_address,
            "company_phone"=> $this->company_phone,
            "company_npwp"=> $this->company_npwp,
            "level"=> $this->customerlevel->level,
            "administrator_name"=> $this->administrator_name,
            "administrator_id"=> $this->administrator_id,
            "administrator_birthdate"=> $this->administrator_birthdate,
            "administrator_npwp"=> $this->administrator_npwp,
            "administrator_phone"=> $this->administrator_phone,
            "administrator_address"=> $this->administrator_address,
            "tempo"=> $this->customerlevel->tempo_limit,
            "loan_limit"=> $this->customerlevel->loan_limit,
            "photo_url"=>$photo_url
        ];
    }
}

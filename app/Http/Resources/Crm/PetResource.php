<?php

namespace App\Http\Resources\Crm;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'breed' => $this->breed,
            'coat' => $this->coat,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'neutered' => $this->neutered,
            'registration_id' => $this->registration_id,
            'lead_id' => $this->lead_id,
            'album_id' => $this->album_id,
            'avatar' => 'https://i.pravatar.cc',
        ];
    }
}

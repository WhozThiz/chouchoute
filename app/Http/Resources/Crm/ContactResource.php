<?php

namespace App\Http\Resources\Crm;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
			'neighborhood' => $this->neighborhood,
			'city' => $this->city,
			'state' => $this->state,
			'zipcode' => $this->zipcode,
			'homephone' => $this->homephone,
			'mobile' => $this->mobile,
            'email' => $this->email,
			'registration' => $this->registration,
			'ssn' => $this->ssn,
			'status' => $this->status,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'street_address' => $this->street_address,
            'city' => $this->city,
            'state' => $this->state,
            'place_id' => $this->place_id,
            'phone' => $this->phone,
            'summary' => $this->summary,
            'image' => $this->image,
        ];
    }
}

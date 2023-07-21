<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Restaurent;

class GetAllRestaurent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'place_id' => $this->place_id,
            'name' => $this->restaurant_name,
            'dp' => $this->dish_picture,
            'rating' => (Restaurent::select('rating')->where('place_id',$this->place_id)->sum('rating') / Restaurent::select('rating')->where('place_id',$this->place_id)->count()),
            'review' => (Restaurent::select('review')->where('place_id',$this->place_id)->count()),
            'lat' => $this->lat,
            'long' => $this->long,
            'open Now' => ($this->open_now === 0) ? false : (($this->open_now === 1) ? true : null),
            'width' => $this->width,
            'height' => $this->height,
            'photo_reference' => $this->photo_reference,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Restaurent;
class GetAllFriendsPost extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->restaurant_name,
            'food_category' => $this->food_category,
            'food_item' => $this->food_item,
            'rating' => $this->rating,
            'review' => $this->review,
            'dish_name' => $this->dish_name,
            'dish_picture' => $this->dish_picture,
            'user_name' => $this->Users->name,
            'user_image' => $this->UsersProfile->image,
            'created_at' => $this->created_at,
            'place_id' => $this->place_id,
            'lat' => $this->lat,
            'long' => $this->long,
            'likes' => $this->Likes,
            'Comments' => $this->Comments,

        ];
    }
}

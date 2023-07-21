<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Follow;

class FollowersResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "created_at" => $this->created_at,
            "you_follow_or_not" => (Follow::where("user_id",$request->id)->where("friend_id",$this->id)->first() ? "Yes" : "No"),
            "follower_count" => (Follow::where("user_id",$this->id)->count()),
            "profileSetup" => $this->profileSetup,
        ];
    }
}

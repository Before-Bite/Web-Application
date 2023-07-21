<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Follow;

class UserResource extends JsonResource
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
            "you_follow_or_not" => (Follow::where("user_id",$request->user_id)->where("friend_id",$this->id)->first() ? "Yes" : "No"),
            "following" => $this->Following,
            "follow" => $this->Follow,
            "post" => $this->Post,
            "profileSetup" => $this->profileSetup,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ActivityNotification;

class GetMyNotifications extends JsonResource
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
            'user_id' => $this->friend_id,
            'friend_id' => $this->Users->id,
            'Comment' => $this->status,
            'post_id' => $this->post_id,
            'UserName' => $this->Users->name,
            'created_at' => $this->created_at,
            'image' => $this->UserProfile->image,
        ];
    }
}

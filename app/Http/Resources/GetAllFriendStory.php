<?php

namespace App\Http\Resources;

use App\Models\Story;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllFriendStory extends JsonResource
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
            "user_name" => $this->user_id,
            "contentType" => $this->contentType,
            "content" => $this->content,
            "name" => $this->Users->name,
        ];
    }
}

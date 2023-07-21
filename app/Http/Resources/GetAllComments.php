<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Commants;
use App\Models\User;

class GetAllComments extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_id = Commants::select('user_id')->where('id',$this->id)->first();
        // return $user_id;
        return [
            'CommentId' => $this->id,
            'UserId' => $user_id,
            'UserName' => "Minam",
            'UserDP' => "Images",
            'UserComment' => "So Nice",
            'CreatedAt' => "234324"

        ];
    }
}

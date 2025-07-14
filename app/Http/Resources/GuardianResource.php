<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->whenLoaded('User')),
            'student' => new StudentCollection($this->whenLoaded('Student')),
            'occupation' => $this->occupation,
            'altPhoneNo'=> $this->alt_phone_no,
            'officeAddress'=> $this->office_address,


        ];
    }
}

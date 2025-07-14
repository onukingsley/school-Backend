<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'regNo' => $this->reg_no,
            'userType' => $this->user_type,
            'email' => $this->email,
            'staff' => new StaffResource($this->whenLoaded('Staff')),
            'student' => new StaffResource($this->whenLoaded('Student')),
            'guardian' => new StaffResource($this->whenLoaded('Guardian'))
        ];
    }
}

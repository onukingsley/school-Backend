<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultsCheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student' => new StudentResource($this->whenLoaded('Student')),
            'dues' => new DuesResource($this->whenLoaded('Dues')),
            'token'=> $this->token,
            'numberOfAttempts'=> $this->number_of_attempts,
            'status'=> $this->status,
        ];
    }
}

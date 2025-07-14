<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolFeesResource extends JsonResource
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
            'transactionId' => $this->transaction_id,
            'transactionType' => $this->transaction_type,
            'amount' => $this->amount,
            'name' => $this->name,
            'academic_session' => new AcademicSessionResource($this->whenLoaded('AcademicSession')),
            'term' => new TermResource($this->whenLoaded('Term')),
        ];
    }
}

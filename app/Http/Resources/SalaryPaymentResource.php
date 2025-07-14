<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'staff'=> new StaffResource($this->whenLoaded('Staff')),
            'dues' => new DuesResource($this->whenLoaded('Dues')),
            'transactionType' => $this->transactionType,
            'amount' => $this->amount,
            'name' => $this->name,
            'transaction_id' => $this->transaction_id
        ];
    }
}

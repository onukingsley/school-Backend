<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'TransactionName' => $this->transaction_name,
            'amount' => $this->amount,
            'TransactionType' => $this->transaction_type,
            'description' => $this->description,
            'TransactionId' => $this->transaction_id,
            'balance' => $this->balance,
        ];
    }
}

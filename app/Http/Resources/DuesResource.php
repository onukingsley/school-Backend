<?php

namespace App\Http\Resources;

use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'amount' => $this->amount,
            'schoolFees' => new SchoolFeesCollection($this->whenLoaded('SchoolFees')),
            'salaryPayment' => new SalaryPaymentCollection($this->whenLoaded('SalaryPayment')),
            'ResultCheck' => new ResultsCheckCollection($this->whenLoaded('ResultCheck'))
        ];
    }
}

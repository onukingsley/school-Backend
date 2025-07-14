<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeScaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'grade' => $this->grade,
            'minScore' => $this->min_score,
            'maxScore' => $this->max_score,
            'remark' => $this->remark,
            'result' => new ResultsCollection($this->whenLoaded('Result'))
        ];
    }
}

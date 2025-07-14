<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invigilator'=>$this->invigilator,
            'timeRange'=> $this->time_range,
            'classType' => new ClassTypeResource($this->whenLoaded('ClassType')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'staff' => new StaffResource($this->whenLoaded('staff')),
            'academicSession' => new AcademicSessionResource($this->whenLoaded('session')),
            'term' => new TermResource($this->whenLoaded('term')),

        ];
    }
}

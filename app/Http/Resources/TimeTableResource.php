<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subjectTitle' => $this->subject_title,
            'classType' => new ClassTypeResource($this->whenLoaded('classType')),
            'dayOfTheWeek' => $this->day_of_the_week,
            'timeRange' => $this->time_range,
            'subject' => new SubjectResource($this->whenLoaded('Subject')),
            'staff' => new StaffResource($this->whenLoaded('Staff')),
            'term' => new TermResource($this->whenLoaded('Term')),
            'academicSession' => new AcademicSessionResource($this->whenLoaded('AcademicSession')),

        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'schemeOfWork' => $this->scheme_of_work,
            'classList' => $this->class_list,
            'description' => $this->description,
            'staffId' => new StaffRoleResource($this->whenLoaded('Staff')),
            'result' => new ResultsCollection($this->whenLoaded('Result')),
            'timeTable' => new TimeTableCollection($this->whenLoaded('TimeTable')),
            'assignment' => new AssignmentCollection($this->whenLoaded('Assignment')),
            'exam' => new ExamCollection($this->whenLoaded('Exam')),
        ];
    }
}

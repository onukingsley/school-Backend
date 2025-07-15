<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'User' => new UserResource('User'),
            'phoneNo' => $this->phone_no,
            'formTeacher' => $this->form_teacher,
            'subject' => $this->subject,
            'dues' => new DuesResource($this->whenLoaded('Dues')),
            'staffRole' => new StaffRoleResource($this->whenLoaded('StaffRole')),
            'timeTable' => new TimeTableCollection($this->whenLoaded('TimeTable')),
            'examTable' => new ExamCollection($this->whenLoaded('ExamTable')),
            'subjectCode' => new SubjectCollection($this->whenLoaded('Subject')),
        ];
    }
}

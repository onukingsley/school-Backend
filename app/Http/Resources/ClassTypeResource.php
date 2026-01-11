<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'className' => $this->class_name,
            'numberOfStudents' => $this->number_of_students,
            'classType' => $this->class_type_name,
            'subject'=> $this->subject,
            'staff' => new StaffResource($this->whenLoaded('Staff')),
            'exam' => new ExamCollection($this->whenLoaded('Exam')),
            'Assignment' => new AssignmentCollection($this->whenLoaded('Assignment')),
            'timeTable' => new ExamCollection($this->whenLoaded('TimeTable')),
            'result' => new ExamCollection($this->whenLoaded('Result')),
            'attendance' => new AttendanceCollection($this->whenLoaded('Attendance')),
            'student' => new StudentCollection($this->whenLoaded('Student')),

        ];
    }
}

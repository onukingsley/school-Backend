<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->name,
            'student' => new StudentCollection($this->whenLoaded('student')),
            'attendance' => new AttendanceCollection($this->whenLoaded('Attendance')),
            'schoolFees' => new SchoolFeesCollection($this->whenLoaded('SchoolFees')),
            'Result' => new ResultsCollection($this->whenLoaded('Result')),
            'timeTable' => new TimeTableCollection($this->whenLoaded('TimeTable')),
            'assignment' => new AssignmentCollection($this->whenLoaded('Assignment')),
            'examTable' => new ExamCollection($this->whenLoaded('ExamTable')),
            'academicSession' => new AcademicSessionResource($this->whenLoaded('AcademicSession')),
        ];
    }
}

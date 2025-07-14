<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attendance'=>$this->attendance,
            'student'=> new StudentResource($this->whenLoaded('Student')),
            'classType'=> new ClassTypeResource($this->whenLoaded('ClassType')),
            'academicSession'=> new AcademicSessionResource($this->whenLoaded('AcademicSession')),
            'term'=> new TermResource($this->whenLoaded('Term')),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student'=>new StudentResource($this->whenLoaded('student')),
            'subject'=>new SubjectResource($this->whenLoaded('subject')),
            'classType'=>new ClassTypeResource($this->whenLoaded('classType')),
            'term'=>new TermResource($this->whenLoaded('term')),
            'grade'=>new GradeScaleResource($this->whenLoaded('grade')),
            'academicSession'=>new AcademicSessionResource($this->whenLoaded('academicSession')),
            'level'=>$this->level,
            'test1'=>$this->test1,
            'test2'=>$this->test2,
            'assignment1'=>$this->assignment1,
            'assignment2'=>$this->assignment2,
            'total'=>$this->total,
            'exam'=>$this->exam,
        ];
    }
}

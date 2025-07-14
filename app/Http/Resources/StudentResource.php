<?php

namespace App\Http\Resources;

use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->whenLoaded('User')),
            'guardian' => new GuardianResource($this->whenLoaded('Guardian')),
            'classType' => new ClassTypeResource($this->whenLoaded('ClassType')),
            'academicSession' => new AcademicSessionResource($this->whenLoaded('AcademicSession')),
            'attendance' => new AttendanceCollection($this->whenLoaded('Attendance')),
            'schoolFees' => new SchoolFeesCollection($this->whenLoaded('Schoolfees')),
            'result' => new ResultsCollection($this->whenLoaded('Result')),
            'resultCheck' => new ResultsCheckCollection($this->whenLoaded('ResultCheck')),

        ];
    }
}

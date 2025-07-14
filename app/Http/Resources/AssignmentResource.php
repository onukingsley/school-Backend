<?php

namespace App\Http\Resources;

use App\Models\Class_type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'content' => $this->content,
            'dueDate' => $this->due_date,
            'subject' => new SubjectResource($this->whenLoaded('Subject')),
            'ClassType' => new ClassTypeResource($this->whenLoaded('ClassType'))
        ];
    }
}

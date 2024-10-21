<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position->name,
            'department' => $this->department->name,
            'location' => $this->location->name,
            'job_info' => $this->title,
            'posts' => $this->posts,
            'requirements' => $this->requirements
        ];
    }
}

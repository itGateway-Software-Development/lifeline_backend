<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewEventResource extends JsonResource
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
            'title' => $this->title,
            'date' => date('d-m-Y', strtotime($this->date)),
            'content' => $this->content,
            "media" => array_map(function($media){
                return $media['original_url'];
            }, $this->media->toArray()),
        ];
    }

}

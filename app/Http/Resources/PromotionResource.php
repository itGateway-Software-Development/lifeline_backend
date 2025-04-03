<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'content' => $this->content,
            'main_img' => $this->main_img ? url('storage/images/'.$this->main_img) : null,
            "promotion_images" => array_map(function($media){
                return $media['original_url'];
            }, $this->media->toArray()),
        ];
    }
}

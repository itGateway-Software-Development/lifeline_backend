<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NewEvent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function newsImages()
    {
        return collect($this->getMedia('news_events'));
    }
}

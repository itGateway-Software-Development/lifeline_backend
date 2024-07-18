<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CsrActivity extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function csrImages()
    {
        return collect($this->getMedia('csr'));
    }
}

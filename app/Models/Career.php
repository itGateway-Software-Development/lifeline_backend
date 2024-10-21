<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }
}

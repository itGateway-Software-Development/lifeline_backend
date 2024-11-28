<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index() {
        return response()->json([
            'announcement' => new AnnouncementResource(Announcement::latest()->first())
        ]);
    }
}

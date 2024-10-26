<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\NewEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\NewEventResource;

class NewEventController extends Controller
{
    public function index(Request $request) {

        $new_events = NewEvent::with('media')->orderBy('date', 'desc')->get();

        return response()->json(['new_events' => NewEventResource::collection($new_events)]);
    }

    public function show($id) {
        $new_events = NewEvent::with('media', 'newsVideos')->find($id);

        if(is_null($new_events)) {
            return 'error';
        }

        $new_events->newsVideos->each(function ($video) {
            // Assuming `file_path` contains the filename stored under 'public/videos/'
            $video->full_url = Storage::disk('public')->url( $video->file_path);
        });

        return response()->json(['new_events' => new NewEventResource($new_events)]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewEventResource;
use App\Models\NewEvent;
use Illuminate\Http\Request;

class NewEventController extends Controller
{
    public function index(Request $request) {

        $new_events = NewEvent::with('media')->orderBy('date', 'desc')->get();

        return response()->json(['new_events' => NewEventResource::collection($new_events)]);
    }

    public function show($id) {
        $new_events = NewEvent::with('media')->find($id);

        if(is_null($new_events)) {
            return 'error';
        }

        return response()->json(['new_events' => new NewEventResource($new_events)]);
    }
}

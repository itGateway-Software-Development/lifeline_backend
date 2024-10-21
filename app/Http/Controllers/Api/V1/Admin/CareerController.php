<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Career;
use App\Mail\CareerMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CareerResource;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');

        // Search in `Career` table first
        $data = Career::with('position', 'department', 'location')
            ->where('title', 'like', "%{$searchTerm}%")
            ->get();

        // If no results in `Career`, search in `Position`
        if ($data->isEmpty()) {
            $data = Career::with('position', 'department', 'location')
                ->whereHas('position', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                })
                ->get();
        }

        // If no results in `Position`, search in `Department`
        if ($data->isEmpty()) {
            $data = Career::with('position', 'department', 'location')
                ->whereHas('department', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                })
                ->get();
        }

        // If no results in `Department`, search in `Location`
        if ($data->isEmpty()) {
            $data = Career::with('position', 'department', 'location')
                ->whereHas('location', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                })
                ->get();
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched careers',
            'careers' => CareerResource::collection($data)
        ]);

    }

    public function submitCv(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf|max:10000'
        ]);

        $mailData = [
            'file' => $request->file('file'),
            'position' => $request->position,
        ];

        Mail::to('info.hr@lifelinemyanmar.com')->send(new CareerMail($mailData));

        return response()->json([
            'status' => true,
            'message' => 'Successfully submitted your CV',
        ]);
    }
}

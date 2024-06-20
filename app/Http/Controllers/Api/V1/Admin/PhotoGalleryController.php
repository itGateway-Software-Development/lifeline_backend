<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;

class PhotoGalleryController extends Controller
{
    public function index(Request $request) {

        if($request->has('date')) {
            $photo_gallery = PhotoGallery::with('media')->where('date', $request->date)->get();
        } else {
            $photo_gallery = PhotoGallery::with('media')->get();
        }

        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return response()->json(['photo_gallery' => $photo_gallery, 'years' => $years]);
    }
}

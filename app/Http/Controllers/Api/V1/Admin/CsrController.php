<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Resources\CsrPhotoResource;
use App\Models\CsrActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CsrController extends Controller
{
    public function index(Request $request) {

        if($request->has('date')) {
            $csr = CsrActivity::with('media')->where('date', $request->date)->orderBy('date', 'desc')->get();
        } else {
            $csr = CsrActivity::with('media')->orderBy('date', 'desc')->get();
        }

        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return response()->json(['csr' => $csr, 'years' => $years]);
    }

    public function show($id) {
        $csr = CsrActivity::with('media')->find($id);

        if(is_null($csr)) {
            return 'error';
        }

        return response()->json(['csr' => $csr]);
    }

    public function getCsrPhotos() {
        $photos = DB::table('media')->where('collection_name', 'csr')->latest()->take(6)->get();

        return response()->json(['photos' => CsrPhotoResource::collection($photos)]);
    }
}

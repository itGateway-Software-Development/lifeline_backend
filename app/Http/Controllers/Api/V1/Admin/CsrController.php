<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\CsrActivity;
use Illuminate\Http\Request;

class CsrController extends Controller
{
    public function index(Request $request) {

        if($request->has('date')) {
            $csr = CsrActivity::with('media')->where('date', $request->date)->get();
        } else {
            $csr = CsrActivity::with('media')->get();
        }

        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return response()->json(['csr' => $csr, 'years' => $years]);
    }
}

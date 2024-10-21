<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function index()
    {
        $data = DB::table('locations')->select('id', 'name')->get();
        return response()->json([
            'status' => true,
            'message' => 'Successfully get all locations',
            'data' => $data
        ]);
    }
}

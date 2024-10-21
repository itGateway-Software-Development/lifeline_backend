<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    public function index()
    {
        $data = DB::table('positions')->select('id', 'name')->get();
        return response()->json([
            'status' => true,
            'message' => 'Successfully get all positions',
            'data' => $data
        ]);
    }
}

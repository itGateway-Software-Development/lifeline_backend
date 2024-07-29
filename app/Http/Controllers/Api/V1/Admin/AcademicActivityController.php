<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicActivity;
use Illuminate\Http\Request;

class AcademicActivityController extends Controller
{
    public function index() {
        $academics = AcademicActivity::all();

        return response()->json(['academic_activities' => $academics]);
    }
}

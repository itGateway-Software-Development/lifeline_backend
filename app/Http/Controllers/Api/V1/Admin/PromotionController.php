<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index() {
        $promotions = Promotion::where('status', '1')->latest()->get();

        return response()->json(['promotions' => PromotionResource::collection($promotions)]);

    }
}

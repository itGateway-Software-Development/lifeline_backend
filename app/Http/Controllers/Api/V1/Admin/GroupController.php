<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index(Request $request) {

        $keyword = $request->keyword;
        $groups = Group::where('name', 'like', "%$keyword%")->get();

        return response()->json(['groups' => GroupResource::collection($groups)]);
    }

    public function show(Group $group) {
        $group = $group->load('categories.products.media');
        return response()->json(['group' => $group]);
    }
}

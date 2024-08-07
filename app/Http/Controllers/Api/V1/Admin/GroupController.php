<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index() {
        $groups = Group::all();

        return response()->json(['groups' => GroupResource::collection($groups)]);
    }

    public function show(Group $group) {
        $group = $group->load('categories.products.media');
        return response()->json(['group' => $group]);
    }
}

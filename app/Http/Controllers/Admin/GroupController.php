<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreGroupRequest;
use App\Http\Requests\Admin\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.group.index');
    }

    public function dataTable()
    {
        $data = Group::orderBy('created_at', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('photo', function($each) {
                $url = url("/storage/images/$each->photo");
                $image = "<img src='$url' style='width: 200px;' />";
                return $image;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('group_edit')) {
                    $edit_icon = '<a href="' . route('admin.groups.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('group_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['role', 'photo', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        DB::beginTransaction();

        try {
            $group = new Group();
            $group->name = $request->name;
            $group->save();

            if ($request->file('photo')) {
                $fileName = uniqid() . $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/images/', $fileName);

                $group->photo = $fileName;
                $group->update();
            }
            DB::commit();
            return redirect()->route('admin.groups.index')->with('success', 'Successfully crated !');
        }catch(\Exception $error) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return view('admin.group.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        DB::beginTransaction();
        try{
            $group->name = $request->name;
            $group->update();

            $oldPhoto = $group->photo;

            if ($request->file('photo')) {
                if ($oldPhoto) {
                    Storage::disk('public')->delete('images/' . $oldPhoto);
                }

                $newPhoto = uniqid() . $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/images/', $newPhoto);

                $group->photo = $newPhoto;
                $group->update();
            }

            DB::commit();

            return redirect()->route('admin.groups.index')->with('success', 'Successfully edited !');
        } catch(\Exception $error) {
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        Storage::disk('public')->delete('images/' . $group->photo);
        $group->delete();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreCareerRequest;
use App\Http\Requests\Admin\UpdateCareerRequest;
use App\Models\Career;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.career_setting.career.index');
    }

    public function careerLists()
    {
        $data = Career::with('position', 'department', 'location')->orderBy('created_at', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })

            ->editColumn('position_id', function($each) {
                return $each->position->name;
            })

            ->filterColumn('position_id', function($query, $keyword) {
                $query->whereHas('position', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('department_id', function($each) {
                return $each->department->name;
            })

            ->filterColumn('department_id', function($query, $keyword) {
                $query->whereHas('department', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('location_id', function($each) {
                return $each->location->name;
            })

            ->filterColumn('location_id', function($query, $keyword) {
                $query->whereHas('location', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('requirements', function($each) {
                return substr(strip_tags($each->requirements), 0,200) . ' ...';
            })

            ->addColumn('action', function ($each) {

                $show_icon = '<a href="' . route('admin.careers.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                $edit_icon = '<a href="' . route('admin.careers.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';


                return '<div class="action-icon text-nowrap">' .$show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = DB::table('positions')->select('id', 'name')->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $locations = DB::table('locations')->select('id', 'name')->get();

        return view('admin.career_setting.career.create', compact('positions', 'departments', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCareerRequest $request)
    {
        $career = new Career();
        $career->title = $request->title;
        $career->position_id = $request->position_id;
        $career->department_id = $request->department_id;
        $career->location_id = $request->location_id;
        $career->posts = $request->posts;
        $career->requirements = $request->requirements;
        $career->save();

        return redirect()->route('admin.careers.index')->with('success', 'Successfully Added !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        return view('admin.career_setting.career.show', compact('career'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
        $positions = DB::table('positions')->select('id', 'name')->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $locations = DB::table('locations')->select('id', 'name')->get();

        return view('admin.career_setting.career.edit', compact('career', 'positions', 'departments', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCareerRequest $request, Career $career)
    {
        $career->title = $request->title;
        $career->position_id = $request->position_id;
        $career->department_id = $request->department_id;
        $career->location_id = $request->location_id;
        $career->posts = $request->posts;
        $career->requirements = $request->requirements;
        $career->update();

        return redirect()->route('admin.careers.index')->with('success', 'Successfully Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return 'success';
    }
}

<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartmentRequest;
use App\Http\Requests\Admin\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.career_setting.departments.index');
    }

    public function departmentLists()
    {
        $data = Department::orderBy('created_at', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('name', function($each) {
                return ucwords($each->name);
            })
            ->editColumn('description', function($each) {
                return substr(strip_tags($each->description), 0,200) . ' ...';
            })

            ->addColumn('action', function ($each) {

                $edit_icon = '';
                $del_icon = '';

                $edit_icon = '<a href="' . route('admin.departments.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';


                return '<div class="action-icon">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.career_setting.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();

        return redirect()->route('admin.departments.index')->with('success', 'Successfully Created !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('admin.career_setting.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->name = $request->name;
        $department->description = $request->description;
        $department->update();

        return redirect()->route('admin.departments.index')->with('success', 'Successfully Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        DB::beginTransaction();

        try {
            $department->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

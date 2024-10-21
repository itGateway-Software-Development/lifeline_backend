<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;

class LocationController extends Controller
{
    public function index() {
        return view('admin.career_setting.locations.index');
    }

    public function locationLists()
    {
        $data = Location::orderBy('created_at', 'desc');

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

                $edit_icon = '<a href="' . route('admin.locations.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';


                return '<div class="action-icon">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.career_setting.locations.create');
    }

    public function store(StoreLocationRequest $request, Location $location) {
        $location->name = $request->name;
        $location->description = $request->description;
        $location->save();

        return redirect()->route('admin.locations.index')->with('success', 'Successfully Created !');
    }

    public function edit(Location $location) {
        return view('admin.career_setting.locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, Location $location) {
        $location->name = $request->name;
        $location->description = $request->description;
        $location->update();

        return redirect()->route('admin.locations.index')->with('success', 'Successfully Updated !');
    }

    public function destroy(Location $location) {
        DB::beginTransaction();

        try {
            $location->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

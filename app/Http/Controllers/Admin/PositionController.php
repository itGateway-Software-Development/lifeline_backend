<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePositionRequest;
use App\Http\Requests\Admin\UpdatePositionRequest;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.career_setting.positions.index');
    }

    public function positionLists()
    {
        $data = Position::orderBy('created_at', 'desc');

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

                $edit_icon = '<a href="' . route('admin.positions.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';

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
        return view('admin.career_setting.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request, Position $position) {
        $position->name = $request->name;
        $position->description = $request->description;
        $position->save();

        return redirect()->route('admin.positions.index')->with('success', 'Successfully Created !');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('admin.career_setting.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $position->name = $request->name;
        $position->description = $request->description;
        $position->update();

        return redirect()->route('admin.positions.index')->with('success', 'Successfully Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        DB::beginTransaction();

        try {
            $position->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

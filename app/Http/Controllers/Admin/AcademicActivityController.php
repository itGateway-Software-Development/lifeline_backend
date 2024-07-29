<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Models\AcademicActivity;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAcademicActivityRequest;
use App\Http\Requests\Admin\UpdateAcademicActivityRequest;

class AcademicActivityController extends Controller
{
    public function index() {
        return view('admin.activity.academic.index');
    }

    public function academicActivityList()
    {
        $data = AcademicActivity::query();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('title', function($each) {
                return ucwords($each->title);
            })
            ->editColumn('link', function($each) {
                return substr($each->link, 0,200) . ' ...';
            })

            ->addColumn('action', function ($each) {

                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                $show_icon = '<a href="' . route('admin.academic-activities.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.academic-activities.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_edit')) {
                }

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_delete')) {
                }

                return '<div class="action-icon text-nowrap">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['photos', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.activity.academic.create');
    }

    public function store(StoreAcademicActivityRequest $request) {
        $academic = new AcademicActivity();
        $academic->title = $request->title;
        $academic->link = $request->link;
        $academic->full_link = $request->full_link;
        $academic->save();

        return redirect()->route('admin.academic-activities.index')->with('success', 'Successfully Created !');
    }

    public function edit(AcademicActivity $academicActivity) {
        return view('admin.activity.academic.edit', compact('academicActivity'));
    }

    public function update(UpdateAcademicActivityRequest $request, AcademicActivity $academicActivity) {
        $academicActivity->title = $request->title;
        $academicActivity->link = $request->link;
        $academicActivity->full_link = $request->full_link;
        $academicActivity->save();

        return redirect()->route('admin.academic-activities.index')->with('success', 'Successfully Updated !');
    }

    public function destroy(AcademicActivity $academicActivity) {
        DB::beginTransaction();

        try {
            $academicActivity->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }


}

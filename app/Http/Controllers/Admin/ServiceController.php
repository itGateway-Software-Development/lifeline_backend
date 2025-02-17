<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index() {
        return view('admin.company_setting.services.index');
    }

    public function serviceLists()
    {
        $data = Service::orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('title', function($each) {
                return ucwords($each->title);
            })
            ->editColumn('content', function($each) {
                return substr(strip_tags($each->content), 0,200) . ' ...';
            })

            ->editColumn('status', function($each) {
                $btn = '';
                if($each->status == 1) {
                    $btn = "<i data-id='$each->id' data-status='active' class='bx bxs-toggle-right service-status text-success fs-1 cursor-pointer'></i>";
                } else {
                    $btn = "<i data-id='$each->id' data-status='inactive' class='bx bx-toggle-left fs-1 cursor-pointer service-status' ></i>";
                }
                return $btn;
            })

            ->addColumn('action', function ($each) {

                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                $show_icon = '<a href="' . route('admin.services.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.services.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_edit')) {
                }

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_delete')) {
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.company_setting.services.create');
    }

    public function store(Request $request) {
        $service = new Service();
        $service->title = $request->title;
        $service->content = $request->content;
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Successfully Created !');
    }

    public function changeStatus(Request $request) {
       $service = Service::findOrFail($request->id);
       if($service) {
            $service->status = $request->status == 'active' ? '0': '1';
            $service->update();

            return 'success';
       }
    }

    public function show(Service $service) {
        return view('admin.company_setting.services.show', compact('service'));
    }

    public function edit(Service $service) {
        return view('admin.company_setting.services.edit', compact('service'));
    }

    public function update(Service $service, Request $request) {
        $service->title = $request->title;
        $service->content = $request->content;
        $service->update();

        return redirect()->route('admin.services.index')->with('success', 'Successfully Updated !');
    }

    public function destroy(Service $service) {
        DB::beginTransaction();

        try {
            $service->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

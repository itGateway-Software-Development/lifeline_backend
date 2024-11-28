<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Http\Requests\Admin\UpdateAnnouncementRequest;

class AnnouncementController extends Controller
{
    public function index() {
        return view('admin.announcement.index');
    }

    public function announcementLists()
    {
        $data = Announcement::query();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('image', function($each) {
                $url = url("/storage/images/$each->image");
                $image = "<img src='$url' style='width: 100px;' />";
                return $image;
            })
            ->editColumn('content', function($each) {
                return substr(strip_tags($each->content), 0,200) . ' ...';
            })

            ->addColumn('action', function ($each) {

                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                $show_icon = '<a href="' . route('admin.announcements.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.announcements.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_edit')) {
                }

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_delete')) {
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image',  'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.announcement.create');
    }

    public function store(StoreAnnouncementRequest $request) {
        DB::beginTransaction();

        try {


            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/', $fileName);

                $announcement = new Announcement();
                $announcement->image = $fileName;
                $announcement->content = $request->content;
                $announcement->save();
            }

            DB::commit();
            return redirect()->route('admin.announcements.index')->with('success', 'Successfully crated !');
        }catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    public function show(Announcement $announcement) {
        return view('admin.announcement.show', compact('announcement'));
    }

    public function edit(Announcement $announcement) {
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement) {
        DB::beginTransaction();

        try {
            $announcement->content = $request->content;
            $announcement->save();

            $oldImage = $announcement->image;

            if ($request->file('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete('images/' . $oldImage);
                }

                $newPhoto = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/', $newPhoto);

                $announcement->image = $newPhoto;
                $announcement->update();
            }

            DB::commit();
            return redirect()->route('admin.announcements.index')->with('success', 'Successfully updated !');
        }catch(\Exception $error) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    public function destroy(Announcement $announcement) {
        DB::beginTransaction();

        try {
            $announcement->delete();
            Storage::disk('public')->delete('images/' . $announcement->image);
            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

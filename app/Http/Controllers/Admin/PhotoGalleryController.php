<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdatePhotoGalleryRequest;
use DataTables;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\StorePhotoGalleryRequest;

class PhotoGalleryController extends Controller
{
    public function index() {
        return view('admin.activity.photo_gallery.index');
    }

    public function photoGalleryLists()
    {
        $data = PhotoGallery::query();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('title', function($each) {
                return ucwords($each->title);
            })
            ->editColumn('photos', function($each) {
                $image = '';
                $index = 0;
                foreach ($each->getMedia('photo_gallery') as $file) {
                    if ($index < 2) {
                        $filePath = $file->getUrl();
                        $style = "width: 40px; height: 40px; display: flex; justify-content:center; align-items:center ;border-radius: 100%; object-fit: cover; border: 1px solid #333;";
                        $style .= $index == 0 ? '' : 'margin-left: -15px;';

                        $image .= "<img src='$filePath' width='35' height='35' style='$style'/>";
                    }
                    $index++;
                }

                if ($index > 2) {
                    $index = $index - 2;
                    $image .= "<div style='$style background: #fff;'>+$index</div>";
                }

                return "<div class='d-flex align-items-center'> $image </div>";
            })
            ->addColumn('action', function ($each) {

                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('photo_gallery_show')) {
                    $show_icon = '<a href="' . route('admin.photo-gallery.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                }

                if (auth()->user()->can('photo_gallery_edit')) {
                    $edit_icon = '<a href="' . route('admin.photo-gallery.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('photo_gallery_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['photos', 'action'])
            ->make(true);

    }

    public function create() {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        return view('admin.activity.photo_gallery.create', compact('years'));
    }

    /**
     * store images from dropzone
     */
    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * delete dropzone photos
     */
    public function deleteMedia(Request $request)
    {
        $file = $request->file_name;

        File::delete(storage_path('tmp/uploads/' . $file));

        return 'success';

    }

    public function store(StorePhotoGalleryRequest $request) {
        logger($request->all());

        DB::beginTransaction();
        try {
            $photo_gallery = new PhotoGallery();
            $photo_gallery->title = $request->title;
            $photo_gallery->date = $request->date;
            $photo_gallery->save();

            foreach ($request->input('images', []) as $image) {
                $photo_gallery->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('photo_gallery');
            }

            DB::commit();
            return redirect()->route('admin.photo-gallery.index')->with('success', 'Successfully Created !');
        } catch (\Exception $error) {
            DB::rollback();
            logger($error->getMessage());
            return back()->withErrors(['fail', 'Something wrong. ' . $error->getMessage()])->withInput();
        }
    }

    public function show(PhotoGallery $photoGallery) {
        $photo_gallery = $photoGallery->load('media');
        return view('admin.activity.photo_gallery.show', compact('photo_gallery'));
    }

    public function edit(PhotoGallery $photoGallery) {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        $photo_gallery = $photoGallery->load('media');

        return view('admin.activity.photo_gallery.edit', compact('years', 'photo_gallery'));
    }

    public function update(PhotoGallery $photoGallery, UpdatePhotoGalleryRequest $request) {
        DB::beginTransaction();
        try {
            $photoGallery->title = $request->title;
            $photoGallery->date = $request->date;
            $photoGallery->update();

            if (count($photoGallery->galleryImages()) > 0) {
                foreach ($photoGallery->galleryImages() as $media) {
                    if (!in_array($media->file_name, $request->input('images', []))) {
                        logger($media);
                        $media->delete();
                    }
                }
            }

            $media = $photoGallery->galleryImages()->pluck('file_name')->toArray();

            foreach ($request->input('images', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $photoGallery->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photo_gallery');
                }
            }

            DB::commit();
            return redirect()->route('admin.photo-gallery.index')->with('success', 'Successfully Edited !');
        } catch (\Exception $error) {
            DB::rollback();
            logger($error->getMessage());
            return back()->withErrors(['fail', 'Something wrong. ' . $error->getMessage()])->withInput();
        }
    }

    public function destroy(PhotoGallery $photoGallery) {
        DB::beginTransaction();

        try {
            $photoGallery->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

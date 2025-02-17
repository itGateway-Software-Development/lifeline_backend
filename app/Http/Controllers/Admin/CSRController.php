<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\CsrVideo;
use App\Models\CsrActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreCSRRequest;
use App\Http\Requests\Admin\UpdateCSRRequest;

class CSRController extends Controller
{
    public function index() {
        return view('admin.activity.csr.index');
    }

    public function csrLists()
    {
        $data = CsrActivity::orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('title', function($each) {
                return ucwords($each->title);
            })
            ->editColumn('content', function($each) {
                return substr($each->content, 0,200) . ' ...';
            })
            ->editColumn('photos', function($each) {
                $image = '';
                $index = 0;
                foreach ($each->getMedia('csr') as $file) {
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

                $show_icon = '<a href="' . route('admin.csr-activities.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.csr-activities.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_edit')) {
                }

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_delete')) {
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['photos', 'action'])
            ->make(true);

    }

    public function create() {

        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        return view('admin.activity.csr.create', compact('years'));
    }

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

    public function store(StoreCSRRequest $request) {
        DB::beginTransaction();

        try {
            $csr = new CsrActivity();
            $csr->title = $request->title;
            $csr->date = $request->date;
            $csr->content = $request->content;
            $csr->save();

            foreach ($request->input('images', []) as $image) {
                $csr->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('csr');
            }
            foreach ($request->file('videos', []) as $uploadedVideo) {
                $fileName = uniqid() . '_' . $uploadedVideo->getClientOriginalName();
                $filePath = $uploadedVideo->storeAs('public/videos', $fileName);

                $video = new CsrVideo();
                $video->title = 'csr';
                $video->file_path = 'videos/' . $fileName;
                $video->csr_activity_id = $csr->id;
                $video->save();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Successfullly Created !']);
        } catch (\Exception $error) {
            DB::rollback();
            logger($error->getMessage());
            return back()->withErrors(['fail', 'Something wrong. ' . $error->getMessage()])->withInput();
        }
    }

    public function show(CsrActivity $csrActivity) {
        $csrActivity = $csrActivity->load('csrVideos');
        return view('admin.activity.csr.show', compact('csrActivity'));
    }

    public function edit(CsrActivity $csrActivity) {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        $csrActivity = $csrActivity->load('media');

        return view('admin.activity.csr.edit', compact('years', 'csrActivity'));
    }

    public function update(UpdateCSRRequest $request, CsrActivity $csrActivity) {
        DB::beginTransaction();
        try {
            $csrActivity->title = $request->title;
            $csrActivity->date = $request->date;
            $csrActivity->content = $request->content;
            $csrActivity->update();

            if (count($csrActivity->csrImages()) > 0) {
                foreach ($csrActivity->csrImages() as $media) {
                    if (!in_array($media->file_name, $request->input('images', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $csrActivity->csrImages()->pluck('file_name')->toArray();

            foreach ($request->input('images', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $csrActivity->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('csr');
                }
            }

            DB::commit();
            return redirect()->route('admin.csr-activities.index')->with('success', 'Successfully Updated !');
        } catch (\Exception $error) {
            DB::rollback();
            logger($error->getMessage());
            return back()->withErrors(['fail', 'Something wrong. ' . $error->getMessage()])->withInput();
        }
    }

    public function destroy(CsrActivity $csrActivity) {
        DB::beginTransaction();

        try {
            foreach ($csrActivity->csrImages() as $media) {
                $media->delete();
            }

            $videos = CsrVideo::where('csr_activity_id', $csrActivity->id)->get();

            foreach ($videos as $video) {
                logger($video->file_path);
                Storage::delete('public/'.$video->file_path);
                $video->delete();
            }
            $csrActivity->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

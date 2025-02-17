<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\NewEvent;
use App\Models\NewsVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;

class NewEventController extends Controller
{
    public function index() {
        return view('admin.activity.news.index');
    }

    public function newsList()
    {
        $data = NewEvent::orderBy('id', 'desc');

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
            ->editColumn('photos', function($each) {
                $image = '';
                $index = 0;
                foreach ($each->getMedia('news_events') as $file) {
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

                $show_icon = '<a href="' . route('admin.new-events.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.new-events.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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

        return view('admin.activity.news.create');
    }

    public function store(StoreNewsRequest $request) {
        DB::beginTransaction();

        try {
            $news = new NewEvent();
            $news->title = $request->title;
            $news->date = $request->date;
            $news->content = $request->content;
            $news->save();

            foreach ($request->input('images', []) as $image) {
                $news->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('news_events');
            }

            foreach ($request->file('videos', []) as $uploadedVideo) {
                $fileName = uniqid() . '_' . $uploadedVideo->getClientOriginalName();
                $filePath = $uploadedVideo->storeAs('public/videos', $fileName);

                $video = new NewsVideo();
                $video->title = 'news';
                $video->file_path = 'videos/' . $fileName;
                $video->new_event_id = $news->id;
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

    public function show(NewEvent $newEvent) {
        return view('admin.activity.news.show', compact('newEvent'));
    }

    public function edit(NewEvent $newEvent) {

        $newEvent = $newEvent->load('media');

        return view('admin.activity.news.edit', compact('newEvent'));
    }

    public function update(UpdateNewsRequest $request, NewEvent $newEvent) {
        DB::beginTransaction();
        try {
            $newEvent->title = $request->title;
            $newEvent->date = $request->date;
            $newEvent->content = $request->content;
            $newEvent->update();

            if (count($newEvent->newsImages()) > 0) {
                foreach ($newEvent->newsImages() as $media) {
                    if (!in_array($media->file_name, $request->input('images', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $newEvent->newsImages()->pluck('file_name')->toArray();

            foreach ($request->input('images', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $newEvent->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('news_events');
                }
            }

            DB::commit();
            return redirect()->route('admin.new-events.index')->with('success', 'Successfully Updated !');
        } catch (\Exception $error) {
            DB::rollback();
            logger($error->getMessage());
            return back()->withErrors(['fail', 'Something wrong. ' . $error->getMessage()])->withInput();
        }
    }

    public function destroy(NewEvent $newEvent) {
        DB::beginTransaction();

        try {
            foreach ($newEvent->newsImages() as $media) {
                $media->delete();
            }

            $videos = NewsVideo::where('new_event_id', $newEvent->id)->get();

            foreach ($videos as $video) {
                Storage::delete('public/'.$video->file_path);
                $video->delete();
            }
            $newEvent->delete();

            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

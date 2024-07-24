<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StorePromotionRequest;
use App\Http\Requests\Admin\UpdatePromotionRequest;

class PromotionController extends Controller
{
    public function index() {
        return view('admin.company_setting.promotion.index');
    }

    public function promotionLists()
    {
        $data = Promotion::query();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('title', function($each) {
                return ucwords($each->title);
            })
            ->editColumn('main_img', function($each) {
                $url = url("/storage/images/$each->main_img");
                $image = "<img src='$url' style='width: 100px;' />";
                return $image;
            })
            ->editColumn('info_img', function($each) {
                $url = url("/storage/images/$each->info_img");
                $image = "<img src='$url' style='width: 100px;' />";
                return $image;
            })
            ->editColumn('content', function($each) {
                return substr(strip_tags($each->content), 0,200) . ' ...';
            })

            ->editColumn('status', function($each) {
                $btn = '';
                if($each->status == 1) {
                    $btn = "<i data-id='$each->id' data-status='active' class='bx bxs-toggle-right promotion-status text-success fs-1 cursor-pointer'></i>";
                } else {
                    $btn = "<i data-id='$each->id' data-status='inactive' class='bx bx-toggle-left fs-1 cursor-pointer promotion-status' ></i>";
                }
                return $btn;
            })

            ->addColumn('action', function ($each) {

                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                $show_icon = '<a href="' . route('admin.promotions.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                if (auth()->user()->can('photo_gallery_show')) {
                }

                $edit_icon = '<a href="' . route('admin.promotions.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_edit')) {
                }

                $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                if (auth()->user()->can('photo_gallery_delete')) {
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['main_img', 'info_img', 'status', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.company_setting.promotion.create');
    }

    public function store(StorePromotionRequest $request) {
        DB::beginTransaction();

        try {
            $promotion = new Promotion();
            $promotion->title = $request->title;
            $promotion->content = $request->content;
            $promotion->save();

            if ($request->file('main_img')) {
                $fileName = uniqid() . $request->file('main_img')->getClientOriginalName();
                $request->file('main_img')->storeAs('public/images/', $fileName);

                $promotion->main_img = $fileName;
                $promotion->update();
            }

            if ($request->file('info_img')) {
                $fileName = uniqid() . $request->file('info_img')->getClientOriginalName();
                $request->file('info_img')->storeAs('public/images/', $fileName);

                $promotion->info_img = $fileName;
                $promotion->update();
            }
            DB::commit();
            return redirect()->route('admin.promotions.index')->with('success', 'Successfully crated !');
        }catch(\Exception $error) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    public function changeStatus(Request $request) {
        $promotion = Promotion::findOrFail($request->id);
        if($promotion) {
             $promotion->status = $request->status == 'active' ? '0': '1';
             $promotion->update();

             return 'success';
        }
     }

    public function show(Promotion $promotion) {
        return view('admin.company_setting.promotion.show', compact('promotion'));
    }

    public function edit(Promotion $promotion) {
        return view('admin.company_setting.promotion.edit', compact('promotion'));
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion) {
        DB::beginTransaction();

        try {
            $promotion->title = $request->title;
            $promotion->content = $request->content;
            $promotion->save();

            $oldMainImage = $promotion->main_img;
            $oldInfoImage = $promotion->info_img;

            if ($request->file('main_img')) {
                if ($oldMainImage) {
                    Storage::disk('public')->delete('images/' . $oldMainImage);
                }

                $newPhoto = uniqid() . $request->file('main_img')->getClientOriginalName();
                $request->file('main_img')->storeAs('public/images/', $newPhoto);

                $promotion->main_img = $newPhoto;
                $promotion->update();
            }

            if ($request->file('info_img')) {
                if ($oldInfoImage) {
                    Storage::disk('public')->delete('images/' . $oldInfoImage);
                }

                $newPhoto = uniqid() . $request->file('info_img')->getClientOriginalName();
                $request->file('info_img')->storeAs('public/images/', $newPhoto);

                $promotion->info_img = $newPhoto;
                $promotion->update();
            }

            DB::commit();
            return redirect()->route('admin.promotions.index')->with('success', 'Successfully updated !');
        }catch(\Exception $error) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something wrong !');
        }
    }

    public function destroy(Promotion $promotion) {
        DB::beginTransaction();

        try {
            $promotion->delete();
            Storage::disk('public')->delete('images/' . $promotion->main_img);
            Storage::disk('public')->delete('images/' . $promotion->info_img);
            DB::commit();
            return 'success';
        } catch(\Exception $error) {
            DB::rollBack();
            logger($error->getMessage());
            return 'fail';
        }
    }
}

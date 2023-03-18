<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAds;
use App\Models\Ads;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdsController extends Controller
{
    use PhotoTrait;
    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $ads = Ads::get();
            return Datatables::of($ads)
                ->addColumn('action', function ($ads) {
                    return '
                            <button type="button" data-id="' . $ads->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $ads->id . '" data-title="' . $ads->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($sliders) {
                    return '<img style="width:60px;border-radius:30px" onclick="window.open(this.src)" src="' . asset($sliders->file) . '"/>';
                })
                ->editColumn('status', function ($ads) {
                    if($ads->status == 'true') {
                        return '<a href="' . route('activateAds', $ads->id) . '" class="btn btn-pill btn-success-light">مفعل</a>';
                    }
                    else {
                        return '<a href="' . route('activateAds', $ads->id) . '" class="btn btn-pill btn-danger-light">غير مفعل</a>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.ads.index');
        }
    }

    // End Index

    // Activate

    public function activateAds($id)
    {
        $ads = Ads::where('id', $id)->first();

        if ($ads->update([
            'status' => $ads->status == 'true' ? 'false' : 'true'
        ])) {
            if($ads->status == 'true')
            {
                toastr('تم التفعيل');
            }
            else
            {
                toastr('تم ألغاء التفعيل');
            }

            return view('admin.ads.index');
        }
    }

    // Activate

    // Start Create

    public function create()
    {
        return view('admin.ads.parts.create');
    }

    // Create End

    // Store Start

    public function store(RequestAds $request)
    {
        $inputs = $request->all();
        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Ads/image', 'photo');
            if($request->type == '0')
            {
                $inputs['type'] = 'image';
            }
            else
            {
                $inputs['type'] = 'video';
            }
        }

        if(Ads::create($inputs)) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(Ads $ad)
    {
        return view('admin.ads.parts.edit', compact('ad'));
    }

    // Edit End

    // Update Start

    public function update(RequestAds $request, Ads $ad)
    {

        $inputs = $request->all();

        if ($request->has('file')) {
            if($request->type == '0')
            {
                if (file_exists($ad->file)) {
                    unlink($ad->file);
                }
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Ads/image', 'photo');
                $inputs['type'] = 'image';
            }
            else
            {
                if (file_exists($ad->file)) {
                    unlink($ad->file);
                }
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Ads/video', 'photo');
                $inputs['type'] = 'video';
            }
        }

        if($ad->update($inputs)){
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $sliders = Ads::where('id', $request->id)->firstOrFail();
        $sliders->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

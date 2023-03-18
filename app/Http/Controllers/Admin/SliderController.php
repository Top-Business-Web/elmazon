<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestSlider;
use App\Models\Slider;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    use PhotoTrait;
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::get();
            return Datatables::of($sliders)
                ->addColumn('action', function ($sliders) {
                    return '
                            <button type="button" data-id="' . $sliders->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $sliders->id . '" data-title="' . $sliders->image . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('file', function ($sliders) {
                    return '<img style="width:60px;border-radius:30px" onclick="window.open(this.src)" src="' . asset($sliders->file) . '"/>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.sliders.index');
        }
    }
    // Index End

    // Create Start

    public function create()
    {
        return view('admin.sliders.parts.create');
    }

    // Create End

    // Store Start

    public function store(RequestSlider $request)
    {
        $inputs = $request->all();
        if($request->hasFile('file')){
            if($request->type == '0')
            {
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Slider/image', 'photo');
                $inputs['type'] = 'image';
            }
            else
            {
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Slider/video', 'video');
                $inputs['type'] = 'video';
            }

        }
        if(Slider::create($inputs)) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(Slider $slider)
    {
        return view('admin.sliders.parts.edit', compact('slider'));
    }

    // Edit End

    // Update Start

    public function update(RequestSlider $request, Slider $slider)
    {

        $inputs = $request->all();

        if ($request->has('file')) {
            if($request->type == '0')
            {
                if (file_exists($slider->file)) {
                    unlink($slider->file);
                }
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Ads/image', 'photo');
                $inputs['type'] = 'image';
            }
            else
            {
                if (file_exists($slider->file)) {
                    unlink($slider->file);
                }
                $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/Ads/video', 'photo');
                $inputs['type'] = 'video';
            }
        }
        if($slider->update($inputs)){
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
        $sliders = Slider::where('id', $request->id)->firstOrFail();
        $sliders->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

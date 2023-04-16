<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoBasic;
use App\Http\Requests\UpdateVideoBasic;
use App\Models\VideoBasic;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VideoBasicController extends Controller
{
    use PhotoTrait;
    // Index Start
    public function index(request $request)
    {
        $videbasics = VideoBasic::all();
        if ($request->ajax()) {
            return Datatables::of($videbasics)
                ->addColumn('action', function ($videbasics) {
                    return '
                            <button type="button" data-id="' . $videbasics->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $videbasics->id . '" data-title="' . $videbasics->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>

                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.index');
        }
    }

    // Index End



    // Create Start

    public function create()
    {
        return view('admin.video_basic.parts.create');
    }
    // Create End

    // Store Start

    public function store(StoreVideoBasic $request)
    {
        $inputs = $request->all();
        if($request->hasFile('video_link')){
                $inputs['video_link'] = $this->saveImage($request->video_link, 'assets/uploads/video_basic/image', 'photo');
        }
        if(VideoBasic::create($inputs)) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End


    // Edit Start

    public function edit(VideoBasic $videoBasic)
    {
        return view('admin.video_basic.parts.edit', compact('videoBasic'));
    }


    // Edit End

    // Update Start

    public function update(UpdateVideoBasic $request, VideoBasic $videoBasic)
    {
        $inputs = $request->all();
        if($request->hasFile('video_link')){
            $inputs['video_link'] = $this->saveImage($request->video_link, 'assets/uploads/video_basic/image', 'photo');
        }

        if ($videoBasic->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $terms = VideoBasic::where('id', $request->id)->firstOrFail();
        $terms->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

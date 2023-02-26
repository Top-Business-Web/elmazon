<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoPart;
use App\Models\VideoPart;
use App\Models\Lesson;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class VideoPartController extends Controller
{
    use PhotoTrait;
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $videoParts = VideoPart::get();
            return Datatables::of($videoParts)
                ->addColumn('action', function ($videoParts) {
                    return '
                            <button type="button" data-id="' . $videoParts->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $videoParts->id . '" data-title="' . $videoParts->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.videopart.index');
        }
    }

    // Index End

    // Create start

    public function create()
    {
        $lessons = Lesson::get();
        return view('admin.videopart.parts.create', compact('lessons'));
    }

    // Create End

    // Store start

    public function store(StoreVideoPart $request)
    {
        $file = $request->file('video_link');
        $file->move('uploads/videos', $file->getClientOriginalName());
        $file_name = $file->getClientOriginalName();

        $insert = new VideoPart();
        $insert->video_link = $file_name;
        $insert->name_ar = $request->name_ar;
        $insert->name_en = $request->name_en;
        $insert->note = $request->note;
        $insert->lesson_id = $request->lesson_id;
        $insert->video_time = $request->video_time;
        $insert->save();

        if($insert->save() == true) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit start

    public function edit(VideoPart $videosPart)
    {
        $lessons = Lesson::get();
        return view('admin.videopart.parts.edit', compact('videosPart', 'lessons'));
    }

    // Edit End

    // Update start

    public function update(VideoPart $videoParts, StoreVideoPart $request)
    {
        $videoParts = VideoPart::findOrFail($request->id);
        if($request->has('video_link')){
            if(file_exists('uploads/videos/'. $videoParts->video_link)){
                unlink('uploads/videos/'. $videoParts->video_link);
            }
            $file = $request->file('video_link');
            $file->move('uploads/videos', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
            $videoParts->video_link = $file_name;
        }


        $videoParts->name_ar = $request->name_ar;
        $videoParts->name_en = $request->name_en;
        $videoParts->note = $request->note;
        $videoParts->lesson_id = $request->lesson_id;
        $videoParts->video_time = $request->video_time;
        $videoParts->save();

        if($videoParts->save() == true) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }

    }

    // Update end

    // Destroy Start

    public function destroy(Request $request)
    {
        $videoParts = VideoPart::where('id' ,$request->id)->firstOrFail();
        $videoParts->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

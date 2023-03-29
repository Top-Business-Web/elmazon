<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoPart;
use App\Models\VideoParts;
use App\Models\Lesson;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

// fix
class VideoPartController extends Controller
{
    use PhotoTrait;
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $videoParts = VideoParts::get();
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
                ->editColumn('lesson_id', function ($videoParts) {
                    return '<td>'. $videoParts->lesson->name_ar .'</td>';
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
        $insert = new VideoParts();
        $file = $request->file('link');
        if($request->link == '3')
        {
            $file->move('uploads/videos', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        }
        if($request->link == '2')
        {
            $insert->link = $request->link;
        }


        $insert->link = $file_name;
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

    public function edit(VideoParts $videosPart)
    {
        $lessons = Lesson::get();
        return view('admin.videopart.parts.edit', compact('videosPart', 'lessons'));
    }

    // Edit End

    // Update start

    public function update(VideoParts $videoParts, StoreVideoPart $request)
    {
        $videoParts = VideoParts::findOrFail($request->id);
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
        $videoParts = VideoParts::where('id' ,$request->id)->firstOrFail();
        $videoParts->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End

    // Drag Start

    public function updateItems(Request $request)
    {
        $input = $request->all();

        foreach ($input['panddingArr'] as $key => $value) {
            $key = $key+1;
            Item::where('id',$value)->update(['status'=>0,'order'=>$key]);
        }

        foreach ($input['completeArr'] as $key => $value) {
            $key = $key+1;
            Item::where('id',$value)->update(['status'=>1,'order'=>$key]);
        }

        return response()->json(['status'=>'success']);
    }

    // Drag End
}

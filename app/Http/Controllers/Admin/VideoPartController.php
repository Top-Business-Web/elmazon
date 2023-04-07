<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\Traits\FirebaseNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoPart;
use App\Models\VideoParts;
use App\Models\Lesson;
use App\Models\VideoRate;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

// fix
class VideoPartController extends Controller
{
    use PhotoTrait;

    use FirebaseNotification;

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
                                    data-id="' . $videoParts->id . '" data-title="' .' '. $videoParts->name_ar .' '. '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('lesson_id', function ($videoParts) {
                    return $videoParts->lesson->name_ar;
                })
                ->addColumn('rate', function ($videoParts) {
                    $like = VideoRate::where('video_id', $videoParts->id)
                        ->where('action','=', 'like')
                        ->count('action');
                    $disLike = VideoRate::where('video_id', $videoParts->id)
                        ->where('action','=', 'dislike')
                        ->count('action');
                    return  $like . ' <i class="fa fa-thumbs-up ml-2 mr-2 text-success"></i> ' . $disLike . '<i class="fa fa-thumbs-down text-danger ml-2 mr-2"></i>' ;
                })
                ->editColumn('link', function ($videoParts) {
                    if ($videoParts->type == 'video')
                        return '<a href="' . asset('videos/' . $videoParts->link) . '">
                                لينك الفيديو
                            </a>';
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
        $last_orderd = DB::table('video_parts')->orderBy('id', 'DESC')->first()->ordered;
        $insert = new VideoParts();
        $file = $request->file('link');
        $file_name = '';

        if ($request->hasFile('link')) {
            $extension = $file->getClientOriginalExtension();
            $allowed_file_types = ['pdf', 'mp3', 'mp4'];

            if (in_array($extension, $allowed_file_types)) {
                $file_name = $file->getClientOriginalName();

                if ($extension == 'pdf') {
                    $file->move('Pdfs', $file_name);
                    $insert->type = 'pdf';
                } elseif ($extension == 'mp3') {
                    $file->move('Audios', $file_name);
                    $insert->type = 'audio';
                } elseif ($extension == 'mp4') {
                    $file->move('videos', $file_name);
                    $insert->type = 'video';
                }

                $insert->link = $file_name;
            } else {
                return response()->json(['status' => 405, 'message' => 'Invalid file type']);
            }
        }

        $insert->name_ar = $request->name_ar;
        $insert->name_en = $request->name_en;
        $insert->note = $request->note;
        $insert->video_time = $request->video_time;
        $insert->lesson_id = $request->lesson_id;
        $insert->ordered = $last_orderd + 1;

        if ($insert->save()) {

//            $this->sendFirebaseNotification(['title' => 'اشعار جديد', 'body' => $request->name_ar, 'term_id' => $request->term_id],$request->season_id);
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405, 'message' => 'Failed to save the record']);
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

    public function update(Request $request, $id)
    {
        $videoPart = VideoParts::find($id);

        if (!$videoPart) {
            return response()->json(['status' => 404, 'message' => 'Record not found']);
        }

        $file = $request->file('link');
        $file_name = '';

        if ($request->hasFile('link')) {
            $extension = $file->getClientOriginalExtension();
            $allowed_file_types = ['pdf', 'mp3', 'mp4'];

            if (in_array($extension, $allowed_file_types)) {
                $file_name = $file->getClientOriginalName();

                if ($extension == 'pdf') {
                    $file->move('Pdfs', $file_name);
                    $videoPart->type = 'pdf';
                } elseif ($extension == 'mp3') {
                    $file->move('Audios', $file_name);
                    $videoPart->type = 'audio';
                } elseif ($extension == 'mp4') {
                    $file->move('videos', $file_name);
                    $videoPart->type = 'video';
                }

                $videoPart->link = $file_name;
            } else {
                return response()->json(['status' => 405, 'message' => 'Invalid file type']);
            }
        }

        $videoPart->name_ar = $request->name_ar;
        $videoPart->name_en = $request->name_en;
        $videoPart->note = $request->note;
        $videoPart->video_time = $request->video_time;
        $videoPart->lesson_id = $request->lesson_id;

        if ($videoPart->save()) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405, 'message' => 'Failed to save the record']);
        }
    }


    // Update end

    // Destroy Start

    public function destroy(Request $request)
    {
        $videoParts = VideoParts::where('id', $request->id)->firstOrFail();
        $videoParts->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End

    // Drag Start

    public function updateItems(Request $request)
    {
        $input = $request->all();

        foreach ($input['panddingArr'] as $key => $value) {
            $key = $key + 1;
            Item::where('id', $value)->update(['status' => 0, 'order' => $key]);
        }

        foreach ($input['completeArr'] as $key => $value) {
            $key = $key + 1;
            Item::where('id', $value)->update(['status' => 1, 'order' => $key]);
        }

        return response()->json(['status' => 'success']);
    }

    // Drag End
}

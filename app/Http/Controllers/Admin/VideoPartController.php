<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\Traits\FirebaseNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoPart;
use App\Models\Comment;
use App\Models\CommentReplay;
use App\Models\VideoFilesUploads;
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
                                    data-id="' . $videoParts->id . '" data-title="' . ' ' . $videoParts->name_ar . ' ' . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                             <button type="button" data-id="' . $videoParts->id . '" class="btn btn-pill btn-info-light addFile"><i class="fa fa-file"></i>الملحقات</button>
                            <a href="' . route('indexCommentVideo', $videoParts->id) . '" data-id="' . $videoParts->id . '" class="btn btn-pill btn-success-light"> تعليقات <i class="fa fa-comment"></i></a>
                       ';
                })
                ->editColumn('lesson_id', function ($videoParts) {
                    return $videoParts->lesson->name_ar;
                })
                ->addColumn('rate', function ($videoParts) {
                    $like = VideoRate::where('video_id', $videoParts->id)
                        ->where('action', '=', 'like')
                        ->count('action');
                    $disLike = VideoRate::where('video_id', $videoParts->id)
                        ->where('action', '=', 'dislike')
                        ->count('action');
                    return $like . ' <i class="fa fa-thumbs-up ml-2 mr-2 text-success"></i> ' . $disLike . '<i class="fa fa-thumbs-down text-danger ml-2 mr-2"></i>';
                })
                ->editColumn('link', function ($videoParts) {
                    return '<a target="_blank" href="' . asset('videos/' . $videoParts->link) . '">
                                <span class="badge badge-secondary">لينك الفيديو</span>
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.videopart.index');
        }
    }

    // Index End

    // Video Part Comment

    public function indexCommentVideo(Request $request, $id)
    {
        if ($request->ajax()) {
            $comments = Comment::where('video_part_id', $id)->get();
            return Datatables::of($comments)
                ->addColumn('action', function ($comments) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $comments->id . '" data-title="' . $comments->comment . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                                <button type="button" data-id="' . $comments->id . '" class="btn btn-pill btn-primary-light addReply"><i class="fa fa-plus"></i>اضافة رد</button>
                            <a href="' . route('indexCommentVideoReply', $comments->id) . '" class="btn btn-pill btn-success-light">الردود<li class="fa fa-reply"></li></a>
                       ';
                })
                ->editColumn('user_id', function ($comments) {
                    return '<td>' . $comments->user->name . '</td>';
                })
                ->editColumn('image', function ($comments) {
                    if ($comments->image)
                        return '<a href="' . asset('comments_upload_file/' . $comments->image) . '">
                                ' . $comments->image . '
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.videopart.parts.comments', compact('id'));
        }
    }

    public function indexCommentVideoCreate($id)
    {
        return view('admin.videopart.parts.store_comment', compact('id'));
    }

    // Save Comment
    public function storeReplyVideo(Request $request)
    {
        $parentComment = Comment::find($request->id);
        if (!$parentComment) {
            return redirect()->back()->with('error', 'Parent comment not found.');
        }

        $reply = new CommentReplay();
        $reply->comment = $request->comment;
        $reply->comment_id = $request->id;
        $reply->user_type = 'teacher';
        $reply->teacher_id = auth('admin')->user()->id;

        $reply->save();

        return response()->json(['status' => 200]);
    }

    // Video Part Comment Reply

    public function indexCommentVideoReply(Request $request, $id)
    {
        if ($request->ajax()) {
            $comments_replys = CommentReplay::where('comment_id', $id)
                ->get();
            return Datatables::of($comments_replys)
                ->addColumn('action', function ($comments_replys) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $comments_replys->id . '" data-title="' . $comments_replys->comment . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('teacher_id', function ($comments_replys) {
                    return '<td>' . @$comments_replys->teacher->name . '</td>';
                })
                ->editColumn('student_id', function ($comments_replys) {
                    return '<td>' . @$comments_replys->student->name . '</td>';
                })
                ->editColumn('image', function ($comments_replys) {
                    if ($comments_replys->image)
                        return '<a href="' . asset('comments_upload_file/' . $comments_replys->image) . '">
                                ' . $comments_replys->image . '
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.videopart.parts.comment_reply', compact('id'));
        }
    }

    // Delete comment Reply
    public function deleteCommentVideoReply(Request $request)
    {
        $comment_reply = CommentReplay::where('id', $request->id)->firstOrFail();
        $comment_reply->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }


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
//        $last_orderd = DB::table('video_parts')->orderBy('id', 'DESC')->first()->ordered;
        $videoPart = new VideoParts();
        $file = $request->file('link');
        $file_name = '';

        if ($request->hasFile('link')) {
            $file_name = $file->getClientOriginalName();
            $file->move('videos', $file_name);
            $videoPart->link = $file_name;
        } else {
            return response()->json(['status' => 405, 'message' => 'Invalid file type']);
        }


        $videoPart->name_ar = $request->name_ar;
        $videoPart->name_en = $request->name_en;
        $videoPart->note = $request->note;
        $videoPart->video_time = $request->video_time;
        $videoPart->lesson_id = $request->lesson_id;
        $videoPart->background_color = $request->background_color;
//        $videoPart->ordered = $last_orderd + 1;

        if ($videoPart->save()) {
            $this->sendFirebaseNotification(['title' => 'اشعار جديد', 'body' => $request->name_ar, 'term_id' => $request->term_id], $request->season_id);
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405, 'message' => 'Failed to save the record']);
        }
    }

// Store End

// Edit start

    public
    function edit(VideoParts $videosPart)
    {
        $lessons = Lesson::get();
        return view('admin.videopart.parts.edit', compact('videosPart', 'lessons'));
    }

// Edit End

// Update start

    public
    function update(Request $request, $id)
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

    public
    function destroy(Request $request)
    {
        $videoParts = VideoParts::where('id', $request->id)->firstOrFail();
        $videoParts->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

// Destroy End

// Drag Start

    public
    function updateItems(Request $request)
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
    }// Drag End


    public function showFiles(Request $request, $id)
    {
        $files = VideoFilesUploads::where('video_part_id', '=', $id)->get();
        return view('admin.videopart.parts.files', compact('id', 'files'));
    } // Show Files

    public function modifyFiles(Request $request, $id)
    {

        if ($request->has('file_link')) {

            $file = $request->file('file_link');
            $file_name = $file->getClientOriginalName();

            if ($request->type == 'pdf') {
                $file->move('video_files/pdf', $file_name);
            } else {
                $file->move('video_files/audios', $file_name);
            }
        }

        VideoFilesUploads::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'background_color' => $request->background_color, // default
            'file_link' => $file_name,
            'file_type' => $request->type,
            'video_part_id' => $id,
        ]);

        return response()->json(['status' => 200]);
    } // Modify Files

    public function deleteFiles(Request $request)
    {
        $id = $request->id;
        VideoFilesUploads::find($id)->delete();
        return response()->json(['status' => 'تم الحذف بنجاح']);
    }
}

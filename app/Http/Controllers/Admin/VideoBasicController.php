<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentReplay;
use App\Models\VideoBasic;
use App\Models\Report;
use App\Models\Comment;
use App\Traits\AdminLogs;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VideoBasicController extends Controller
{
    use PhotoTrait , AdminLogs;
    // Index Start
    public function index(request $request)
    {
        $video_basics = VideoBasic::all();
        $comment = Comment::where('video_part_id', $request->id);
        if ($request->ajax()) {
            return Datatables::of($video_basics)
                ->addColumn('action', function ($video_basics) {
                    return '
                            <button type="button" data-id="' . $video_basics->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $video_basics->id . '" data-title="' . $video_basics->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                             <a href="' . route('indexComment', $video_basics->id) . '" data-id="' . $video_basics->id . '" class="btn btn-pill btn-success-light"> تعليقات '. $video_basics->comment->count() .' <i class="fa fa-comment"></i></a>
                             <a href="' . route('reportBasic', $video_basics->id) . '" data-id="' . $video_basics->id . '" class="btn btn-pill btn-danger-light"> بلاغات '. $video_basics->report->count() .' <i class="fe fe-book"></i></a>
                       ';
                })
                ->editColumn('like_active', function ($video_basics) {
                        return '<input class="tgl tgl-ios like_active" data-id="'. $video_basics->id .'" name="like_active" id="like-' . $video_basics->id . '" type="checkbox" '. ($video_basics->like_active == 1 ? 'checked' : 'unchecked') .'/>
                        <label class="tgl-btn" dir="ltr" for="like-' . $video_basics->id . '"></label>';
                })
                ->editColumn('view_active', function ($video_basics) {
                        return '<input class="tgl tgl-ios view_active" data-id="'. $video_basics->id .'" name="view_active" id="view-' . $video_basics->id . '" type="checkbox" '. ($video_basics->view_active == 1 ? 'checked' : 'unchecked') .'/>
                        <label class="tgl-btn" dir="ltr" for="view-' . $video_basics->id . '"></label>';
                })
                ->editColumn('video_link', function ($video_basics) {
                    if ($video_basics->video_link)
                        return '<a href="' . asset($video_basics->video_link) . '">
                                ' . $video_basics->video_link . '
                            </a>';
                })
                ->editColumn('background_color', function ($video_basics) {
                    return '<input type="color" class="form-control" name="background_color"
                           value="' . $video_basics->background_color . '" disabled>';
                })
                ->editColumn('video_part_id', function ($video_basics) {
                    if ($video_basics->video_part_id) {
                        return '<a href="' . asset('videos/'.$video_basics->video_part_id) . '">'
                            . ($video_basics->video_part_id ? $video_basics->video_part_id : '____') .
                            '</a>';
                    } else {
                        return '____';
                    }
                })
                ->editColumn('video_basic_id', function ($video_basics) {
                    if ($video_basics->video_basic_id) {
                        return '<a href="' . asset('videos_basics/'.$video_basics->video_basic_id) . '">'
                            . ($video_basics->video_basic_id ? $video_basics->video_basic_id : '____') .
                            '</a>';
                    } else {
                        return '____';
                    }
                })
                ->editColumn('video_resource_id', function ($video_basics) {
                    if ($video_basics->video_resource_id) {
                        return '<a href="' . asset('videos_resources/'.$video_basics->video_resource_id) . '">'
                            . ($video_basics->video_resource_id ? $video_basics->video_resource_id : '____') .
                            '</a>';
                    } else {
                        return '____';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.index');
        }
    }

    // Index End

    // Report Start
    public function reportBasic(Request $request, $id)
    {

        $reports = Report::where('video_basic_id', $id)->get();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->addColumn('action', function ($reports) {
                    return '
                    <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                    data-id="' . $reports->id . '" data-title="' . $reports->report
                     . '">
                    <i class="fas fa-trash"></i>
            </button>
                       ';
                })
                ->editColumn('user_id', function ($reports) {

                        return '<td>'. $reports->user->name .'</td>';
                })
                ->editColumn('video_basic_id', function ($reports) {
                    return '<a href="' . asset('video_basic/'.$reports->video_basic_id) . '">'
                           . $reports->video_basic->name_ar .
                        '</a>';
            })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.parts.report', compact('id'));
        }
    }

    // Report End

    // Video Basic Comment

    public function indexComment(Request $request, $id)
    {
        if ($request->ajax()) {
            $comments = Comment::where('video_basic_id', $id)->get();
            return Datatables::of($comments)
                ->addColumn('action', function ($comments) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $comments->id . '" data-title="' . $comments->comment . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" data-id="' . $comments->id . '" class="btn btn-pill btn-primary-light addReply"><i class="fa fa-plus"></i>اضافة رد</button>
                            <a href="' . route('indexCommentReply', $comments->id) . '" class="btn btn-pill btn-success-light">الردود<li class="fa fa-reply"></li></a>
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
            return view('admin.video_basic.parts.comments', compact('id'));
        }
    }

    // Create Comment
    public function indexCommentCreate($id)
    {
        return view('admin.video_basic.parts.store_comment', compact('id'));
    }

    // Video Basic Comment Reply

    public function indexCommentReply(Request $request, $id)
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
                    return '<td>' . @$comments_replys->teacher->name  . '</td>';
                })
                ->editColumn('student_id', function ($comments_replys) {
                    return '<td>' . @$comments_replys->student->name  . '</td>';
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
            return view('admin.video_basic.parts.comment_reply', compact('id'));
        }
    }

    // Delete comment Reply
    public function deleteCommentReply(Request $request)
    {
        $comment_reply = CommentReplay::where('id', $request->id)->firstOrFail();
        $comment_reply->delete();
        $this->adminLog('تم حذف الرد علي التعليق');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete comment Reply
    public function deleteReport(Request $request)
    {
        $report_delete = Report::where('id', $request->id)->firstOrFail();
        $report_delete->delete();
        $this->adminLog('تم حذف بلاغ');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Save Comment
    public function storeReply(Request $request)
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
        $this->adminLog('تم اضافة رد علي تعليق');
        return response()->json(['status' => 200]);
    }


    // // Video Basic Comment Reply

    public function videoBasicCommentReply($id)
    {
        $users = CommentReplay::where('student_id', $id)
            ->OrWhere('teacher_id', $id)
            ->orderByDesc('created_at')
            ->get();
        //        return $users;
        return view('admin.video_basic.parts.comment_reply', compact('users'));
    }


    // Create Start

    public function create()
    {
        return view('admin.video_basic.parts.create');
    }
    // Create End

    // Store Start

    public function store(Request $request)
    {
        $inputs = $request->all();
        if ($request->hasFile('video_link')) {
            $inputs['video_link'] = $this->saveImage($request->video_link, 'videos_basics/', 'photo');
        }
        if (VideoBasic::create($inputs)) {
            $this->adminLog('تم اضافة فيديو اساسيات');
            return response()->json(['status' => 200]);
        } else {
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

    public function update(Request $request, VideoBasic $videoBasic)
    {
        $inputs = $request->all();
        if ($request->hasFile('video_link')) {
            $inputs['video_link'] = $this->saveImage($request->video_link, 'videos_basics/', 'photo');
        }

        if ($videoBasic->update($inputs)) {
            $this->adminLog('تم تعديل فيديو اساسيات');
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
        $this->adminLog('تم حذف فيديو اساسيات');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End


    public function likeActive(Request $request)
    {
        $like = $request->like_active;
        $video = VideoBasic::findOrFail($request->id);
        $video->like_active = $like;
        $video->save();
    }

    public function viewActive(Request $request)
    {
        $view = $request->view_active;
        $video = VideoBasic::findOrFail($request->id);
        $video->view_active = $view;
        $video->save();
    }
}

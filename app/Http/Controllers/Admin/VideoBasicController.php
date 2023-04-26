<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoBasic;
use App\Http\Requests\UpdateVideoBasic;
use App\Models\CommentReplay;
use App\Models\VideoBasic;
use App\Models\Comment;
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
                             <a href="' . route('indexComment', $videbasics->id) . '" data-id="' . $videbasics->id . '" class="btn btn-pill btn-success-light"> تعليقات <i class="fa fa-comment"></i></a>

                       ';
                })
                ->editColumn('video_link', function ($videbasics) {
                    if ($videbasics->video_link)
                        return '<a href="' . asset($videbasics->video_link) . '">
                                '.$videbasics->video_link.'
                            </a>';
                })
                ->editColumn('background_color', function ($videbasics) {
                    return '<input type="color" class="form-control" name="background_color"
                           value="'. $videbasics->background_color .'" disabled>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.index');
        }
    }

    // Index End

    // Video Basic Comment

    public function indexComment(Request $request,$id)
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
                        return '<td>'. $comments->user->name .'</td>';
                })
                ->editColumn('image', function ($comments) {
                    if ($comments->image)
                        return '<a href="' . asset('comments_upload_file/'.$comments->image) . '">
                                '.$comments->image.'
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.parts.comments',compact('id'));
        }
    }

    // Create Comment
    public function indexCommentCreate($id)
    {
        return view('admin.video_basic.parts.store_comment', compact('id'));
    }

    // Video Basic Comment Reply

    public function indexCommentReply(Request $request,$id)
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
                    return '<td>'. @$comments_replys->teacher->name  .'</td>';
                })
                ->editColumn('student_id', function ($comments_replys) {
                    return '<td>'. @$comments_replys->student->name  .'</td>';
                })
                ->editColumn('image', function ($comments_replys) {
                    if ($comments_replys->image)
                        return '<a href="' . asset('comments_upload_file/'.$comments_replys->image) . '">
                                '.$comments_replys->image.'
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_basic.parts.comment_reply',compact('id'));
        }
    }

    // Delete comment Reply
    public function deleteCommentReply(Request $request)
    {
        $comment_reply = CommentReplay::where('id', $request->id)->firstOrFail();
        $comment_reply->delete();
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

        return response()->json(['status' => 200]);
    }


    // // Video Basic Comment Reply

    public function videoBasicCommentReply($id)
    {
        $users = CommentReplay::where('student_id', $id)
            ->OrWhere('teacher_id',$id)
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\CommentReplay;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $comments = Comment::get();
            return Datatables::of($comments)
                ->addColumn('action', function ($comments) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $comments->id . '" data-title="' . $comments->comment . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <a href="' . route('replyComment', $comments->id) . '" class="btn btn-pill btn-success-light"><li class="fa fa-comment"></li></a>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.comments.index');
        }
    }

    // End Index

    // Reply Comment START

    public function replyComment($id)
    {
        $replyComments = CommentReplay::where('comment_id', $id)->get();
        return view('admin.comments.parts.reply_comment', compact('replyComments'));
    }

    // Reply Comment END

    // Destroy Start

    public function destroy(Request $request)
    {
        $comments = Comment::where('id', $request->id)->firstOrFail();
        $comments->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End

    // Destroy Reply Comment Start

    public function replyCommentDelete($id)
    {
        $guide = CommentReplay::find($id);
        $guide->delete();
        toastr('تم الحذف بنجاح');
        return redirect()->back();
    }


    // Destroy Reply Comment END
}

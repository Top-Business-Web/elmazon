<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
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
                            <a href="" class="btn btn-pill btn-success-light"><li class="fa fa-comment"></li></a>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.comments.index');
        }
    }

    // End Index

    // Destroy Start

    public function destroy(Request $request)
    {
        $comments = Comment::where('id', $request->id)->firstOrFail();
        $comments->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

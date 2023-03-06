<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuggestionController extends Controller
{
    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $suggestions = Suggestion::get();
            return Datatables::of($suggestions)
                ->addColumn('action', function ($suggestions) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $suggestions->id . '" data-title="' . $suggestions->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.suggestions.index');
        }
    }

    // End Index

    // Delete Start

    public function delete(Request $request)
    {
        $suggestion = Suggestion::where('id', $request->id)->firstOrFail();
        $suggestion->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

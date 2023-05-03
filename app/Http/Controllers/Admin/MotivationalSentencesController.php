<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MotivationalExport;
use App\Http\Controllers\Controller;
use App\Imports\MotivationalImport;
use App\Models\MotivationalSentences;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class MotivationalSentencesController extends Controller
{

    // Index START
    public function index(request $request)
    {
        if ($request->ajax()) {
            $sentences = MotivationalSentences::get();
            return Datatables::of($sentences)
                ->addColumn('action', function ($sentences) {
                    return '
                            <button type="button" data-id="' . $sentences->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $sentences->id . '" data-title="' . $sentences->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.motivational_sentences.index');
        }
    }

    // End Index

    // Create START

    public function create()
    {
        return view('admin.motivational_sentences.parts.create');
    }

    // Create END

    // Store START

    public function store(Request $request)
    {
        $inputs = $request->all();
        if (MotivationalSentences::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store END

    // Edit START

    public function edit(MotivationalSentences $motivational)
    {
        return view('admin.motivational_sentences.parts.edit', compact('motivational'));
    }
    // Edit END

    // Update START

    public function update(Request $request, MotivationalSentences $motivational)
    {
        if ($motivational->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update END

    // Delete START

    public function destroy(Request $request)
    {
        $sentences = MotivationalSentences::where('id', $request->id)->firstOrFail();
        $sentences->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete END
    public function motivationalExport()
    {
        return Excel::download(new MotivationalExport, 'Motivational.xlsx');
    } // end motivationalExport

    public function motivationalImport(Request $request)
    {
        $import = Excel::import(new MotivationalImport(), $request->exelFile);
        if ($import)
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 500]);
    } // end question import

}

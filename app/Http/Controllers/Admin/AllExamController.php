<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllExam;
use App\Models\Season;
use App\Models\Term;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AllExamController extends Controller
{
    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $all_exams = AllExam::get();
            return Datatables::of($all_exams)
                ->addColumn('action', function ($all_exams) {
                    return '
                            <button type="button" data-id="' . $all_exams->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $all_exams->id . '" data-title="' . $all_exams->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.all_exams.index');
        }
    }

    // End Index

    // Start Create

    public function create()
    {
        $data['terms'] = Term::all();
        $data['seasons'] = Season::all();
        return view('admin.all_exams.parts.create', compact('data'));
    }

    // Create End

    // Store Start

    public function store(Request $request, AllExam $allExam)
    {
        $inputs = $request->all();
        if($allExam->create($inputs))
        {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(AllExam $allExam)
    {
        $data['terms'] = Term::all();
        $data['seasons'] = Season::all();
        return view('admin.all_exams.parts.edit', compact('data', 'allExam'));
    }

    // Edit End

    // Update Start

    public function update(Request $request, AllExam $allExam)
    {
        if ($allExam->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $onlineExam = AllExam::where('id', $request->id)->firstOrFail();
        $onlineExam->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

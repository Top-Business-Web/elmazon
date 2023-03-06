<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\SubjectClass;
use App\Models\VideoParts;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Season;
use App\Models\Term;

class OnlineExamController extends Controller
{
    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $online_exams = OnlineExam::get();
            return Datatables::of($online_exams)
                ->addColumn('action', function ($online_exams) {
                    return '
                            <button type="button" data-id="' . $online_exams->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $online_exams->id . '" data-title="' . $online_exams->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.online_exam.index');
        }
    }

    // End Index

    // Start Store

    public function create()
    {
        $seasons = Season::all();
        $terms = Term::all();
        return view('admin.online_exam.parts.create', compact('seasons', 'terms'));
    }

    // Examble Type Start

    public function examble_type(Request $request)
    {
        if ($request->ajax()) {
            $output = '<option value="" style="text-align: center">اختار</option>';
            if ($request->id == 'App\Models\Lesson') {
                $data = Lesson::get();
                foreach ($data as $value) {
                    $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                }
            } else if ($request->id == 'App\Models\Season') {
                $data = SubjectClass::where('season_id', $request->season_id)->get();
                foreach ($data as $value) {
                    $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                }
            } else if ($request->id == 'App\Models\VideoParts') {
                $data = videoParts::get();
                foreach ($data as $value) {
                    $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                }
            }

            return $output;

        }
    }

    // Examble Type End

    // Store End

    public function store(Request $request, OnlineExam $online_exam)
    {
        $inputs = $request->all();
        if($online_exam->create($inputs))
        {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    public function edit(OnlineExam $onlineExam)
    {
        $seasons = Season::all();
        $terms = Term::all();
        return view('admin.online_exam.parts.edit', compact('onlineExam', 'seasons', 'terms'));
    }

    // Update Start

    public function update(Request $request, OnlineExam $onlineExam)
    {
        if ($onlineExam->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $onlineExam = OnlineExam::where('id', $request->id)->firstOrFail();
        $onlineExam->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

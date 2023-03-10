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
use App\Models\OnlineExamQuestion;
use App\Models\Question;


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
                            <a class="btn btn-pill btn-success-light questionBtn" data-id="' . $online_exams->id . '" data-target="#question_modal" href="'. route('indexQuestion', $online_exams->id) .'"><i class="fa fa-question"></i></a>
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

    // Store End

    // Question Start

    public function indexQuestion(Request $request)
    {
        $exam = OnlineExam::find($request->id);
        $questions = Question::where('season_id',$exam->season_id )
        ->where('term_id', $exam->term_id)
        ->get();
        $online_questions_ids = OnlineExamQuestion::where(['online_exam_id'=>$request->id])->pluck('question_id')->toArray();
        return view('admin.online_exam.parts.questions', compact('questions', 'exam','online_questions_ids'));
    }

    // Question End

    // Add Question

    public function addQuestion(Request $request, OnlineExamQuestion $onlineExamQuestion)
    {
        $inputs = $request->all();
        if($onlineExamQuestion->create($inputs))
        {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // End Add Question

    // Delete Question

    public function deleteQuestion(Request $request)
    {
        $questions = OnlineExamQuestion::where(['question_id'=> $request->question_id,'online_exam_id'=>$request->online_exam_id]);
        $questions->delete();
    }

    // Delete Question

    // Examble Type Start

    public function examble_type(Request $request)
    {
        if ($request->ajax()) {
            $output = '<option value="" style="text-align: center">??????????</option>';
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
        return response()->json(['message' => '???? ?????????? ??????????', 'status' => 200], 200);
    }

    // Delete End
}

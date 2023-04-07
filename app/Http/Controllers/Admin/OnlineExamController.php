<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\OnlineExamUser;
use App\Models\SubjectClass;
use App\Models\TextExamUser;
use App\Models\VideoParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Season;
use App\Models\Term;
use App\Models\OnlineExamQuestion;
use App\Models\Question;
use App\Models\User;


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
                            <a class="btn btn-pill btn-success-light questionBtn" data-id="' . $online_exams->id . '" data-target="#question_modal" href="' . route('indexQuestion', $online_exams->id) . '"><i class="fa fa-question"></i></a>
                            <a class="btn btn-pill btn-warning-light questionBtn" data-id="' . $online_exams->id . '" data-target="#question_modal" href="' . route('usersExam', $online_exams->id) . '"><i class="fa fa-user"></i></a>
                       ';
                })
                ->editColumn('season_id', function ($online_exams) {
                    return '<td>'. $online_exams->season->name_ar .'</td>';
                })
                ->editColumn('term_id', function ($online_exams) {
                    return '<td>'. $online_exams->term->name_ar .'</td>';
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
        $questions = Question::where('season_id', $exam->season_id)
            ->where('term_id', $exam->term_id)
            ->get();
        $online_questions_ids = OnlineExamQuestion::where(['online_exam_id' => $request->id])->pluck('question_id')->toArray();
        return view('admin.online_exam.parts.questions', compact('questions', 'exam', 'online_questions_ids'));
    }

    // Question End

    // User Exam Start

    public function usersExam(Request $request)
    {
        $exam = OnlineExam::find($request->id);
        $online_exams = OnlineExamUser::where('online_exam_id', $exam->id)->select('user_id')->groupBy('user_id')->get();
        $questions = $exam->questions;
        $answers = TextExamUser::where('online_exam_id', $exam->id)
            ->whereIn('user_id', $online_exams->pluck('user_id'))
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();
//        return $questions_1;
        return view('admin.online_exam.parts.text_exam_users', compact('exam', 'online_exams'));
    }

    // User Exam End

    // Paper Exam Start

    public function paperExam(Request $request)
    {
        $user = OnlineExamUser::where('user_id', $request->id)->select('user_id')->groupBy('user_id')->get();
        $exam = OnlineExamUser::where('user_id', $request->id)->first('online_exam_id');
        $questions = OnlineExamQuestion::whereIn('online_exam_id', $exam)->get('question_id');
        $answers = TextExamUser::where('online_exam_id', $exam->online_exam_id)
            ->where('user_id', $user->pluck('user_id'))
            ->whereIn('question_id', $questions->pluck('question_id'))
            ->get();
        $question = onlineExamQuestion::where('online_exam_id', $exam->online_exam_id)->get();
//        return $answers;
        return view('admin.online_exam.parts.exam_paper', compact('answers', 'question'));
    }

    // Paper Exam End

    // Store Exam Paper Start

    public function storeExamPaper(Request $request)
    {
//        return $request;
        foreach ($request->questions as $question) {
            $text_exam_user = Degree::where('user_id', $request->user_id)
                ->where('question_id', $question['question_id'])
                ->first();

            if ($text_exam_user) {
                $text_exam_user->degree = $question['degree'];
                $text_exam_user->status = 'completed';
                $text_exam_user->save();
            }
        }
        return redirect()->back();

    }

    // Store Exam Paper End

    // Add Question

    public function addQuestion(Request $request, OnlineExamQuestion $onlineExamQuestion)
    {
        $inputs = $request->all();
        if ($onlineExamQuestion->create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // End Add Question

    public function selectTerm(Request $request)
    {
        //
    }

    // Delete Question

    public function deleteQuestion(Request $request)
    {
        $questions = OnlineExamQuestion::where(['question_id' => $request->question_id, 'online_exam_id' => $request->online_exam_id]);
        $questions->delete();
    }

    // Delete Question

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
        if ($online_exam->create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlineExamRequest;
use App\Models\Degree;
use App\Models\ExamDegreeDepends;
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
            $online_exams = OnlineExam::latest()->get();
            return DataTables::of($online_exams)
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
                    return '<td>' . $online_exams->season->name_ar . '</td>';
                })
                ->editColumn('term_id', function ($online_exams) {
                    return '<td>' . $online_exams->term->name_ar . '</td>';
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
        $users = User::whereHas('online_exams', function ($online_exam) use ($exam) {

            $online_exam->where('online_exam_id', '=', $exam->id)->groupBy('user_id');
        })->get();


        return view('admin.online_exam.parts.text_exam_users', compact('exam', 'users'));
    }

    // User Exam End

    // Paper Exam Start

    public function paperExam($user_id, $exam_id)
    {

        $exam_user = OnlineExam::findOrFail($exam_id);
        $user_exam = User::where('id', '=', $user_id)->first();
        $text_exam_users = TextExamUser::with(['question', 'user'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)
            ->get();

        $online_exam_users = OnlineExamUser::with(['question', 'user', 'answer'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)->get();

        $online_exam_count_text_questions = $exam_user->questions()->where('question_type', '=', 'text')->count();
        $text_exam_users_completed = TextExamUser::with(['question', 'user'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)->where('degree_status', '=', 'completed')->count();

        $exam_depends_for_user = ExamDegreeDepends::where('online_exam_id', $exam_id)->where('user_id', '=', $user_id)
            ->where('exam_depends', '=', 'yes')->first();

//        return $text_exam_users_completed;
        return view('admin.online_exam.parts.exam_paper',
            compact('user_exam', 'text_exam_users', 'online_exam_users', 'exam_user', 'online_exam_count_text_questions',
                'text_exam_users_completed', 'exam_depends_for_user')
        );
    }


    public function exam_depends($user_id, $exam_id)
    {

        $text_exam_user_sum_degree = TextExamUser::with(['question', 'user'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)
            ->sum('degree');

        $exam_degree_depends = ExamDegreeDepends::where('online_exam_id', $exam_id)->where('user_id', '=', $user_id)
            ->orderBy('full_degree', 'DESC')->latest()->first();

        $exam_degree_depends->update(['full_degree' => $exam_degree_depends->full_degree += $text_exam_user_sum_degree, 'exam_depends' => 'yes']);
        return response()->json(['status' => 200, 'message' => 'تم اعتماد درجه الامتحان للطالب بنجاح']);

    }

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
        $terms = Term::where('season_id', $request->season_id)->pluck('name_ar', 'id')->toArray();
        return $terms;
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
            if ($request->type == 'App\Models\Lesson') {

                $subjectClass = SubjectClass::where('season_id', $request->season)
                    ->where('term_id', $request->term)
                    ->pluck('id', 'id')->toArray();

                if ($subjectClass) {
                    $data = Lesson::whereIn('subject_class_id', $subjectClass)
                        ->pluck('name_ar', 'id')->toArray();

                }
            } else if ($request->type == 'App\Models\SubjectClass') {

                $data = SubjectClass::where('season_id', $request->season)
                    ->where('term_id', $request->term)
                    ->pluck('name_ar', 'id')->toArray();


            } else if ($request->type == 'App\Models\VideoParts') {
                $data = videoParts::pluck('name_ar', 'id')->toArray();
            }
            if (!$data) {
                return response()->json(['' => 'لايوجد بيانات']);
            } else {
                return $data;
            }
        }

    }

// Examble Type End

// Store End

    public
    function store(OnlineExamRequest $request, OnlineExam $online_exam)
    {
//        dd(file_size(asset('online_exams/pdf_answers/1.pdf')));
        $inputs = $request->all();
//        dd($request->pdf_file_upload);
        if ($request->has('pdf_file_upload')) {
            $inputs['pdf_file_upload'] = saveFile('online_exams/pdf_file_uploads', $request->pdf_file_upload);
        } // end save file

        if ($request->has('answer_pdf_file')) {
            $inputs['answer_pdf_file'] = saveFile('online_exams/pdf_answers', $request->answer_pdf_file);
        } // end save file

        if ($request->has('answer_video_file')) {
            $inputs['answer_video_file'] = saveFile('online_exams/videos_answers', $request->answer_video_file);
        } // end save file

        if ($request->examable_type == 'App\Models\Lesson') {
            $inputs['type'] = 'lesson';
            $inputs['lesson_id'] = $request->examable_id;
        } elseif ($request->examable_type == 'App\Models\class') {
            $inputs['type'] = 'class';
            $inputs['class_id'] = $request->examable_id;
        } elseif ($request->examable_type == 'App\Models\VideoParts') {
            $inputs['type'] = 'video';
            $inputs['video_id'] = $request->examable_id;
        } // end if

        if ($online_exam->create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    } // Store End

    public
    function edit(OnlineExam $onlineExam)
    {
        $seasons = Season::all();
        $terms = Term::all();
        return view('admin.online_exam.parts.edit', compact('onlineExam', 'seasons', 'terms'));
    }

// Update Start

    public
    function update(OnlineExamRequest $request, OnlineExam $onlineExam)
    {

        $inputs = $request->all();


        if ($request->has('pdf_file_upload')) {
            if (file_exists($onlineExam->pdf_file_upload)) {
                unlink($onlineExam->pdf_file_upload);
            }
            $inputs['pdf_file_upload'] = saveFile('online_exams/pdf_file_uploads', $request->pdf_file_upload);
        } // end save file

        if ($request->has('answer_pdf_file')) {
            if (file_exists($onlineExam->answer_pdf_file)) {
                unlink($onlineExam->answer_pdf_file);
            }
            $inputs['answer_pdf_file'] = saveFile('online_exams/pdf_answers', $request->answer_pdf_file);
        } // end save file

        if ($request->has('answer_video_file')) {
            if (file_exists($onlineExam->answer_pdf_file)) {
                unlink($onlineExam->answer_video_file);
            }
            $inputs['answer_video_file'] = saveFile('online_exams/videos_answers', $request->answer_video_file);
        } // end save file

        if ($request->examable_type == 'App\Models\Lesson') {
            $inputs['type'] = 'lesson';
            $inputs['lesson_id'] = $request->examable_id;
        } elseif ($request->examable_type == 'App\Models\class') {
            $inputs['type'] = 'class';
            $inputs['class_id'] = $request->examable_id;
        } elseif ($request->examable_type == 'App\Models\VideoParts') {
            $inputs['type'] = 'video';
            $inputs['video_id'] = $request->examable_id;
        } // end if


        if ($onlineExam->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

// Update End

// Destroy Start

    public
    function destroy(Request $request)
    {
        $onlineExam = OnlineExam::where('id', $request->id)->firstOrFail();
        $onlineExam->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }// Delete End


    public
    function addDegreeForTextExam(Request $request)
    {

        $text_exam_user = TextExamUser::findOrFail($request->exam_id);
        $text_exam_user->update(['degree' => $request->degree ?? 0, 'degree_status' => 'completed']);
        return response()->json(['status' => 200, 'message' => 'تم اضافه الدرجه بنجاح']);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $users = User::whereHas('online_exams', function ($online_exam) use($exam){

            $online_exam->where('online_exam_id','=',$exam->id)->groupBy('user_id');
        })->get();


        return view('admin.online_exam.parts.text_exam_users', compact('exam', 'users'));
    }

    // User Exam End

    // Paper Exam Start

    public function paperExam($user_id,$exam_id){

        $exam_user = OnlineExam::findOrFail($exam_id);
        $user_exam = User::where('id','=',$user_id)->first();
        $text_exam_users = TextExamUser::with(['question','user'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)
            ->get();

        $online_exam_users = OnlineExamUser::with(['question','user','answer'])->where('online_exam_id',$exam_id)
            ->where('user_id', $user_id)->get();

        $online_exam_count_text_questions = $exam_user->questions()->where('question_type','=','text')->count();
        $text_exam_users_completed = TextExamUser::with(['question','user'])->where('online_exam_id', $exam_id)
            ->where('user_id', $user_id)->where('degree_status','=','completed')->count();

        $exam_depends_for_user = ExamDegreeDepends::where('online_exam_id',$exam_id)->where('user_id','=',$user_id)
            ->where('exam_depends','=','yes')->first();

//        return $text_exam_users_completed;
        return view('admin.online_exam.parts.exam_paper',
            compact('user_exam','text_exam_users', 'online_exam_users','exam_user','online_exam_count_text_questions',
            'text_exam_users_completed','exam_depends_for_user')
        );
    }


     public function exam_depends($user_id,$exam_id){

         $text_exam_user_sum_degree = TextExamUser::with(['question','user'])->where('online_exam_id', $exam_id)
             ->where('user_id', $user_id)
             ->sum('degree');

         $exam_degree_depends = ExamDegreeDepends::where('online_exam_id',$exam_id)->where('user_id','=',$user_id)
             ->orderBy('full_degree','DESC')->latest()->first();

         $exam_degree_depends->update(['full_degree' =>  $exam_degree_depends->full_degree+=$text_exam_user_sum_degree,'exam_depends' => 'yes']);
         return response()->json(['status' => 200,'message' => 'تم اعتماد درجه الامتحان للطالب بنجاح']);

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
        $terms = Term::where('season_id',$request->season_id)->pluck('name_ar','id')->toArray();

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
                        ->pluck('name_ar','id')->toArray();
                } else if ($request->id == 'App\Models\Season') {
                    $data = SubjectClass::where('season_id', $request->season_id)
                        ->where('term_id', $request->term)
                        ->pluck('name_ar','id')->toArray();
                } else if ($request->id == 'App\Models\VideoParts') {
                    $data = videoParts::get();
                }

                return $output;

            }
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

    public function destroy(Request $request){
        $onlineExam = OnlineExam::where('id', $request->id)->firstOrFail();
        $onlineExam->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }// Delete End



    public function addDegreeForTextExam(Request $request){

      $text_exam_user = TextExamUser::findOrFail($request->exam_id);
      $text_exam_user->update(['degree' => $request->degree ?? 0,'degree_status' => 'completed']);
      return response()->json(['status' => 200,'message' => 'تم اضافه الدرجه بنجاح']);
    }

}

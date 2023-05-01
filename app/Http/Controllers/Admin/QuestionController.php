<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestQuestion;
use App\Imports\QuestionImport;
use App\Models\AllExam;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\LifeExam;
use App\Models\Question;
use App\Models\SubjectClass;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Term;
use App\Models\VideoParts;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    use PhotoTrait;

    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $questions = Question::select('*');
            return Datatables::of($questions)
                ->addColumn('action', function ($questions) {
                    return '
                            <button type="button" data-id="' . $questions->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $questions->id . '" data-title="' . $questions->question . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" data-id="' . $questions->id . '" class="btn btn-pill btn-success-light editBtnAnswer">الاجابة</button>
                       ';
                })
                ->editColumn('type', function ($questions) {
                    if ($questions->type == 'video')
                        return 'فيديو';
                    else if ($questions->type == 'lesson')
                        return 'درس';
                    else if ($questions->type == 'all_exam')
                        return 'امتحان شامل';
                    else if ($questions->type == 'subject_class')
                        return 'وحده';
                    else if ($questions->type == 'life_exam')
                        return 'امتحان لايف';

                })
                ->editColumn('question', function ($questions) {
                    return \Str::limit($questions->question, 50);
                })
                ->editColumn('season_id', function ($questions) {
                    return $questions->season->name_ar;
                })
                ->editColumn('term_id', function ($questions) {
                    return $questions->term->name_ar;
                })
                ->editColumn('difficulty', function ($questions) {
                    if ($questions->difficulty == 'low')
                        return '<span class="badge badge-success">سـهل</span>';
                    else if ($questions->difficulty =='mid')
                        return '<span class="badge badge-info">متوسـط</span>';
                    else
                        return '<span class="badge badge-danger">صـعب</span>';
                })
                ->filter(function ($questions) use ($request) {
                    if ($request->get('type')) {
                        $questions->where('season_id', $request->get('type'))->get();
                    }
                })
                ->rawColumns([])
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.questions.index');
        }
    }
    // Index End

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

            } else if ($request->type == 'App\Models\AllExam') {
                $data = AllExam::where('season_id', $request->season)
                    ->where('term_id', $request->term)
                    ->pluck('name_ar', 'id')->toArray();
            } else if ($request->type == 'App\Models\LifeExam') {
                $data = LifeExam::where('season_id', $request->season)
                    ->where('term_id', $request->term)
                    ->pluck('name_ar', 'id')->toArray();
            }
            if (!$data) {
                return response()->json(['' => 'لايوجد بيانات']);
            } else {
                return $data;
            }
        }

    }

    // Examble Type End

    // Create Start

    public function create()
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.questions.parts.create', compact('seasons', 'terms'));
    }

    // Create End

    // Store Start

    public function store(Request $request, Question $question)
    {
        $inputs = $request->all();

        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/questions', 'photo');
            $inputs['question'] = null;
            $inputs['file_type'] = 'image';
            $inputs['question_type'] = 'choice';
        } else {
            $inputs['question_type'] = 'text';
            $inputs['file_type'] = 'text';
        }

        if ($request->examable_type == 'App\Models\Lesson') {
            $inputs['type'] = 'lesson';
        } elseif ($request->examable_type == 'App\Models\SubjectClass') {
            $inputs['type'] = 'subject_class';
        } elseif ($request->examable_type == 'App\Models\VideoParts') {
            $inputs['type'] = 'video';
        } elseif ($request->examable_type == 'App\Models\AllExam') {
            $inputs['type'] = 'all_exam';
        } elseif ($request->examable_type == 'App\Models\LifeExam') {
            $inputs['type'] = 'life_exam';
        }


        if ($question->create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

// Store End

// Show Start

    public
    function answer($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.parts.answers', compact('question'));
    }

// Show End

// Add Answer Start

    public
    function addAnswer(Request $request)
    {
        $answers = $request->answer;

        foreach ($answers as $key => $value) {
            Answer::create([
                'answer' => $value,
                'question_id' => $request->question_id,
                'answer_status' => ($request->answer_status == $key) ? 'correct' : 'un_correct',
                'answer_number' => $key
            ]);

        }

        return response()->json(['status' => 200]);

    }

// Add Answer End

// Edit Start

    public
    function edit(Question $question)
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.questions.parts.edit', compact('question', 'seasons', 'terms'));
    }

// Edit End

// Update Start

    public
    function update(Request $request, Question $question)
    {

        $inputs = $request->all();

        if ($request->has('image')) {
            if (file_exists($question->image)) {
                unlink($question->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/question', 'photo');
            $inputs['question'] = null;
            $inputs['file_type'] = 'image';
            $inputs['question_type'] = 'choice';
        } else {
            $inputs['question_type'] = 'text';
            $inputs['file_type'] = 'text';
        }

        if ($request->examable_type == 'App\Models\Lesson') {
            $inputs['type'] = 'lesson';
        } elseif ($request->examable_type == 'App\Models\SubjectClass') {
            $inputs['type'] = 'subject_class';
        } elseif ($request->examable_type == 'App\Models\VideoParts') {
            $inputs['type'] = 'video';
        } elseif ($request->examable_type == 'App\Models\AllExam') {
            $inputs['type'] = 'all_exam';
        } elseif ($request->examable_type == 'App\Models\LifeExam') {
            $inputs['type'] = 'life_exam';
        }


        if ($question->update($inputs)) {
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
        $questions = Question::where('id', $request->id)->firstOrFail();
        $questions->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

// Delete End

    public function questionExport()
    {
        return Excel::download(new QuestionExport, 'question.xlsx');
    }

    public function questionImport(Request $request)
    {
        Excel::import(new QuestionImport,$request->exelFile);
        return response()->json(['status' => 200]);
    }

}

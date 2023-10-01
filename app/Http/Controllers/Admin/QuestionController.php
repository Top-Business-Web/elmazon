<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Season;
use App\Models\AllExam;
use App\Models\LifeExam;
use App\Models\Question;
use App\Traits\AdminLogs;
use App\Models\VideoParts;
use App\Traits\PhotoTrait;
use App\Models\SubjectClass;
use Illuminate\Http\Request;
use App\Exports\QuestionExport;
use App\Imports\QuestionImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;

class QuestionController extends Controller
{
    use PhotoTrait, AdminLogs;


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
                            <button type="button" '.($questions->question_type == 'text' ? 'hidden' : '').' data-id="' . $questions->id . '" class="btn btn-pill btn-success-light editBtnAnswer">الاجابة</button>
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
                    else if ($questions->difficulty == 'mid')
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




    public function create()
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.questions.parts.create', compact('seasons', 'terms'));
    }


    public function store(QuestionStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets/uploads/questions', 'public');

            $inputs['image'] = $imagePath;
            $inputs['question'] = null;
            $inputs['file_type'] = 'image';
        }

        $question = Question::create($inputs);

        if ($question->save()) {
            $this->adminLog('تم اضافة سؤال جديد');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }

    }

    public function answer($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.parts.answers', compact('question'));
    }



    public function addAnswer(Request $request): \Illuminate\Http\JsonResponse
    {
        if (count($request->answer) !== 4) {
            return response()->json(['status' => 407]);
        }
        $alphabeticIndexes = ['E', 'A', 'B', 'C', 'D'];
        DB::beginTransaction();

        try {
            Answer::where('question_id', $request->question_id)->delete();
            foreach ($request->answer as $key => $value) {
                Answer::create([
                    'answer' => $value,
                    'question_id' => $request->question_id,
                    'answer_status' => ($request->answer_status == $key) ? 'correct' : 'un_correct',
                    'answer_number' => $alphabeticIndexes[$key]
                ]);
            }
            DB::commit();

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 500, 'error' => 'Internal Server Error']);
        }
    }



    public function edit(Question $question)
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.questions.parts.edit', compact('question', 'seasons', 'terms'));
    }


    public function update(QuestionUpdateRequest $request, Question $question): \Illuminate\Http\JsonResponse
    {

        $inputs = $request->all();

        if ($request->has('image')) {
            if (file_exists($question->image)) {
                unlink($question->image);
            }
            $imagePath = $request->file('image')->store('assets/uploads/questions', 'public');
            $inputs['image'] = $imagePath;
            $inputs['question'] = null;
            $inputs['file_type'] = 'image';
        }


        if ($question->update($inputs)) {
            $this->adminLog('تم تحديث سؤال ');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function destroy(Request $request)
    {
        $questions = Question::where('id', $request->id)->firstOrFail();
        $questions->delete();
        $this->adminLog('تم حذف سؤال');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }


    public function questionExport(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new QuestionExport, 'question.xlsx');
    }

    public function questionImport(Request $request): \Illuminate\Http\JsonResponse
    {
        $import = Excel::import(new QuestionImport, $request->exelFile);
        if ($import) {
            $this->adminLog('تم استيراد سؤال');
            return response()->json(['status' => 200]);
        } else
            return response()->json(['status' => 500]);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestQuestion;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\SubjectClass;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Term;
use App\Models\VideoParts;
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
                ->addColumn('approved', function($row){
                    if($row->approved){
                        return '<span class="badge badge-primary">Yes</span>';
                    }else{
                        return '<span class="badge badge-danger">No</span>';
                    }
                })
                ->filter(function ($questions) use ($request) {
                    if ($request->get('type')) {
                        $questions->where('season_id', $request->get('type'))->get();
                    }
                })
                ->rawColumns(['approved'])
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
            $output = '<option value="" style="text-align: center">اختار</option>';
            if ($request->id == 'App\Models\Lesson') {
                $data = Lesson::get();
                foreach ($data as $value) {
                    if ($value->subject_class->term->status == 'active') {
                        $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 'App\Models\SubjectClass') {
                $data = SubjectClass::where('id', $request->season_id)->get();
//                dd($data);
                foreach ($data as $value) {
                    if ($value->term->status == 'activate') {
                        $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 'App\Models\VideoParts') {
                $data = videoParts::get();
                foreach ($data as $value) {
                    if ($value->term->status == 'activate') {
                        $output .= '<option value="' . $value->id . '" style="text-align: center">' . $value->name_ar . '</option>';
                    }
                }
            }

            return $output;

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

        if ($question->create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Show Start

    public function answer($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.parts.answers', compact('question'));
    }

    // Show End

    // Add Answer Start

    public function addAnswer(Request $request)
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

    public function edit(Question $question)
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.questions.parts.edit', compact('question', 'seasons', 'terms'));
    }

    // Edit End

    // Update Start

    public function update(Request $request, Question $question)
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

        if ($question->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $questions = Question::where('id', $request->id)->firstOrFail();
        $questions->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End

}

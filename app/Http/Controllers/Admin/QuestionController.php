<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestQuestion;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\SubjectClass;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Term;
use App\Models\VideoParts;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $questions = Question::get();
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

        foreach ($answers as $key=>$value) {
            Answer::create([
                'answer' => $value,
                'question_id' => $request->question_id,
                'answer_status' => ($request->answer_status == $key) ?'correct':'un_correct',
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
        if ($question->update($request->all())) {
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

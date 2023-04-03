<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\Traits\FirebaseNotification;
use App\Http\Controllers\Controller;
use App\Models\OnlineExam;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use App\Models\PapelSheetExamUser;
use App\Models\Season;
use App\Models\Term;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PapelSheetExamController extends Controller
{
    // Index START

    use FirebaseNotification;
    public function index(request $request)
    {
        if ($request->ajax()) {
            $sheet_exams = PapelSheetExam::get();
            return Datatables::of($sheet_exams)
                ->addColumn('action', function ($sheet_exams) {
                    return '
                            <button type="button" data-id="' . $sheet_exams->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $sheet_exams->id . '" data-title="' . $sheet_exams->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <a class="btn btn-pill btn-warning-light questionBtn" data-id="' . $sheet_exams->id . '" data-target="#question_modal" href="' . route('usersExamPapel', $sheet_exams->id) . '"><i class="fa fa-user"></i></a>
                       ';
                })
                ->editColumn('season_id', function ($sheet_exams) {
                    return '<td>'. $sheet_exams->season->name_ar .'</td>';
                })
                ->editColumn('term_id', function ($sheet_exams) {
                    return '<td>'. $sheet_exams->term->name_ar .'</td>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.papel_sheet_exams.index');
        }
    }

    // End Index

    // User Exam Start

    public function usersExamPapel(Request $request)
    {
        $papelExams = PapelSheetExam::find($request->id);
        $papel_exam_users = PapelSheetExamUser::where('papel_sheet_exam_id', $papelExams->id)->select('user_id')->groupBy('user_id')->get();
        $answers = PapelSheetExamUser::where('papel_sheet_exam_id', $papelExams->id)
            ->whereIn('user_id', $papel_exam_users->pluck('user_id'))
            ->get();
//        return $answers;
        return view('admin.papel_sheet_exams.parts.text_exam_users', compact('papelExams', 'papel_exam_users'));
    }

    // User Exam End

    // Paper Exam Start

    public function paperExamSheet(Request $request)
    {
        $user = PapelSheetExamUser::where('user_id', $request->id)->select('user_id')->groupBy('user_id')->get();
        $exam = PapelSheetExamUser::where('user_id', $request->id)->first('papel_sheet_exam_id');
        $answers = PapelSheetExamUser::where('papel_sheet_exam_id', $exam->papel_sheet_exam_id)
            ->where('user_id', $user->pluck('user_id'))
            ->get();
//        return $answers;
        return view('admin.papel_sheet_exams.parts.exam_paper_sheets', compact('answers'));
    }

    // Paper Exam End

    // Paper Exam Start

    public function paperExamSheetStore(Request $request, PapelSheetExamDegree $papel_sheet_exam_degree)
    {
        $inputs = $request->all();
        if($papel_sheet_exam_degree->create($inputs)) {
            toastr('تم الاضافة بنجاح');
            return redirect('paperExamSheet');
        }
        else{
            toastr('هناك خطأ ما');
        }
    }

    // Paper Exam End

    // Start Create

    public function create()
    {
        $data['seasons'] = Season::all();
        $data['terms'] = Term::all();
        return view('admin.papel_sheet_exams.parts.create', $data);
    }

    // Create End


    // Store Start

    public function store(Request $request, PapelSheetExam $papelSheetExam)
    {
        $inputs = $request->all();
        if ($papelSheetExam->create($inputs)) {

            $this->sendFirebaseNotification(['title' => 'اشعار جديد', 'body' => $request->name_ar, 'term_id' => $request->term_id],$request->season_id);
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start
    public function edit(PapelSheetExam $papelSheetExam)
    {
        $data['seasons'] = Season::all();
        $data['terms'] = Term::all();
        return view('admin.papel_sheet_exams.parts.edit', compact('data', 'papelSheetExam'));
    }

    // Edit End

    // Update Start

    public function update(Request $request, PapelSheetExam $papelSheetExam)
    {
        if ($papelSheetExam->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $papelSheetExam = PapelSheetExam::where('id', $request->id)->firstOrFail();
        $papelSheetExam->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

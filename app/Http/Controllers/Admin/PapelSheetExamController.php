<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineExam;
use App\Models\PapelSheetExam;
use App\Models\Season;
use App\Models\Term;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PapelSheetExamController extends Controller
{
    // Index START

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

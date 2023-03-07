<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Section;
use App\Http\Requests\RequestSection;

class SectionController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $sections = Section::get();
            return Datatables::of($sections)
                ->addColumn('action', function ($sections) {
                    return '
                            <button type="button" data-id="' . $sections->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $sections->id . '" data-title="' . $sections->section_name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.sections.index');
        }
    }
    // Index End

    // Create Start

    public function create()
    {
        return view('admin.sections.parts.create');
    }

    // Create End

    // Store Start

    public function store(RequestSection $request)
    {
        $inputs = $request->all();
        if (Section::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(Section $section)
    {
        return view('admin.sections.parts.edit', compact('section'));
    }

    // Edit End

    // Update Start

    public function update(Request $request, Section $section)
    {
        if ($section->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Delete Start

    public function destroy(Request $request)
    {
        $sections = Section::where('id', $request->id)->firstOrFail();
        $sections->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete End
}

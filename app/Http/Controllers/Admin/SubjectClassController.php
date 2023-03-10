<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectClasses;
use App\Models\SubjectClass;
use App\Models\Term;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Season;

class SubjectClassController extends Controller
{
    use PhotoTrait;

    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $subjects_classes = SubjectClass::get();
            return Datatables::of($subjects_classes)
                ->addColumn('action', function ($subjects_classes) {
                    return '
                            <button type="button" data-id="' . $subjects_classes->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $subjects_classes->id . '" data-title="' . $subjects_classes->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($subjects_classes) {
                    return '<img style="width:60px;border-radius:30px" onclick="window.open(this.src)" src="' . asset($subjects_classes->image) . '"/>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.subject_classes.index');
        }
    }

    // Index End

    // Create Start

    public function create()
    {
        $terms = Term::get();
        $seasons = Season::get();
        return view('admin.subject_classes.parts.create', compact('terms', 'seasons'));
    }

    // Create End

    // Store Start

    public function store(StoreSubjectClasses $request)
    {
        $inputs = $request->all();

        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/subject_class', 'photo');
        }

        if (SubjectClass::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(SubjectClass $subjectsClass)
    {
        $seasons = Season::get();
        $terms = Term::get();
        return view('admin.subject_classes.parts.edit', compact('subjectsClass', 'terms', 'seasons'));
    }

    // Edit End

    // Update Start

    public function update(SubjectClass $subjectsClass, StoreSubjectClasses $request)
    {
        $inputs = $request->all();

        if ($request->has('image')) {
            if (file_exists($subjectsClass->image)) {
                unlink($subjectsClass->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/subject_class', 'photo');
        }
        if ($subjectsClass->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $subject_class = SubjectClass::where('id', $request->id)->firstOrFail();
        $subject_class->delete();
        return response()->json(['message' => '???? ?????????? ??????????', 'status' => 200], 200);
    }

    // Destroy End
}

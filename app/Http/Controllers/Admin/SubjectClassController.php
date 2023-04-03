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
        $terms = Term::all();
        $seasons = Season::all();
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
                ->editColumn('term_id', function ($subjects_classes) {
                    return '<td>' . $subjects_classes->term->name_ar . '</td>';
                })
                ->editColumn('season_id', function ($subjects_classes) {
                    return '<td>' . $subjects_classes->season->name_ar . '</td>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.subject_classes.index', compact('terms', 'seasons'));
        }
    }

    // Index End

    // Examble Type Start

    public function seasonTerm(Request $request)
    {
        if ($request->ajax()) {
            $output = '<option value="" style="text-align: center">اختار</option>';
            if ($request->id == 1) {
                $firstLevels = Term::where('season_id', $request->id)->get();
                foreach ($firstLevels as $firstLevel) {
                    if ($firstLevel->status == 'active') {
                        $output .= '<option value="' . $firstLevel->id . '" style="text-align: center">' . $firstLevel->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 2) {
                $secondLevels = Term::where('season_id', $request->id)->get();
                foreach ($secondLevels as $secondLevel) {
                    if ($secondLevel->status == 'active') {
                        $output .= '<option value="' . $secondLevel->id . '" style="text-align: center">' . $secondLevel->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 3) {
                $therdLevels = Term::where('season_id', $request->id)->get();
                foreach ($therdLevels as $therdLevel) {
                    if ($therdLevel->status == 'active') {
                        $output .= '<option value="' . $therdLevel->id . '" style="text-align: center">' . $therdLevel->name_ar . '</option>';
                    }
                }
            }

            return $output;

        }
    }

    // Examble Type End

    // Filter Start

    public function filterSubject(Request $request)
    {
        $termId = $request->input('term_id');
        $seasonId = $request->input('season_id');

        $subjectClasses = SubjectClass::query()
            ->when($termId, function ($query, $termId) {
                return $query->where('term_id', $termId);
            })
            ->when($seasonId, function ($query, $seasonId) {
                return $query->where('season_id', $seasonId);
            })
            ->get();

        return DataTables::of($subjectClasses)
            ->addColumn('action', function ($subjectClasses) {
                return '
                            <button type="button" data-id="' . $subjectClasses->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $subjectClasses->id . '" data-title="' . $subjectClasses->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
            })
            ->editColumn('image', function ($subjectClasses) {
                return '<img style="width:60px;border-radius:30px" onclick="window.open(this.src)" src="' . asset($subjectClasses->image) . '"/>';
            })
            ->editColumn('term_id', function ($subjectClasses) {
                return '<td>' . $subjectClasses->term->name_ar . '</td>';
            })
            ->editColumn('season_id', function ($subjectClasses) {
                return '<td>' . $subjectClasses->season->name_ar . '</td>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    // Filter End


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
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLesson;
use App\Models\lesson;
use App\Models\SubjectClass;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Season;

class LessonController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $lessons = lesson::get();
            return Datatables::of($lessons)
                ->addColumn('action', function ($lessons) {
                    return '
                            <button type="button" data-id="' . $lessons->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $lessons->id . '" data-title="' . $lessons->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.lessons.index');
    }
    // Index End

    // Create Start

    public function create()
    {
        $seasons = Season::get();
        $subjects_classes = SubjectClass::get();
        return view('admin.lessons.parts.create', compact('subjects_classes', 'seasons'));
    }
    // Create End

    // Show Unit 

    public function showUnit(Request $request)
    {
        if ($request->ajax()) {
            $output = '<option value="" style="text-align: center">اختار</option>';
            if ($request->id == 1) {
                $first_levels = SubjectClass::where('season_id', $request->id)->get();
                foreach ($first_levels as $first_level) {
                    if ($first_level->term->status == 'active') {
                        $output .= '<option value="' . $first_level->id . '" style="text-align: center">' . $first_level->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 2) {
                $second_levels = SubjectClass::where('season_id', $request->id)->get();
                foreach ($second_levels as $second_level) {
                    if ($second_level->term->status == 'active') {
                        $output .= '<option value="' . $second_level->id . '" style="text-align: center">' . $second_level->name_ar . '</option>';
                    }
                }
            } else if ($request->id == 3) {
                $third_levels = SubjectClass::where('season_id', $request->id)->get();
                foreach ($third_levels as $third_level) {
                    if ($third_level->term->status == 'active') {
                        $output .= '<option value="' . $third_level->id . '" style="text-align: center">' . $third_level->name_ar . '</option>';
                    }
                }
            }

            return $output;
        }
    }

    // Show Unit

    // Store Start

    public function store(StoreLesson $request)
    {
        $inputs = $request->all();
        if (Lesson::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store Start



    // Edit Start

    public function edit(Lesson $lesson)
    {
        $seasons = Season::get();
        $subjects_classes = SubjectClass::get();
        return view('admin.lessons.parts.edit', compact('lesson', 'subjects_classes', 'seasons'));
    }

    // Edit End

    // Update Start

    public function update(Lesson $lesson, StoreLesson $request)
    {
        if ($lesson->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $lessons = Lesson::where('id', $request->id)->firstOrFail();
        $lessons->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

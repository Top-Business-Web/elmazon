<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestGuide;
use App\Models\Guide;
use App\Models\Lesson;
use App\Models\SubjectClass;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Subject;
use Yajra\DataTables\DataTables;
use App\Models\Term;
use App\Models\Season;

class GuideController extends Controller
{

    use PhotoTrait;

    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $guides = Guide::where('from_id', '=', null);
            return Datatables::of($guides)
                ->addColumn('action', function ($guides) {
                    return '
                            <button type="button" data-id="' . $guides->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $guides->id . '" data-title="' . $guides->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <a href="' . route('indexItem', $guides->id) . '" class="btn btn-pill btn-success-light addItem">اضافة عنصر</a>
                       ';
                })
                ->editColumn('background_color', function ($guides) {
                    return '<input type="color" class="form-control" name="color"
                           value="'. $guides->color .'" disabled>';
                })
                ->editColumn('term_id', function ($guides) {
                    return '<td>' . $guides->term->name_ar . '</td>';
                })
                ->editColumn('season_id', function ($guides) {
                    return '<td>' . $guides->season->name_ar . '</td>';
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.guides.index');
    }
    // Index End

    // Create Start

    public function create()
    {
        $terms = Term::all();
        $seasons = Season::all();
        return view('admin.guides.parts.create', compact('terms', 'seasons'));
    }

    // Create End

    // Subject Class Sort Start

    public function subjectSort(Request $request)
    {

        $terms = $request->id;
        $subjects = SubjectClass::where('term_id', $terms)->get();

        $output = '<option value="" style="text-align: center">اختر الوحدة</option>';

        foreach ($subjects as $subject) {
            $output .= '<option value="' . $subject->id . '" style="text-align: center">' . $subject->name_ar . ' </option>';
        }
        if ($subjects->count() > 0) {
            return $output;
        } else {
            return '<option value="" style="text-align: center">لا يوجد وحدات</option>';
        }

    }

    // Subject Class Sort End

    // Subject Class Sort Start

    public function lessonSort(Request $request)
    {

        $subject = $request->id;
        $lessons = Lesson::where('subject_class_id', $subject)->get();

        $output = '<option value="" style="text-align: center">اختر الوحدة</option>';

        foreach ($lessons as $lesson) {
            $output .= '<option value="' . $lesson->id . '" style="text-align: center">' . $lesson->name_ar . ' </option>';
        }
        if ($lessons->count() > 0) {
            return $output;
        } else {
            return '<option value="" style="text-align: center">لا يوجد وحدات</option>';
        }

    }

    // Subject Class Sort End

    // Store Start

    public function store(Request $request)
    {
        $inputs = $request->all();

        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'photo');
        }

        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/icon', 'photo');
        }

        if (Guide::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store Start

    //Edit start

    public function edit(Guide $guide)
    {
        $seasons = Season::all();
        return view('admin.guides.parts.edit', compact('guide', 'seasons'));
    }

    // Edit end

    // Update start

    public function update(Guide $guide, RequestGuide $request)
    {
        $inputs = $request->all();

        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'photo');
        }

        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/icon', 'photo');
        }

        if ($guide->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update end

    // Destroy Start


    public function destroy(Request $request)
    {
        $guide = Guide::where('id', $request->id)->firstOrFail();
        $guide->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    //  Destroy End

    // IndexItem Start
    public function indexItem(Request $request, $id)
    {
        if ($request->ajax()) {
            $items = Guide::where('from_id', $id)->get();
            return Datatables::of($items)
                ->addColumn('action', function ($items) {
                    return '
                    <button type="button" data-id="' . $items->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $items->id . '" data-title="' . $items->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('subject_class_id', function ($items) {
                    return '<td>' . @$items->subjectClass->title_ar . '</td>';
                })
                ->editColumn('lesson_id', function ($items) {
                    return '<td>' . @$items->lesson->title_ar . '</td>';
                })
                ->editColumn('file', function ($items) {
                    if ($items->file)
                        return '<a href="' . asset('assets/uploads/guides/answers/'.$items->file) . '">
                                لينك ملف المراجعة
                            </a>';
                })
                ->editColumn('answer_video_file', function ($items) {
                    if ($items->answer_video_file)
                        return '<a href="' . asset('assets/uploads/guides/answers/'.$items->answer_video_file) . '">
                                لينك الفيديو
                            </a>';
                })
                ->editColumn('answer_pdf_file', function ($items) {
                    if ($items->answer_pdf_file)
                        return '<a href="' . asset('assets/uploads/guides/answers/'.$items->answer_pdf_file) . '">
                                لينك الملف الورقي
                            </a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.guides.parts.item', compact('id'));
        }
    }
    // IndexItem End

    // Create Item Start

    public function addItem($id)
    {
        $subjects = SubjectClass::all();
        return view('admin.guides.parts.add-item', compact('subjects', 'id'));
    }

    // Create Item End


    // StoreItem Start

    public function addItems(Request $request)
    {
        $inputs = $request->all();

        if ($request->has('file')) {
            $file = $request->file;
            $path = public_path('assets/uploads/guide/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['file'] = $file_name;
        }

        if ($request->has('answer_pdf_file')) {
            $inputs['file_type'] = 'pdf';
            $file = $request->answer_pdf_file;
            $path = public_path('assets/uploads/guide/answers');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['answer_pdf_file'] = $file_name;
        }
        if ($request->has('answer_video_file')) {
            $inputs['file_type'] = 'video';
            $file = $request->answer_video_file;
            $path = public_path('assets/uploads/guide/answers');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['answer_video_file'] = $file_name;
        }


        if ($request->has('icon')) {
            $file = $request->icon;
            $path = public_path('assets/uploads/icon/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['icon'] = $file_name;
        }

        if (Guide::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // StoereItem End

    // Edit Item Start

    public function editItem($id)
    {
        $guide = Guide::find($id);
        $subjects = SubjectClass::all();
        return view('admin.guides.parts.update-item', compact('subjects', 'guide'));
    }

    // Edit Item End

    // UpdateItem Start

    public function updateItem(Request $request, $id)
    {
        $items = Guide::find($id);
        $inputs = $request->all();

        if ($request->has('file')) {
            $file = $request->file;
            $path = public_path('assets/uploads/guide/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['file'] = $file_name;
        }

        if ($request->has('answer_pdf_file')) {
            $file = $request->answer_pdf_file;
            $path = public_path('assets/uploads/guide/answers');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['answer_pdf_file'] = $file_name;
        }
        if ($request->has('answer_video_file')) {
            $file = $request->answer_video_file;
            $path = public_path('assets/uploads/guide/answers');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['answer_video_file'] = $file_name;
        }


        if ($request->has('icon')) {
            $file = $request->icon;
            $path = public_path('assets/uploads/icon/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['icon'] = $file_name;
        }

        if ($items->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // UpdatedItem End

}

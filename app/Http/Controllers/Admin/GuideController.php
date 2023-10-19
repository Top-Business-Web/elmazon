<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Models\Guide;
use App\Models\Lesson;
use App\Models\Season;
use App\Traits\AdminLogs;
use App\Traits\PhotoTrait;
use App\Models\SubjectClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Tymon\JWTAuth\Claims\Subject;
use App\Http\Requests\RequestGuide;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuideStoreRequest;
use App\Http\Requests\GuideUpdateRequest;
use App\Http\Requests\AddItemStoreRequest;

class GuideController extends Controller
{

    use PhotoTrait , AdminLogs;

    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $guides = Guide::where('from_id', '=', null);
            return Datatables::of($guides)
                ->addColumn('action', function ($guides) {
                    return '
                            <button type="button" data-id="' . $guides->id . '" class="btn btn-pill btn-info-light editBtn">تعديل</button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $guides->id . '" data-title="' . $guides->title_ar . '">
                                   حذف
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


    public function create()
    {
        $terms = Term::all();
        $seasons = Season::all();
        return view('admin.guides.parts.create', compact('terms', 'seasons'));
    }



    public function subjectSort(Request $request): string
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



    public function lessonSort(Request $request): string
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



    public function store(GuideStoreRequest $request): JsonResponse
    {
        $inputs = $request->all();

        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'photo');
        }

        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/icon', 'photo');
        }

        if (Guide::create($inputs)) {
            $this->adminLog('تم اضافة مصادر ومراجع');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function edit(Guide $guide)
    {
        $seasons = Season::all();
        return view('admin.guides.parts.edit', compact('guide', 'seasons'));
    }


    //update guide ELee
    public function update(Guide $guide, GuideUpdateRequest $request): JsonResponse
    {
        $inputs = $request->all();

        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'photo');
        }

        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/icon', 'photo');
        }

        if ($guide->update($inputs)) {
            $this->adminLog('تم تحديث مصادر ومراجع');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }



    public function destroy(Request $request): JsonResponse
    {
        $guide = Guide::where('id', $request->id)->firstOrFail();
        $guide->delete();
        $this->adminLog('تم حذف مصادر ومراجع');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }


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


    public function addItem($id)
    {
        $subjects = SubjectClass::all();
        return view('admin.guides.parts.add-item', compact('subjects', 'id'));
    }



    public function addItems(AddItemStoreRequest $request): JsonResponse
    {
        $inputs = $request->all();
        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'photo');
        }

        if($request->hasFile('answer_pdf_file')){
            $inputs['answer_pdf_file'] = $this->saveImage($request->answer_pdf_file, 'assets/uploads/guides/answers', 'answer_pdf_file');
        }

        if($request->hasFile('answer_video_file')){
            $inputs['answer_video_file'] = $this->saveImage($request->answer_video_file, 'assets/uploads/guides/answers', 'answer_video_file');
        }
        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/file', 'icon');
        }


        if (Guide::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function editItem($id)
    {
        $guide = Guide::find($id);
        $subjects = SubjectClass::all();
        return view('admin.guides.parts.update-item', compact('subjects', 'guide'));
    }



    public function updateItem(Request $request, $id): JsonResponse
    {
        $items = Guide::find($id);
        $inputs = $request->all();

        if($request->hasFile('file')){
            $inputs['file'] = $this->saveImage($request->file, 'assets/uploads/guides/file', 'file');
        }

        if($request->hasFile('answer_pdf_file')){
            $inputs['answer_pdf_file'] = $this->saveImage($request->answer_pdf_file, 'assets/uploads/guides/answers', 'file');
        }

        if($request->hasFile('answer_video_file')){
            $inputs['answer_video_file'] = $this->saveImage($request->answer_video_file, 'assets/uploads/guides/answers', 'file');
        }
        if($request->hasFile('icon')){
            $inputs['icon'] = $this->saveImage($request->icon, 'assets/uploads/guides/file', 'file');
        }


        if ($items->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }



}

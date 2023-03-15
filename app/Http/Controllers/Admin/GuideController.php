<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestGuide;
use App\Models\Guide;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
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

    // Store Start

    public function store(RequestGuide $request)
    {
        $inputs = $request->all();

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
        return view('admin.guides.parts.edit', compact('guide'));
    }

    // Edit end

    // Update start

    public function update(Guide $guide, RequestGuide $request)
    {
        $inputs = $request->all();

        if ($guide->update($inputs)) {
            return response()->json(['status' => 200]);
        }
        else {
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
    public function indexItem($id)
    {
        $guide = Guide::where('from_id', $id)->get();
        return view('admin.guides.parts.item', compact('guide', 'id'));
    }
    // IndexItem End


    // StoreItem Start

    public function addItem(Request $request)
    {
        $inputs = $request->all();

        if($request->has('file')){
            $file = $request->file;
            $path = public_path('assets/uploads/guide/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['file']=$file_name;
        }

        if($request->has('icon')){
            $file = $request->icon;
            $path = public_path('assets/uploads/icon/');
            $file_name = $file->getClientOriginalName();
            $file->move($path, $file_name);
            $inputs['icon']=$file_name;
        }

        $guide = Guide::create($inputs);
        if($guide->save()) {
            toastr('تم الاضافة بنجاح');
            return redirect()->back();
        }
        else {
            toastr('حصل خطأ ما');
            return redirect()->back();
        }
    }

    // StoereItem End

    // UpdateItem Start

    public function updateItem(Request $request, $id)
    {
        $items = Guide::find($id);
        $inputs = $request->all();

        if($items->update($inputs)) {
            toastr('تم التعديل بنجاح');
            return redirect()->back();
        }
        else {
            toastr('حصل خطأ ما');
            return redirect()->back();
        }
    }

    // UpdatedItem End

    // DestroyItem Start

    public function destroyItem($id)
    {
        $guide = Guide::find($id);
        $guide->delete();
        toastr('تم الحذف بنجاح');
        return redirect()->back();
    }

    // DeleteItem End

}

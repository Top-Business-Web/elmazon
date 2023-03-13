<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTerm;
use App\Models\Term;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TermController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $terms = Term::get();
            return Datatables::of($terms)
                ->addColumn('action', function ($terms) {
                    return '
                            <button type="button" data-id="' . $terms->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $terms->id . '" data-title="' . $terms->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <a href="' . route('activate', $terms->id) . '" class="btn btn-pill btn-success-light checkBtn">'. ($terms->status == 'active' ? 'مفعل' : 'غير مفعل') .'</a>

                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.terms.index');
        }
    }

    // Index End

    // Create Start

    public function create()
    {
        return view('admin.terms.parts.create');
    }
    // Create End

    // Store Start

    public function store(StoreTerm $request)
    {
        $inputs = $request->all();
        if (Term::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Activate

    public function activate($id)
    {
        $term = Term::where('id', $id)->first();

        if ($term->update([
            'status' => $term->status == 'active' ? 'not_active' : 'active'
        ])) {
            toastr('تم التفعيل');
            return view('admin.terms.index');
        } else {

        }

    }

    // Activate

    // Edit Start

    public function edit(Term $term)
    {
        return view('admin.terms.parts.edit', compact('term'));
    }


    // Edit End

    // Update Start

    public function update(StoreTerm $request, Term $term)
    {
        if ($term->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $terms = Term::where('id', $request->id)->firstOrFail();
        $terms->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

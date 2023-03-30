<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTerm;
use App\Models\Term;
use App\Models\Season;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TermController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        $seasons = Season::all();
        if ($request->ajax()) {
            $terms = Term::get();
            return Datatables::of($terms)
                ->addColumn('action', function ($terms) {
                    return '
                            <button type="button" data-id="' . $terms->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $terms->id . '" data-title="' . $terms->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>

                       ';
                })
                ->editColumn('status', function ($terms) {
                    if($terms->status == 'active') {
                        return '<a href="' . route('activate', $terms->id) . '" class="btn btn-pill btn-success-light">مفعل</a>';
                    }
                    else {
                        return '<a href="' . route('activate', $terms->id) . '" class="btn btn-pill btn-danger-light">غير مفعل</a>';
                    }
                })
                ->editColumn('season_id', function ($terms) {
                    return '<td>'. $terms->seasons->name_ar .'</td>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.terms.index', compact('seasons'));
        }
    }

    // Index End

    // Filter Start

    public function filterTerm(Request $request)
    {
        $seasonId = $request->input('season_id');

        $terms = Term::query()
            ->when($seasonId, function ($query, $seasonId) {
                return $query->where('season_id', $seasonId);
            })
            ->get();

        return DataTables::of($terms)
            ->addColumn('action', function ($terms) {
                return '
                            <button type="button" data-id="' . $terms->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $terms->id . '" data-title="' . $terms->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
            })
            ->editColumn('status', function ($terms) {
                if($terms->status == 'active') {
                    return '<a href="' . route('activate', $terms->id) . '" class="btn btn-pill btn-success-light">مفعل</a>';
                }
                else {
                    return '<a href="' . route('activate', $terms->id) . '" class="btn btn-pill btn-danger-light">غير مفعل</a>';
                }
            })
            ->editColumn('season_id', function ($terms) {
                return '<td>' . $terms->seasons->name_ar . '</td>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    // Filter End

    // Create Start

    public function create()
    {
        $data['seasons'] = Season::all();
        return view('admin.terms.parts.create', compact('data'));
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
            if($term->status == 'active')
            {
                toastr('تم التفعيل');
            }
            else
            {
                toastr('تم ألغاء التفعيل');
            }

            return view('admin.terms.index');
        }
    }

    // Activate

    // Edit Start

    public function edit(Term $term)
    {
        $data['seasons'] = Season::all();
        return view('admin.terms.parts.edit', compact('term', 'data'));
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

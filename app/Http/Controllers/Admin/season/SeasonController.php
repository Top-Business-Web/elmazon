<?php

namespace App\Http\Controllers\Admin\season;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeason;
use App\Models\Season;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SeasonController extends Controller
{
    public function index(request $request)
    {
        if ($request->ajax()) {
            $seasons = Season::get();
            return Datatables::of($seasons)
                ->addColumn('action', function ($seasons) {
                    return '
                            <button type="button" data-id="' . $seasons->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $seasons->id . '" data-title="' . $seasons->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.seasons.index');
        }
    }

    public function create()
    {
        return view('admin.seasons.parts.create');
    }

    public function store(StoreSeason $request)
    {
        $inputs = $request->all();
        if (Season::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    public function edit(Season $season)
    {
        return view('admin.seasons.parts.edit', compact('season'));
    }

    public function update(StoreSeason $request, Season $season)
    {
        if ($season->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    public function destroy(Request $request)
    {
        $seasons = Season::where('id', $request->id)->firstOrFail();
        $seasons->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}

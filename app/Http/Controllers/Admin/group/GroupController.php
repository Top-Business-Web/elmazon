<?php

namespace App\Http\Controllers\Admin\group;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Season;

class GroupController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $groups = Group::get();
            return Datatables::of($groups)
                ->addColumn('action', function ($groups) {
                    return '
                            <button type="button" data-id="' . $groups->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $groups->id . '" data-title="' . $groups->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.groups.index');
        }
    }

    // Index End

    // Create Start

    public function create()
    {
        $season_id = Season::get();
        return view('admin.groups.parts.create', compact('season_id'));
    }

    // Create End

    // Store Start

    public function store(StoreGroup $request)
    {
        $inputs = $request->all();
        if (Group::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(Group $group)
    {
        $seasons = Season::get();
        return view('admin.groups.parts.edit', compact('group', 'seasons'));
    }

    // Edit End

    //Update Start

    public function update(Group $group, StoreGroup $request)
    {
        if ($group->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $groups = Group::where('id', $request->id)->firstOrFail();
        $groups->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestSubscribe;
use App\Models\Season;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Subscribe;
use App\Models\Term;

class SubscribeController extends Controller
{
    use AdminLogs;
    // Index START
    public function index(request $request)
    {
        if ($request->ajax()) {
            $subscribes = Subscribe::get();
            return Datatables::of($subscribes)
                ->addColumn('action', function ($subscribes) {
                    return '
                            <button type="button" data-id="' . $subscribes->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $subscribes->id . '" data-title="' . $subscribes->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.subscribes.index');
        }
    }

    // End Index

    // Create START

    public function create()
    {
        $data['terms'] = Term::all();
        $data['seasons'] = Season::all();
        return view('admin.subscribes.parts.create', compact('data'));
    }

    // Create END

    // Store START

    public function store(RequestSubscribe $request)
    {
        $inputs = $request->all();

        if($request->has('free')) {
            if($request->free == '1') {
                $inputs['free'] = 'yes';
            }
            else {
                $inputs['free'] = 'no';
            }
        }

        if (Subscribe::create($inputs)) {
            $this->adminLog('تم اضافة باقة جديدة');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store END

    // Edit Start

    public function edit(Subscribe $subscribe)
    {
        $data['seasons'] = Season::get();
        $data['terms'] = Term::get();
        return view('admin.subscribes.parts.edit', compact('data', 'subscribe'));
    }

    // Edit End

    // Update Start

    public function update(Subscribe $subscribe, RequestSubscribe $request)
    {
        $inputs = $request->all();

        if($request->has('free')) {
            if($request->free == '1') {
                $inputs['free'] = 'yes';
            }
            else {
                $inputs['free'] = 'no';
            }
        }

        if ($subscribe->update($inputs)) {
            $this->adminLog('تم تحديث باقة ');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $subject_class = Subscribe::where('id', $request->id)->firstOrFail();
        $subject_class->delete();
        $this->adminLog('تم حذف باقة ');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}

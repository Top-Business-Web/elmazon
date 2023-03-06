<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestMonthlyPlan;
use App\Models\MonthlyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class MonthlyPlanController extends Controller
{

    // Index START

    public function index(request $request)
    {
        if ($request->ajax()) {
            $monthlyPlans = MonthlyPlan::get();
            return Datatables::of($monthlyPlans)
                ->addColumn('action', function ($monthlyPlans) {
                    return '
                            <button type="button" data-id="' . $monthlyPlans->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $monthlyPlans->id . '" data-title="' . $monthlyPlans->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.monthly_plans.index');
        }
    }

    // End Index

    // Create START

    public function create()
    {
        return view('admin.monthly_plans.parts.create');
    }

    // Create END


    // Store START

    public function store(RequestMonthlyPlan $request)
    {
        $inputs = $request->all();
        if (MonthlyPlan::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store END

    // Edit START

    public function edit(MonthlyPlan $monthlyPlan)
    {
        return view('admin.monthly_plans.parts.edit', compact('monthlyPlan'));
    }
    // Edit END

    // Update START

    public function update(RequestMonthlyPlan $request, MonthlyPlan $monthlyPlan)
    {
        if ($monthlyPlan->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update END

    // Delete START

    public function destroy(Request $request)
    {
        $monthlyPlan = MonthlyPlan::where('id', $request->id)->firstOrFail();
        $monthlyPlan->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Delete END
}

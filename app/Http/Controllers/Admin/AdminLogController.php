<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminLogController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $logs = AdminLog::get();
            return Datatables::of($logs)
                ->addColumn('button', function ($logs) {
                    return '<button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $logs->id . '" data-title="' . $logs->action . '">
                                    <i class="fas fa-trash"></i>
                            </button>';
                })
                ->editColumn('admin_id', function ($logs) {
                    return $logs->admin->name;
                })
                ->addColumn('role', function ($logs) {
                    $adminRole = $logs->admin->roles->pluck('name', 'name')->first();
                    if ($adminRole == 'سوبر ادمن') {
                        return '<span class="badge badge-primary-gradient">' . $adminRole . '</span>';
                    } else {
                        return '<span class="badge badge-info">' . $adminRole . '</span>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            AdminLog::where('seen','=',0)->update(['seen' => 1]);
            return view('admin.admin.admin_logs');
        }
    }// End Index

    public function delete(Request $request)
    {
        $admin = AdminLog::where('id', $request->id)->first();
        $admin->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } // end of delete

    public function deleteAll(Schedule $schedule)
    {
        AdminLog::delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } // end of delete
}

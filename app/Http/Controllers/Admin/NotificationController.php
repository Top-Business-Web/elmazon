<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;

class NotificationController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $notifications = Notification::get();
            return Datatables::of($notifications)
                ->addColumn('action', function ($notifications) {
                    return '
                            <button type="button" data-id="' . $notifications->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $notifications->id . '" data-title="' . $notifications->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.notifications.index');
    }

    // Create Start

    public function create()
    {
        $users = User::get();
        return view('admin.notifications.parts.create', compact('users'));
    }

    // Create End

    // Store Start

    public function store(StoreNotification $request)
    {
        $input = $request->all();
        if(Notification::create($input)) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(Notification $notification)
    {
        $users = User::all();
        return view('admin.notifications.parts.edit', compact('notification', 'users'));
    }

    // Edit End

    // Update Start

    public function update(Notification $notification, StoreNotification $request)
    {
        if($notification->update($request->all())) {
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Delete Start

    public function destroy(Request $request)
    {
        $notifications = Notification::where('id', $request->id)->firstOrFail();
        $notifications->delete();
        return response()->json(['message' => 'تم الحذف بنجاح' ,'status' => 200], 200);
    }

    // Delete End
}

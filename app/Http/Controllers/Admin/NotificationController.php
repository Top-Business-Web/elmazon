<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\Traits\FirebaseNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationStoreRequest;
use App\Http\Requests\StoreNotification;
use App\Models\Notification;
use App\Models\Season;
use App\Models\Term;
use App\Traits\AdminLogs;
use App\Traits\PhotoTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;

class NotificationController extends Controller
{
    use FirebaseNotification, PhotoTrait, AdminLogs;

    public function index(request $request)
    {
        if ($request->ajax()) {
            $notifications = Notification::get();
            return Datatables::of($notifications)
                ->addColumn('action', function ($notifications) {
                    return '
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


    public function searchUser(Request $request)
    {
        $code = $request->input('code');
        $user = User::where('code', $code)->first();

        if ($user) {
            return response('هذا الطالب موجود');
        } else {
            return response('هذا الطالب غير موجود');
        }
    }


    public function create()
    {
        $data['terms'] = Term::get();
        $data['seasons'] = Season::get();
        $data['users'] = User::query()->select('id','name','code')->get();
        return view('admin.notifications.parts.create', $data);
    }


    public function store(NotificationStoreRequest $request): JsonResponse
    {
        $inputs = $request->all();
        $inputs['image'] = '';
        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/notification');
        }

        $user = User::query()
        ->where('id','=',$request->user_id)
            ->first();

        if ($request->has('user_select')) {
            $inputs['user_select'] = $user->id;
        } else
        {
            $error = 'ليس هناك مستخدم بهذا الكود';
            toastr($error, 'info');
        }

        $this->sendFirebaseNotification(['title' => $request->title, 'body' => $request->body, 'term_id' => $inputs['term_id']], $inputs['season_id'], $user->id, $inputs['image']);

        if (Notification::create($inputs)) {
            $this->adminLog('تم اضافة اشعار');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    public function edit(Notification $notification)
    {
        $data['terms'] = Term::get();
        $data['seasons'] = Season::get();
        $data['users'] = User::get();
        $data['notification'] = $notification;
        return view('admin.notifications.parts.edit', $data);
    }


    public function update(Notification $notification, Request $request): JsonResponse
    {
        $inputs = $request->all();
        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/notification');
        }

        if ($notification->update($inputs)) {
            $this->adminLog('تم تحديث اشعار');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function destroy(Request $request): JsonResponse
    {
        $notifications = Notification::query()
        ->where('id', $request->id)
            ->firstOrFail();

        $notifications->delete();
        $this->adminLog('تم حذف اشعار');
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

}

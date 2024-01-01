<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\User;
use App\Models\VideoOpened;
use App\Models\VideoParts;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class AdvancedController extends Controller
{
    use AdminLogs;

    public function index()
    {
        $students = User::query()->select('id','code')->get();
        $videos = VideoParts::query()->select('id','name_ar')->get();
        return view('admin.advanced.index',compact('students','videos'));
    }

    public function do(Request $request)
    {
        $videoOpen = VideoOpened::query()
        ->create([
            'user_id' => $request->user_id,
            'video_part_id' => $request->video_id,
            'status' => 'opened',
            'type' => 'video',
        ]);

        toastr()->addSuccess('تم فتح الفيديو بنجاح');
        return redirect()->back();

    }



}

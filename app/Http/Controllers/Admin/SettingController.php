<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Setting;
use App\Http\Requests\RequestSetting;
use App\Traits\PhotoTrait;

class SettingController extends Controller
{
    use PhotoTrait;
    use AdminLogs;

    // Index Start
    public function index(Request $request)
    {
        $settings = Setting::find(1);
        return view('admin.settings.index', compact('settings'));
    }
    // Index End

    // Update Start
    public function update(Request $request)
    {
        $settings = Setting::findOrFail($request->id);

        $inputs = $request->all();

        if ($request->hasFile('teacher_image')) {
            if (file_exists($settings->teacher_image)) {
                unlink($settings->teacher_image);
            }
            $inputs['teacher_image'] = $this->saveImage($request->teacher_image, 'teacher_image', 'photo');
        }

        // dd($inputs);
        if ($settings->update($inputs)){
            $this->adminLog('تم تحديث الاعدادات');
            return response()->json(['status' => 200]);
        }
        else{
            return response()->json(['status' => 405]);
        }
    }

    // Update End

}

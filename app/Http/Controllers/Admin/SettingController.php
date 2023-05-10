<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Setting;
use App\Http\Requests\RequestSetting;

class SettingController extends Controller
{
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

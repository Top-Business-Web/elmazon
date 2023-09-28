<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Models\AdminLog;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    use AdminLogs;

    // Index Start
    public function index()
    {
        $qualifications = Qualification::where('type', 'qualifications')->get();
        $experiences = Qualification::where('type', 'experience')->get();
        $skills = Qualification::where('type', 'skills')->get();
        return view('admin.qualifications.index', compact('qualifications', 'skills', 'experiences'));
    }

    // Index End

    public function edit(Qualification $qualification)
    {
        return view('admin.qualifications.parts.edit', compact('qualification'));
    }

    public function store(Request $request)
    {

        $inputs = $request->all();
        Qualification::create($inputs);

        return redirect()->route('qualification.index')->with('success', 'تم الاضافة بنجاح');
    }

    // Update Start
    public function update(Request $request)
    {
        $about_me = Qualification::findOrFail($request->id);

        $inputs = $request->all();

        if ($about_me->update($inputs)) {
            $this->adminLog('تم عمل تحديث عن المدرس');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 500]);
        }
    }// Update End

    public function delete(Request $request)
    {
        $qualification = Qualification::findOrFail($request->id);
        $qualification->delete();
        $this->adminLog('تم حذف معلومات عن المدرس');
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } // end of delete
}

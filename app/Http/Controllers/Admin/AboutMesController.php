<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Illuminate\Http\Request;

class AboutMesController extends Controller
{
    // Index Start
    public function index()
    {
        $about_me = AboutMe::all();
        return view('admin.about_mes.index', compact('about_me'));
    }
    // Index End

    // Update Start

    public function update(Request $request)
    {
        $about_me = AboutMe::findOrFail($request->id);

        $inputs = $request->all();


        if ($about_me->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 500]);
        }
    }

    // Update End
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Illuminate\Http\Request;

class AboutMesController extends Controller
{
    // Index Start
    public function index(Request $request)
    {
        $about_me = AboutMe::find(1);
        return view('admin.about_mes.index', compact('about_me'));
    }
    // Index End
}

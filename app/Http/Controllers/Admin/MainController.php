<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lesson;
use App\Models\LifeExam;
use App\Models\OnlineExam;
use App\Models\PapelSheetExam;
use App\Models\Question;
use App\Models\SubjectClass;
use App\Models\Suggestion;
use App\Models\User;
use App\Models\VideoBasic;
use App\Models\VideoParts;
use App\Models\VideoResource;

class MainController extends Controller
{
    public function index()
    {
        $data['users'] = User::count();
        $data['usersIn'] = User::where('center', '=', 'in')->count();
        $data['usersOut'] = User::where('center', '=', 'out')->count();
        $data['onlineExam'] = OnlineExam::count();
        $data['paperExam'] = PapelSheetExam::count();
        $data['liveExam'] = LifeExam::count();
        $data['videoResource'] = VideoResource::count();
        $data['videoParts'] = VideoParts::count();
        $data['videoBasic'] = VideoBasic::count();
        $data['question'] = Question::count();
        $data['lesson'] = Lesson::count();
        $data['class'] = SubjectClass::count();
        $data['suggest'] = Suggestion::count();
        $data['country_val'] = User::groupBy('country_id')
            ->select('country_id', \DB::raw('count(*) as total'))
            ->with('country')
            ->pluck('total', 'country_id')->toArray();
        $data['country_name'] = Country::whereIn('id', array_keys($data['country_val']))
        ->pluck('name_ar', 'id')->toArray();

        return view('admin.index')->with($data);
    }



}

<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\Term;
use App\Models\User;
use App\Models\Season;
use Stripe\Capability;
use App\Models\AllExam;
use App\Models\Country;
use App\Models\Subscribe;
use App\Traits\AdminLogs;
use App\Models\OnlineExam;
use App\Models\OpenLesson;
use App\Models\VideoParts;
use App\Traits\PhotoTrait;
use App\Models\VideoOpened;
use Illuminate\Http\Request;
use App\Models\UserSubscribe;
use App\Models\OnlineExamUser;
use App\Models\PapelSheetExam;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Http\Requests\StoreUser;
use Yajra\DataTables\DataTables;
use App\Http\Requests\UpdateUser;
use App\Models\ExamDegreeDepends;
use App\Models\PapelSheetExamUser;
use Illuminate\Support\Facades\DB;
use App\Exports\MotivationalExport;
use App\Imports\MotivationalImport;
use function Clue\StreamFilter\fun;
use App\Http\Controllers\Controller;
use App\Models\PapelSheetExamDegree;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UserUpdateRequest;
use Buglinjo\LaravelWebp\Exceptions\CwebpShellExecutionFailed;
use Buglinjo\LaravelWebp\Exceptions\DriverIsNotSupportedException;
use Buglinjo\LaravelWebp\Exceptions\ImageMimeNotSupportedException;

class UserController extends Controller
{
    use PhotoTrait, AdminLogs;

    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $users = User::select('*');
            return Datatables::of($users)
                ->addColumn('action', function ($users) {
                    return '
                            <button type="button" data-id="' . $users->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $users->id . '" data-title="' . $users->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" data-id="' . $users->id . '" class="btn btn-pill btn-success-light renew">تجديد الاشتراك</i></button>
                            <a href="' . route('printReport', $users->id) . '" data-id="' . $users->id . '" class="btn btn-pill btn-info-light reportPrint"> تقرير الطالب <i class="fa fa-file-excel"></i></a>
                       ';
                })
                // ->filter(function ($q) use ($request) {
                //     if ($request->has('type')) {

                //         return

                //         // return UserSubscribe::whereIn('student_id', '=', $users)
                //         //  ->where('month','<=', Carbon::now()->subMonth())->latest()->first();
                //     }
                // })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.users.index');
        }
    }

    public function create()
    {
        $data['seasons'] = Season::get();
        $data['countries'] = Country::get();
        return view('admin.users.parts.create')->with($data);
    }


    public function store(StoreUser $request)
    {
        $inputs = $request->all();
        $inputs['user_status'] = 'active';
        $inputs['password'] = Hash::make('123456');

        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'user', 'photo');
        }

        if (User::create($inputs)) {
            $this->adminLog('تم اضافة طالب جديد');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        } // Create End
    }


    public function edit(User $user)
    {
        $data['seasons'] = Season::get();
        $data['countries'] = Country::get();
        return view('admin.users.parts.edit', compact('user'))->with($data);
    }
    // Edit End

    // Update Start

    /**
     * @throws CwebpShellExecutionFailed
     * @throws ImageMimeNotSupportedException
     * @throws DriverIsNotSupportedException
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        $inputs = $request->except('id');

        if ($request->has('image')) {
            if (file_exists($user->image)) {
                unlink($user->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/students', 'photo');
        }

        if ($user->update($inputs)) {
            $this->adminLog('تم تحديث طالب');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Edit End

    // User Unvilable start

    public function userUnvilable()
    {
        $unavailableUsers = UserSubscribe::where('updated_at', '<=', Carbon::now()->subMonth())
            ->groupBy('student_id')
            ->select('student_id', DB::raw('MAX(id) as id'), DB::raw('MAX(updated_at) as updated_at'))
            ->get();
        return view('admin.users.parts.user_unvilable', compact('unavailableUsers'));
    }

    // User Unvilable end

    // Subscripition View Start

    public function subscrView(User $user)
    {
        $userSubscriptions = UserSubscribe::where('student_id', $user->id)->pluck('month')->toArray();
        $months_user = Subscribe::whereIn('month', $userSubscriptions)->get();
        $months = Subscribe::get();
        return view('admin.users.parts.subscription_renewal', compact('user', 'months', 'months_user'));
    }

    // Subscripition View End

    // Subscripition Renewal Start

    public function subscr_renew(Request $request, User $user)
    {

        $user = User::findOrFail($request->id);

        $inputs = $request->all();
        $year = $inputs['year'];

        foreach ($inputs['month'] as $value) {
            $month = Subscribe::find($value);
            UserSubscribe::create([
                'student_id' => $user->id,
                'month' => $value,
                'price' => ($user->center == 'in') ? $month->price_in_center : $month->price_out_center,
                'year' => $year
            ]);
        }
        toastr('تم التجديد بنجاح');
        return redirect()->route('users.index');
    }

    // Subscripition Renewal End

    public function priceMonth(Request $request)
    {
        $user = User::find($request->id);

        $month = $request->month;
        $price_out_center = Subscribe::whereIn('month', $month)
            ->where('season_id', $user->season_id)
            ->sum('price_in_center');

        $price_in_center = Subscribe::whereIn('month', $month)
            ->where('season_id', $user->season_id)
            ->sum('price_out_center');
        //            ->get(['price_in_center', 'price_out_center']);
        //        dd($price_out_center,$price_in_center);

        $output = '';
        //        foreach ($price_out_center as $p) {
        $output .= '<option value="' . $price_in_center . '">' . ' السعر داخل السنتر ' . $price_in_center . '</option>';
        $output .= '<option value="' . $price_out_center . '">' . ' السعر خارج السنتر ' . $price_out_center . '</option>';
        //        }

        return $output;
    }


    // print report
    public function printReport($id)
    {
        $user = User::findOrFail($id);
        $term = Term::where('season_id', $user->season_id)
            ->where('status', '=', 'active')->first();
        $lessonCount = OpenLesson::where('user_id', $user->id)
            ->where('lesson_id', '!=', null)->count('lesson_id');

        $classCount = OpenLesson::where('user_id', $user->id)
            ->where('subject_class_id', '!=', null)->count('subject_class_id');

        $videos = VideoOpened::where('user_id', $user->id)
            ->where('type', 'video')
            ->with('video')->get();

        $videoMin = VideoOpened::query()
            ->where('user_id', $user->id)
            ->where('type', 'video')
            ->get('minutes');

        $totalTime = Carbon::parse('00:00:00');

        foreach ($videoMin as $timeValue) {
            // Parse the time value into a Carbon instance
            $timeCarbon = Carbon::parse($timeValue->minutes);

            // Add the hours, minutes, and seconds to the total time
            $totalTime->addHours($timeCarbon->hour);
            $totalTime->addMinutes($timeCarbon->minute);
            $totalTime->addSeconds($timeCarbon->second);
        }

        $totalTimeFormatted = $totalTime->format('H:i:s');

        $exams = ExamDegreeDepends::where('user_id', '=', $user->id)
            ->where('exam_depends', '=', 'yes')->get();
        $paperExams = PapelSheetExamDegree::where('user_id', '=', $user->id)->get();
        $subscriptions = UserSubscribe::where('student_id', $user->id)->get();
        return view('admin.users.parts.report', compact([
            'user',
            'videos',
            'exams',
            'subscriptions',
            'paperExams',
            'term',
            'lessonCount',
            'classCount',
            'totalTimeFormatted'

        ]));
    }


    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->firstOrFail();
        $user->delete();
        $this->adminLog('تم حذف طالب ');
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }


    //added by islam mohamed
    public function studentsExport(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new StudentsExport(), 'Students.xlsx');

    }

    public function studentsImport(Request $request): \Illuminate\Http\JsonResponse
    {
        $import = Excel::import(new StudentsImport(), $request->exelFile);
        if ($import) {
            $this->adminLog('تم استيراد ملف جديد لبيانات الطلبه');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 500]);
        }
    }

}

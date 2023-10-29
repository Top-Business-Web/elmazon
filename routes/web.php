<?php

use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\VideoPartController;
use App\Http\Controllers\Api\Payment;
use App\Models\Lesson;
use App\Models\SubjectClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('admin.index');
//});
Route::get('/payments/verify/{payment?}',[Payment::class,'payment_verify'])->name('payment-verify');
Route::get('/payments/payWithFawry',[Payment::class,'payWithFawry'])->name('payment-verify');


//get all terms by season_id
Route::get('terms/season/{id}',[TermController::class,'getAllTermsBySeason'])->middleware('auth:admin');


//Route::get('get-minutes', function (){
//
//    $video_part_time = \App\Models\VideoParts::query()
//        ->find(1)->video_part_time;
//
//    $total_watch = \App\Models\VideoOpened::query()
//        ->find(29)->total_watch;
//
//    $timeDifference = Carbon::parse($total_watch)->diffInSeconds(Carbon::parse($video_part_time));
//    $total = $timeDifference;
//
//
//    return $total;
//
//});


/*

  1- Create Api to add like in (Video_part,Video_basic,video_resource)
  2- Edit in api Make exam with yourself when add list of questions in api equal the exam questions length


  1- Taxi supported for mobile application in api in multiple links


 */


//Route::get('add-cities', function (){
//
////    DB::table('exam_degree_depends')->update(['created_at' => Carbon::now()]);
////    return "Done update";
//
//
//    $array = [
//        'Alexandria' => 'الاسكندريه',
//        'Aswan' => 'اسوان',
//        'Asyut' => 'اسيوط',
//        'Beheira' => 'البحيره',
//        'Beni Suef' => 'بني سويف',
//        'Cairo' => 'القاهره',
//        'Dakahlia' => 'الدقهليه',
//        'Damietta' => 'دمياط',
//        'Faiyum' => 'الفيوم',
//        'Gharbia' => 'الغربيه',
//        'Giza' => 'الجيزه',
//        'Ismailia' => 'الاسماعليه',
//        'Kafr El Sheikh' => 'كفر الشيخ',
//        'Luxor' => 'الاقصر',
//        'Matruh' => 'مطروح',
//        'Minya' => 'المنيا',
//        'Monufia' => 'المنوفيه',
//        'New Valley' => 'الوادي الجديد',
//        'North Sinai' => 'شمال سيناء',
//        'Port Sai' => 'بور سعيد',
//        'Qalyubia' => 'القليوبيه',
//        'Qena' => 'قنا',
//        'Red Sea' => 'البحر الاحمر',
//        'Sharqia' => 'الشرقيه',
//        'Sohag' => 'سوهاج',
//        'South Sinai' => 'جنوب سيناء',
//        'Suez' => 'السويس',
//    ];
//
//    foreach ($array as $key => $value){
//
//        DB::table('cities')->insert(['name_ar' => $value ,'name_en' => $key,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
//    }
//
//    return "Done insert";
//});


//       $max_size = $document->getMaxFileSize() / 1024 / 1024;  // Get size in Mb
//Route::get('update-users-status',function (){
//
//    DB::table('users')->update(['login_status' => 0]);
//
//    return "Done Update";
//});



Route::get('getAllSubjectClassesBySeasonAndTerm',[VideoPartController::class,'getAllSubjectClassesBySeasonAndTerm']);
Route::get('getAllLessonsBySubjectClass', [VideoPartController::class,'getAllLessonsBySubjectClass']);


Route::get('update-users',function (){

    DB::table('users')->update(['date_end_code' => '2023-10-31']);

    return "Done Update";
});

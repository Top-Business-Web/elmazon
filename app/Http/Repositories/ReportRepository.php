<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ReportRepositoryInterface;
use App\Http\Requests\ReportApiRequest;
use App\Http\Resources\ReportApiResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportRepository extends ResponseApi implements ReportRepositoryInterface {


    public function studentAddReport(ReportApiRequest $request): JsonResponse
    {

        try {

//            if ($request->video_part_id === null && $request->video_basic_id === null && $request->video_resource_id === null) {
//                return self::returnResponseDataApi(null, "يجب عليك ارفاق الفيديو الذي تم البلاغ عنه", 407);
//            }

            $report = Report::create([
                 'report' => $request->report,
                 'user_id' => Auth::guard('user-api')->id(),
                'type' => $request->type,
                'video_part_id' => $request->video_part_id ?? null,
                'video_basic_id' => $request->video_basic_id ?? null,
                'video_resource_id' => $request->video_resource_id ?? null,
            ]);

            if($report->save()){
                return self::returnResponseDataApi(new ReportApiResource($report),"تم رفع البلاغ بنجاح",200);

            }else{
                return self::returnResponseDataApi(null,"يوجد خطاء ما اثناء ادخال البيانات",500);

            }


        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}
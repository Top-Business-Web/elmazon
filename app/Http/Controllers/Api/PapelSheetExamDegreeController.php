<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PapelSheetExamUserDegreeResource;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use App\Models\User;
use Illuminate\Http\Request;

class PapelSheetExamDegreeController extends Controller{


    public function papelsheet_details(Request $request){

        $papel_sheet = PapelSheetExam::where('id','=',$request->papel_sheet_id)->first();
        if(!$papel_sheet){
            return self::returnResponseDataApi(null,"الامتحان الورقي غير موجود",404,404);
        }

        $users = User::whereHas('papel_sheet_exam_degree',function ($degree)use($papel_sheet){
            $degree->where('papel_sheet_exam_id','=',$papel_sheet->id);
        })->orderBy(
            PapelSheetExamDegree::select('degree')
                // This can vary depending on the relationship
                ->whereColumn('user_id', 'users.id')
                ->orderBy('degree','desc')
        ,'desc')->take(10)->get();

        return response()->json([
            'data' => [
                'users' => PapelSheetExamUserDegreeResource::collection($users),
                'ordered' => 5,
                'degree' => PapelSheetExamDegree::where('papel_sheet_exam_id','=',$papel_sheet->id)
                    ->where('user_id','=',auth('user-api')->id())->first()->degree,
            ]

        ]);


    }

}

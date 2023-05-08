<?php

namespace App\Http\Controllers\Api\LiveExam;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveExamController extends Controller{



   public function allOfQuestions($id): JsonResponse{

       return self::returnResponseDataApi(null,"Hello in my app",200);

   }


    public function addLiveExamByStudent(Request $request,$id): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }


    public function allOfLiveExams(): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }


    public function allOfExamHeroes($id): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }

    public function resultOfLiveExam($id): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }


}

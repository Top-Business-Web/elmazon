<?php

namespace App\Http\Controllers\Api\DegreeOfExamsDetails;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamDegreeDetailsResource;
use App\Http\Resources\LessonExamDegreeDetailsResource;
use App\Http\Resources\SubjectClassExamDegreeDetailsResource;
use App\Http\Resources\VideoExamDegreeDetailsResource;
use App\Models\AllExam;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\SubjectClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DegreeExamsDetailsController extends Controller{


    public function allExamsDegreeDetails(): JsonResponse{

        $allExams = AllExam::AllExamDegreeDetailsForStudent();
        return self::returnResponseDataApi(AllExamDegreeDetailsResource::collection($allExams),"تم الحصول علي جميع درجات الامتحانات الشامله",200);

    }

    public function classDegreeDetails($id): JsonResponse{

        $class = SubjectClass::find($id);
        if(!$class){
            return self::returnResponseDataApi(null,"هذا الفصل غير موجود",404);
        }

        $onlineExams =  OnlineExam::OnlineExamSubjectClassDegreeDetails($class);
        return self::returnResponseDataApi(SubjectClassExamDegreeDetailsResource::collection($onlineExams),"تم الحصول علي جميع درجات امتحانات هذا الفصل للطالب",200);

    }


    public function videosByLessonDegreeDetails($id): JsonResponse{


        $lesson = Lesson::find($id);
        if(!$lesson){
            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404);
        }

        $onlineExams =  OnlineExam::OnlineExamLessonVideosDegreeDetails($lesson);
        return self::returnResponseDataApi(VideoExamDegreeDetailsResource::collection($onlineExams),"تم الحصول علي جميع درجات امتحانات فيديوهات الشرح لهذا الدرس بنجاح",200);

    }

    public function lessonDegreeDetails($id): JsonResponse{

        $lesson = Lesson::find($id);
        if(!$lesson){
            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404);
        }
        $onlineExams =  OnlineExam::OnlineExamLessonDegreeDetails($lesson);
        return self::returnResponseDataApi(LessonExamDegreeDetailsResource::collection($onlineExams),"تم الحصول علي جميع درجات امتحانات الدرس بنجاح",200);


    }
}

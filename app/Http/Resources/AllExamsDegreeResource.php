<?php

namespace App\Http\Resources;

use App\Models\AllExam;
use App\Models\ExamDegreeDepends;
use App\Models\OnlineExam;
use App\Models\OnlineExamUser;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use App\Models\Timer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Time;

class AllExamsDegreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($request->exam_type == 'papel_sheet'){
            $exam = PapelSheetExam::where('id','=',$request->id)->first();
            $degree = PapelSheetExamDegree::where('user_id','=',$this->id)->where('papel_sheet_exam_id','=',$request->id)->first();
            $degree = $degree->degree;

            $trying = 0;
            $depends = "";

        }elseif ($request->exam_type == 'video' || $request->exam_type == 'subject_class' || $request->exam_type == 'lesson'){
            $exam = OnlineExam::where('id','=',$request->id)->first();
            $degree = ExamDegreeDepends::where('user_id','=',$this->id)
                ->where('exam_depends','=','yes')
                ->where('online_exam_id','=',$request->id)->first();
            $degree = $degree->full_degree;

            $timer = Timer::where('user_id','=',$this->id)
                ->where('online_exam_id','=',$request->id)->latest()->first();

            $number_mistake = OnlineExamUser::where('user_id','=',$this->id)
                ->where('online_exam_id','=',$request->id)
                ->where('status','=','un_correct')
                ->groupBy('online_exam_id')
                ->count();

            $depends = ExamDegreeDepends::where('online_exam_id', '=',$request->id)->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('exam_depends', '=', 'yes')->first();

            $trying = Timer::where('online_exam_id',$request->id)->where('user_id','=',auth('user-api')->id())->count();


        }else{
            $exam = AllExam::where('id','=',$request->id)->first();
            $degree = ExamDegreeDepends::where('user_id','=',$this->id)
                ->where('exam_depends','=','yes')
                ->where('all_exam_id','=',$request->id)->first();

            $degree = $degree->full_degree;
            $timer = Timer::where('user_id','=',$this->id)
                ->where('all_exam_id','=',$request->id)->latest()->first();

            $number_mistake = OnlineExamUser::where('user_id','=',$this->id)
                ->where('all_exam_id','=',$request->id)
                ->where('status','=','un_correct')
                ->groupBy('all_exam_id')
                ->count();

            $depends = ExamDegreeDepends::where('all_exam_id', '=',$request->id)->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('exam_depends', '=', 'yes')->first();
            $trying = Timer::where('all_exam_id',$request->id)->where('user_id','=',auth('user-api')->id())->count();

        }

        return  [
            'id' => $this->id,
            'name' => $this->name,
            'timer' => $timer->timer ?? 0,
            'number_mistake' => $number_mistake ?? 0,
            'trying_number_again' => !$depends?((int)$exam->trying_number - (int)$trying) : 0,
            'image' => $this->image != null ? asset('/users/'.$this->image) : asset('/default/avatar.jpg'),
            'percentage' => ((int)$degree / (int)$exam->degree) * 100 . "%",
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\AllExam;
use App\Models\ExamDegreeDepends;
use App\Models\OnlineExam;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroesExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){

        $online_exams = OnlineExam::whereHas('season', function ($season) {
        $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
        $term->where('status', '=', 'active');
        })->pluck('id')->toArray();

        $all_exams = AllExam::whereHas('season', function ($season) {
        $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
        $term->where('status', '=', 'active');
        })->pluck('id')->toArray();

        $degrees = ExamDegreeDepends::whereIn('online_exam_id',$online_exams)
        ->orWhereIn('all_exam_id',$all_exams)
        ->get();

       $total = 0;
       $exam = "";
        foreach ($degrees as $degree){
            if($degree->online_exam_id != null){
                $exam = OnlineExam::where('id', '=',$degree->online_exam_id)->first();
                $total = $degree->where('user_id','=',$this->id)->where('exam_depends','=','yes')
                ->where('online_exam_id','=',$degree->online_exam_id)
                ->first()->full_degree;

            } else{
                $exam = AllExam::where('id','=', $degree->all_exam_id)->first();
                $total = $degree->where('user_id','=',$this->id)->where('exam_depends','=','yes')
                    ->where('all_exam_id','=',$degree->all_exam_id)
                    ->first()->full_degree;
            }
        }

        return  [
            'id' => $this->id,
            'name' => $this->name,
            'country' => lang() == 'ar'?$this->country->name_ar : $this->country->name_en,
            'ordered' => $this->ordered,
            'image' => $this->image != null ? asset('/users/'.$this->image) : asset('/default/avatar.jpg'),
            'percentage' =>((int)$total / (int)$exam->degree) * 100 . "%"
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\OnlineExamUser;
use App\Models\TextExamUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class QuestionsNewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $answerStudent = OnlineExamUser::where('user_id','=',Auth::guard('user-api')->id())
            ->where('question_id','=',$this->id)
            ->whereHas('question', function ($q){
                $q->where('question_type','=','choice');
            })
            ->first();

        if($this->question_type == 'text'){
            $textExamUser = TextExamUser::query()->where('user_id','=',Auth::guard('user-api')->id())
                ->where('question_id','=',$this->id)
                ->whereHas('question', function ($q){$q->where('question_type','=','text');
                })->first();


            if($textExamUser->answer_type == 'file'){

                $answerTextWithUser = asset('text_user_exam_files/images/'.$this->image);

            }elseif ($textExamUser->answer_type == 'audio'){

                $answerTextWithUser = asset('text_user_exam_files/audios/'.$this->audio);
            }else{

                $answerTextWithUser = $textExamUser->answer;
            }

        }

        return [

            'id' => $this->id,
            'question' => $this->file_type == 'text' ? $this->question : asset('/question_images/'.$this->image),
             'answer_user' => $this->question_type == 'choice' ? ($answerStudent->answer_id ?? null): $answerTextWithUser,
            'answer_user_type' => ($this->question_type == 'choice' ? 'id' : $textExamUser->answer_type),
            'question_type' => $this->question_type,
            'file_type' => $this->file_type,
            'degree' => $this->degree,
            'note' => $this->note ?? 'note',
            'answers' =>  $this->question_type == 'choice' ? QuestionAnswersNewResource::collection($this->answers) : [],
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Lesson;
use App\Models\SubjectClass;
use Illuminate\Http\Resources\Json\JsonResource;

class TextYourselfExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->lesson_id != null){

            $lesson = Lesson::query()->where('id','=',$this->lesson_id)->first();
            $questions = $lesson->questions()->where('difficulty','=',$this->questions_type)->get()->shuffle()->all();

        }else{

            $class = SubjectClass::query()->where('id','=',$this->subject_class_id)->first();
            $questions = $class->questions()->where('difficulty','=',$this->questions_type)->get()->shuffle()->all();
        }
        return [

            'id' => $this->id,
            'questions_type' => $this->questions_type,
            'total_time' => (int)$this->total_time,
            'num_of_questions' => (int)$this->num_of_questions,
            'questions' => QuestionResource::collection($questions),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')

        ];
    }
}

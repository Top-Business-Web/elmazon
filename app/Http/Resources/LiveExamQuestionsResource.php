<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveExamQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //{{elmazon_l.com}}/live-exam/add-exam-by-student/1
        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note'  => $this->note,
            'date_exam' => $this->date_exam,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'quiz_minute' => $this->quize_minute,
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\AllExam;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamInstructionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->online_exam->type == 'lesson'){
            $type  = 'lesson';
        }elseif ($this->online_exam->type == 'subject_class'){
            $type  = 'subject_class';
        }else{
            $type  = 'video';
        }

        return [

            'id' => $this->id,
            'instruction' => $this->instruction,
            'trying_number' => $this->trying_number,
            'number_of_question' => $this->number_of_question,
            'quiz_minute' => $this->online_exam->quize_minute,
            'online_exam_id' => $this->online_exam_id,
            'exam_type' =>  $type,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')

        ];
    }
}

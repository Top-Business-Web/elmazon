<?php

namespace App\Http\Resources;

use App\Models\OnlineExamQuestion;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlineExamQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note,
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}

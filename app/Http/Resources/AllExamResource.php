<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllExamResource extends JsonResource
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
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note,
            'date_exam' => $this->date_exam,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'instruction' => new AllExamInstructionResource($this->instruction),
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\AllExam;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonInstructionResource extends JsonResource
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
            'instruction' => $this->instruction,
            'trying_number' => $this->trying_number,
            'number_of_question' => $this->number_of_question,
            'quiz_minute' => $this->quiz_minute,
            'fullExam' => new AllExamResource($this->all_exam),
            'subject_class' => new SubjectClassResource($this->subject_class),
            'lesson' => new LessonResource($this->lesson),
            'video_part' => $this->video_part,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')

        ];
    }
}
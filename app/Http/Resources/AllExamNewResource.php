<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllExamNewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){

        return [
            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'type' => $this->exam_type,
            'pdf_exam_upload' => $this->pdf_file_upload != null ? asset('all_exams/pdf_file_uploads/'. $this->pdf_file_upload) : null,
            'answer_pdf_file' => $this->answer_pdf_file != null ? asset('all_exams/pdf_answers/'. $this->answer_pdf_file) : null,
            'answer_video_file' => $this->answer_video_file != null ? asset('all_exams/videos_answers/'. $this->answer_video_file) : null,
            'num_of_question' => $this->exam_type == 'online' ? $this->questions->count() : $this->pdf_num_questions,
            'total_time' => $this->quize_minute,

        ];
    }
}

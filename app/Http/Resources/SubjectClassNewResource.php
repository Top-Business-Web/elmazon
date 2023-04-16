<?php

namespace App\Http\Resources;

use App\Models\OpenLesson;
use App\Models\SubjectClass;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectClassNewResource extends JsonResource
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
            'background_color' => $this->background_color,
            'name' => lang() == 'ar' ? $this->note_ar : $this->note_en,
            'title' => lang() == 'ar' ? $this->name_ar : $this->name_en,
            'total_watch' =>  $this->total_watch,
            'num_of_lessons' => $this->lessons->count(),
            'num_of_videos' => $this->videos->count(),
            'total_times' => $this->videos->sum('video_time'),


        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
             'videos_count' => 4,
             'videos_time' => 120,
             'created_at' => $this->created_at->format('Y-m-d'),
             'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

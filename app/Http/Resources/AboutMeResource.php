<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutMeResource extends JsonResource
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
           'teacher_name' => $this->teacher_name,
            'department' => $this->department,
            'qualifications' => $this->qualifications,
            'experience' => $this->experience,
            'skills' => $this->skills,

        ];
    }
}

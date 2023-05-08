<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->video_link != null){
            $path = asset('videos_resources/videos/'. $this->video_link);
        }else{
            $path = asset('videos_resources/all_pdf_uploads/'.$this->pdf_file);
        }
        return  [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
             'type' => $this->type,
            'background_color' => $this->background_color,
            'image' => asset('videos_resources/images/'.$this->image),
            'time' => $this->time ?? 0,
            'path_file' => $path,
            'size' => 1000,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}

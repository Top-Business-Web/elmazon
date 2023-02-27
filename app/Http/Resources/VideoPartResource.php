<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoPartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->type == "video"){
            $link = asset('videos/'. $this->link);
        }elseif ($this->type == "audio"){

            $link = asset('audios/'. $this->link);
        }else{
            $link = asset('pdf/'. $this->link);
        }
        return [

            'id' => $this->id,
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note ?? 'No notes',
            'link' => $link,
            'type' => $this->type,
            'video_time' => (int)$this->video_time,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')

        ];
    }
}
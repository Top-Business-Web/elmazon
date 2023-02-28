<?php

namespace App\Http\Resources;

use App\Models\VideoParts;
use App\Models\VideoWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VideoPartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){

        if($this->type == "video"){
            $link = asset('videos/'. $this->link);
        }elseif ($this->type == "audio"){

            $link = asset('audios/'. $this->link);
        }else{
            $link = asset('pdf/'. $this->link);
        }

        if($this->watch){
           $watched =  $this->watch->status == 'opened' || 'watched' ? 'opened' : 'closed';
        }else{
            $watched = 'lock';
        }
        return [
            'id' => $this->id,
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note ?? 'No notes',
            'link' => $link,
            'type' => $this->type,
            'ordered' => $this->ordered,
            'status' => $watched,
            'video_time' => (int)$this->video_time,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'exams' => OnlineExamResource::collection($this->exams),

        ];
    }
}

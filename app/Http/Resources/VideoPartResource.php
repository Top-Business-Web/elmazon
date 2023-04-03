<?php

namespace App\Http\Resources;

use App\Models\VideoParts;
use App\Models\VideoRate;
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

        $user_watch_video = VideoWatch::where('video_part_id','=',$this->id)->where('user_id','=',Auth::guard('user-api')->id())->first();

        $watched = "lock";
        if($user_watch_video){
        if($user_watch_video->status == 'opened' || 'watched'){
            $watched = 'opened';
        }
        }

        $video_rate = VideoRate::where('video_id','=',$this->id)->where('user_id','=',Auth::guard('user-api')->id())->first();
        if($video_rate){
            $rate = $video_rate->action;
        }else{
            $rate = "no_rate";
        }

        return [
            'id' => $this->id,
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note ?? 'No notes',
            'link' => $link,
            'type' => $this->type,
            'ordered' => $this->ordered,
            'status' => $watched,
            'rate' => $rate,
            'video_time' => (int)$this->video_time,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'exams' => OnlineExamResource::collection($this->exams),
        ];
    }
}

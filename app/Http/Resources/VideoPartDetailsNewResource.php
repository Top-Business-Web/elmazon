<?php

namespace App\Http\Resources;

use App\Models\VideoOpened;
use App\Models\VideoRate;
use App\Models\VideoWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VideoPartDetailsNewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){

        $user_watch_video = VideoOpened::where('video_part_id','=',$this->id)->where('user_id','=',Auth::guard('user-api')->id())->first();
        $video_rate = VideoRate::where('video_id','=',$this->id)->where('user_id','=',Auth::guard('user-api')->id())->first();
        $like_video_count = VideoRate::where('video_id','=',$this->id)->where('action','=','like')->count();

        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'status' => !$user_watch_video ? 'lock' :  ($user_watch_video->status == 'opened' ? 'opened': 'watched'),
             'subscribe' => 'access',
            'link' =>  asset('videos/'. $this->link),
            'time' => $this->video_time,
            'rate' =>  $video_rate ? $video_rate->action : 'no_rate',
            'total_watch' => (int)$this->video_watches->count(),
            'total_like' => (int)$like_video_count,
            'like_active' => $this->like_active,
            'view_active' => $this->view_active,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

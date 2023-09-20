<?php

namespace App\Http\Resources;

use App\Models\VideoOpened;
use App\Models\VideoRate;
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

        $user_watch_video = VideoOpened::query()
        ->where('video_part_id','=',$this->id)
            ->where('user_id','=',Auth::guard('user-api')->id())
            ->first();

        $video_rate = VideoRate::query()
        ->where('video_id','=',$this->id)
            ->where('user_id','=',Auth::guard('user-api')->id())
            ->first();

        $like_video_count = VideoRate::query()
        ->where('video_id','=',$this->id)
            ->where('action','=','like')
            ->count();


        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'status' => !$user_watch_video ? 'lock' :  ($user_watch_video->status == 'opened' ? 'opened': 'watched'),
            'subscribe' => 'access',
            'progress' =>  VideoOpened::where('video_part_id','=',$this->id)
                ->where('user_id','=',Auth::guard('user-api')->id())->exists() ? round((( strtotime($user_watch_video->minutes) - strtotime('TODAY')) / (strtotime( $this->video_time) - strtotime('TODAY'))) * 100 ,2) : 0,
            'link' =>  asset('videos/'. $this->link),
            'time' => (int)$this->video_time,
            'rate' =>  $video_rate ? $video_rate->action : 'no_rate',
            'total_watch' => (int)$this->video_watches->count(),
            'total_like' => (int)$like_video_count,
            'like_active' => $this->like_active,
            'video_minutes' => $this->video_time,
            'background_image' => asset('videos/images/'. $this->background_image),
            'view_active' => $this->view_active,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

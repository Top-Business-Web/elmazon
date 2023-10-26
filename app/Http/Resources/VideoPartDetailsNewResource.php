<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserSubscribe;
use App\Models\VideoOpened;
use App\Models\VideoParts;
use App\Models\VideoRate;
use App\Models\VideoTotalView;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VideoPartDetailsNewResource extends JsonResource
{

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

        $totalViews = VideoTotalView::query()
            ->where('video_part_id','=',$this->id)
            ->count();



        $sumMinutesOfVideo = VideoParts::query()
            ->where('id','=',$this->id)
            ->pluck('video_time')
            ->toArray();// example 130 seconds


        $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
            ->where('minutes','!=',null)
            ->where('video_part_id','=',$this->id)
            ->where('user_id', '=', Auth::guard('user-api')->id())
            ->pluck('minutes')
            ->toArray();//example 120 seconds


        $totalMinutesOfAllVideos = number_format(((getAllSecondsFromTimes($sumAllOfMinutesVideosStudentAuth) / getAllSecondsFromTimes($sumMinutesOfVideo)) * 100),2);


        //===================================================== Test Subscribe =========================================================



        $studentAuth = User::query()
            ->where('id','=',Auth::guard('user-api')->id())
            ->select('id','date_start_code','date_end_code')
            ->first();




        //===================================================== Test Subscribe =========================================================

        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'status' => !$user_watch_video ? 'lock' :  ($user_watch_video->status == 'opened' ? 'opened': 'watched'),
            'subscribe' => 'access',
            'progress' =>  !empty($sumAllOfMinutesVideosStudentAuth) ? $totalMinutesOfAllVideos : "0",
            'link' =>  $this->is_youtube == true ? $this->youtube_link :asset('videos/'. $this->link),
            'is_youtube' =>  $this->is_youtube,
            'rate' =>  $video_rate ? $video_rate->action : 'no_rate',
            'total_watch' =>   $totalViews,
            'total_like' =>   $like_video_count,
            'like_active' => $this->like_active,
            'video_minutes' => $this->video_time,
            'background_image' => $this->background_image != null ? asset('videos/images/'.$this->background_image) : asset('videos/images/default/default.png'),
            'view_active' => $this->view_active,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

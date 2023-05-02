<?php

namespace App\Http\Resources;

use App\Models\OpenLesson;
use App\Models\VideoParts;
use App\Models\VideoOpened;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LessonNewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $videos = VideoParts::where('lesson_id','=',$this->id)->pluck('id')->toArray();

        $totalWatch = VideoOpened::where([
            'user_id' => auth('user-api')->id(),
            'status' => 'watched'
        ])->whereIn('video_part_id',$videos)->count();


        $videos_count = VideoParts::where('lesson_id','=',$this->id)->count();
        return [

            'id' => $this->id,
            'background_color' => $this->background_color,
            'title' => lang() == 'ar' ?$this->title_ar : $this->title_en,
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'note' => $this->note,
            'status' => OpenLesson::where('user_id','=',Auth::guard('user-api')->id())->where('lesson_id','=',$this->id)->count() > 0 ? 'opened' : 'lock',
            'num_of_videos' => $videos_count,
            'total_watch' =>  $videos_count == 0 ? 0 : (int)number_format(($totalWatch / $videos_count) * 100,2),
            'total_times' => VideoParts::where('lesson_id','=',$this->id)->sum('video_time'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\OpenLesson;
use App\Models\SubjectClass;
use App\Models\VideoOpened;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SubjectClassNewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $totalWatch = VideoOpened::where([
             'user_id' => auth('user-api')->id(),
             'status' => 'watched'
        ])->count();


        return [

            'id' => $this->id,
            'status' => OpenLesson::where('user_id','=',Auth::guard('user-api')->id())
                ->where('subject_class_id','=',$this->id)->first() ? 'opened' : 'lock',
            'image' => $this->image == null ? asset('classes/default/def.jpg') : asset('classes/' . $this->image),
            'background_color' => $this->background_color,
            'title' => lang() == 'ar' ? $this->title_ar : $this->title_en,
            'name' => lang() == 'ar' ? $this->name_ar : $this->name_en,
            'total_watch' =>  $this->videos->count() == 0 ? 0 : (int)number_format(($totalWatch / $this->videos->count()) * 100,2),
            'num_of_lessons' => $this->lessons->count(),
            'num_of_videos' => $this->videos->count(),
            'total_times' => $this->videos->sum('video_time'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'exams' => OnlineExamNewResource::collection($this->exams),
        ];
    }
}

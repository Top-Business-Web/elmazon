<?php

namespace App\Http\Resources;

use App\Models\ExamsFavorite;
use App\Models\VideoRate;
use App\Models\VideoWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VideoUploadFileDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_watch_video = VideoWatch::where('video_upload_file_pdf_id','=',$this->id)->where('user_id','=',Auth::guard('user-api')->id())->first();

        //($user_watch_video->status == 'opened' ? 'opened': 'watched')
        return [

            'id' => $this->id,
            'name'  => lang() == 'ar' ? $this->name_ar : $this->name_en,
            'type' => $this->file_type,
            'background_color' => $this->background_color,
            'status' => !$user_watch_video ? 'lock' :  'watched',
            'subscribe' => 'access',
            'link' =>  asset('video_files/pdf/'. $this->file_link),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
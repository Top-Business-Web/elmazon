<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentReplayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'replay' => $this->comment,
            'audio' => $this->audio != null ? asset('comment_upload_file/'. $this->audio) : 'No audio',
            'image' => $this->image != null ? asset('comment_upload_file/'. $this->image) : 'No image',
            'type' => $this->type,
            'user_type' => $this->user_type,
            'student' => new UserResource($this->student),
             'teacher' => new AdminResource($this->teacher),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')


        ];
    }
}
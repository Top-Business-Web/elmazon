<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'email' => $this->email,
            'phone' => $this->phone,
            'father_phone' => $this->father_phone,
            'image' => $this->image != null ? asset('/users/'.$this->image) : asset('/default/avatar.jpg'),
            'user_status' => $this->user_status,
            'code' => $this->code,
            'date_start_code' => $this->date_start_code,
            'date_end_code' => $this->date_end_code,
            'token' => 'Bearer ' . $this->token,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d')

        ];
    }
}

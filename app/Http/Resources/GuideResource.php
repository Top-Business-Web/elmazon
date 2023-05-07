<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
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
            'title' => lang() == 'ar' ?$this->title_ar : $this->title_en,
            'color' => $this->color,
            'file_path' => $this->file != null ? asset('assets/uploads/guide/'.$this->file) : '',
            'file_path_size' => $this->file != null ? file_size(asset('assets/uploads/guide/'.$this->file)) : '',
            'description' => lang() == 'ar' ?$this->description_ar : $this->description_en,
            'created_at' => $this->created_at->format('Y-m-d'),
//            'inner_items' => GuideItemsResource::collection($this->childs)
        ];
    }
}

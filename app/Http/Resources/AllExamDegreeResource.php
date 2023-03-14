<?php

namespace App\Http\Resources;

use App\Models\Degree;
use Illuminate\Http\Resources\Json\JsonResource;

class AllExamDegreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $degree = Degree::where('user_id','=',auth()->id())->where('all_exam_id','=',$this->id)->groupBy('all_exam_id')->sum('degree');

        return [

            'id' => $this->id,
            'name' => lang() == 'ar' ?$this->name_ar : $this->name_en,
            'type' => 'all_exam',
            'degree' =>  (int)$degree . "/" . (int)$this->degree,
        ];
    }
}

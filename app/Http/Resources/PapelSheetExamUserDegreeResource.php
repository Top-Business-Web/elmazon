<?php

namespace App\Http\Resources;

use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use Illuminate\Http\Resources\Json\JsonResource;

class PapelSheetExamUserDegreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $papel_sheet = PapelSheetExam::where('id','=',$request->papel_sheet_id)->first();
        $degree = PapelSheetExamDegree::where('user_id','=',$this->id)->where('papel_sheet_exam_id','=',$request->papel_sheet_id)->first();
        return [

            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image != null ? asset('/users/'.$this->image) : asset('/default/avatar.jpg'),
            'percentage' => ((int)$degree->degree / (int)$papel_sheet->degree) * 100 . "%",
        ];
    }
}

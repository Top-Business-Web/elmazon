<?php

namespace App\Http\Resources;

use App\Models\MonthlyPlan;
use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){

        return [
            'id' => $this->id,
            'date' => $this->start,
            "plans" =>  MonthlyPlan::where('start','=',$this->start)->get(),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}

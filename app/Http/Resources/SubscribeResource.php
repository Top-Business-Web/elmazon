<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscribeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $months = array(
            "Jan" => "يناير",
            "Feb" => "فبراير",
            "Mar" => "مارس",
            "Apr" => "أبريل",
            "May" => "مايو",
            "Jun" => "يونيو",
            "Jul" => "يوليو",
            "Aug" => "أغسطس",
            "Sep" => "سبتمبر",
            "Oct" => "أكتوبر",
            "Nov" => "نوفمبر",
            "Dec" => "ديسمبر"
        );
        return [

            'id' => $this->id,
            'price' => (auth()->guard('user-api')->user()->center == 'in') ? $this->price_in_center :$this->price_out_center,
            'is_free' => $this->free,
            'month' => $this->month,
            'month_name_en' => date("F", mktime(0, 0, 0, $this->month, 10)),
            'month_name_ar' => $months[date("M", mktime(0, 0, 0, $this->month, 10))],
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}

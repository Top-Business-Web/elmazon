<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoResource extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
            'image' => 'image:required',
            'background_color' => 'required',
            'time' => 'required',
            'video_link' => 'nullable',
            'type' => 'required',
            'pdf_file' => 'nullable',
            'season_id' => 'required',
            'term_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'الاسم بالعربي مطلوب',
            'name_en.required' => 'الاسم بالانجليزي مطلوب',
            'image.image' => 'يجب ان تكون صورة',
            'image.required' => 'الصورة مطلوبة',
            'background_color.required' => 'اللون مطلوب',
            'time.required' => 'الوقت مطلوب',
            'type.required' => 'النوع مطلوب',
            'season_id.required' => 'الصف مطلوب',
            'term_id.required' => 'الترم مطلوب',
        ];
    }
}

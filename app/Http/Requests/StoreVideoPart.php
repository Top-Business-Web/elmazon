<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoPart extends FormRequest
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
            'lesson_id' => 'required',
            'link' => 'required|mimes:mp4',
            'video_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'link.mimes' => 'يجب ان يكون الملف فيديو',
        ];
    }
}

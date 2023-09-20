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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
            'lesson_id' => 'required',
            'link' => 'nullable|mimes:mp4',
            'youtube_link' => 'nullable',
            'video_time' => 'required|date_format:H:i:s',
        ];
    }

    public function messages(): array
    {
        return [
            'link.mimes' => 'يجب ان يكون الملف فيديو',
        ];
    }
}

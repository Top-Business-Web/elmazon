<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoBasicRequest extends FormRequest{

    public function authorize(): bool
    {
        return true;
    }


//    public function rules(): array
//    {
//        return [
//            'name_ar'          => 'required',
//            'name_en'          => 'required',
//            'background_color' => 'required',
//            'time'             => 'required|date_format:H:i:s',
//            'video_link'       => 'required',
//        ];
//    }
//    public function messages(): array
//    {
//        return [
//            'name_ar.required'          => 'الاسم بالعربي مطلوب',
//            'name_en.required'          => 'الاسم بالانجليزي مطلوب',
//            'background_color.required' => 'لون الخلفية مطلوب',
//            'time.required'             => 'وقت الفيديو مطلوب',
//            'video_link.required'       => 'لينك الفيديو مطلوب',
//        ];
//    }




    public function rules(): array
    {

        if (request()->isMethod('post')) {

            $rules = [
                'name_ar'          => 'required',
                'name_en'          => 'required',
                'background_color' => 'required',
                'time'             => 'required|date_format:H:i:s',
                'video_link'       => 'required',
            ];

        }elseif (request()->isMethod('PUT')) {

            $rules = [
                'name_ar'          => 'required',
                'name_en'          => 'required',
                'background_color' => 'required',
                'time'             => 'required|date_format:H:i:s',
                'video_link'       => 'nullable',
            ];
        }

        return $rules;
    }


    public function messages(): array
    {

        if (request()->isMethod('post')) {

            $messages = [
                'name_ar.required'          => 'الاسم بالعربي مطلوب',
                'name_en.required'          => 'الاسم بالانجليزي مطلوب',
                'background_color.required' => 'لون الخلفية مطلوب',
                'time.required'             => 'وقت الفيديو مطلوب',

            ];

        }elseif (request()->isMethod('PUT')) {

            $messages = [
                'name_ar.required'          => 'الاسم بالعربي مطلوب',
                'name_en.required'          => 'الاسم بالانجليزي مطلوب',
                'background_color.required' => 'لون الخلفية مطلوب',
                'time.required'             => 'وقت الفيديو مطلوب',

            ];
        }

        return $messages;
    }

}

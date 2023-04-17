<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ReportApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [

            'report' => 'required',
            'type' => 'required|in:video_part,video_basic,video_resource',
        ];
    }

    public function messages() : array
    {
        return [

            'report.required' => 'يرجي ادخال البلاغ او وصف المشكله',
            'type.required' => 'ادخل نوع الفيديو الذي يتم الابلاغ عنه',
            'type.in' => 'نوع الفيديو يجب ان يكون فيديو شرح اساسيات او فيديو مراجعه او فيديو شرح',
        ];
    }


}

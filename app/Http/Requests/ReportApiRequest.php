<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportApiRequest extends FormRequest
{

    public $video_part_id;
    public $video_basic_id;
    public $video_resource_id;
    public $type;
    public $report;

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
            'video_part_id' => 'nullable|integer|exists:video_parts,id',
            'video_basic_id' => 'nullable|integer|exists:video_basics,id',
            'video_resource_id' => 'nullable|integer|exists:video_resources,id',

        ];
    }

    public function messages() : array
    {
        return [

            'report.required' => 'يرجي ادخال البلاغ او وصف المشكله',
            'type.required' => 'ادخل نوع الفيديو الذي يتم الابلاغ عنه',
            'type.in' => 'نوع الفيديو يجب ان يكون فيديو شرح اساسيات او فيديو مراجعه او فيديو شرح',
            'video_part_id.integer' => 'يجب ادخال قيمه رقميه في حقل فيديو الشرح التابع له البلاغ',
            'video_basic_id.integer' => 'يجب ادخال قيمه رقميه في حقل فيديو الاساسيات التابع له البلاغ',
            'video_resource_id.integer' => 'يجب ادخال قيمه رقميه في حقل فيديو المراجعه التابع له البلاغ',
            'video_part_id.exists' => 'فيديو الشرح غير موجود',
            'video_basic_id.exists' => 'فيديو الاساسيات غير موجود',
            'video_resource_id.exists' => 'فيديو المراجعه غير موجود',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['data' => null, 'message' => $validator->errors()->first(), 'code' => 422]));
    }

}

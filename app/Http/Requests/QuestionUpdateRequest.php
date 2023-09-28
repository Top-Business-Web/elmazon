<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
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
            'question' => 'nullable',
            'difficulty' => 'required',
            'image' => 'nullable',
            'degree' => 'required|numeric',
            'note' => 'required',
            'season_id' => 'required',
            'term_id' => 'required',
            'examable_type' => 'required',
            'examable_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'difficulty.required' => 'مستوى الصعوبة مطلوب',
            'degree.required' => 'الدرجة مطلوبة',
            'note.required' => 'الملاحظة مطلوبة',
            'season_id.required' => 'الفصل مطلوب',
            'term_id.required' => 'الترم مطلوب',
            'examable_type.required' => 'نوع المثال مطلوب',
            'examable_id.required' => 'معرف المثال مطلوب'
        ];
    }
}

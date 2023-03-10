<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
//        dd(request()->all());
        return [
            'name' => 'required',
            'email' => "nullable",
            'password' => 'nullable',
            'season_id' => 'required',
            'country_id' => 'required',
            'phone' => 'required|unique:users,phone,'.$this->id,
            'father_phone' => 'required',
            'image' => 'nullable|image',
            'code' => 'required|unique:users,code,'.$this->id,
            'date_start_code' => 'required|date|before:date_end_code',
            'date_end_code' => 'required|date|after:date_start_code',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.unique' => 'هذا الرقم موجود من قبل',
            'code.unique' => 'هذا الكود موجود من قبل حاول مره اخري',
            'date_start_code.before' => 'ادخل تاريخ صحيح قبل تاربخ الانتهاء',
            'date_start_code.after' => 'ادخل تاريخ صحيح بعد تاربخ البداية',
        ];
    }
}

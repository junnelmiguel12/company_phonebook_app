<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_code' => ['required', 'min:3', 'max:50'],
            'company_name' => ['required', 'min:3', 'max:150']
        ];
    }

    public function messages()
    {
        return [
            'company_code.required' => 'Company code is required.',
            'company_code.min'      => "Company code is too short.",
            'company_code.max'      => "Company code is too long.",
            'company_name.required' => 'Company name is required.',
            'company_name.min'      => "Company name is too short.",
            'company_name.max'      => "Company name is too long.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $rules = [
            'name'             => ['required'],
            'email'            => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'password'         => ['required'],
            'confirm_password' => ['required', 'same:password']
        ];

        if (array_key_exists('first-user', $this->header()) === true) {
            $rules['company_code'] = ['required', 'min:3', 'max:50'];
            $rules['company_name'] = ['required', 'min:3', 'max:150'];
        } else {
            $rules['company_id'] = ['required', 'exists:companies,id,deleted_at,NULL'];
        }

        return $rules;
    }
}

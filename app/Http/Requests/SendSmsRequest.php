<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendSmsRequest extends FormRequest
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
            'message' => ['required', 'string', 'min:3', 'max:255'],
        ];

        if (array_key_exists('department_id', $this->request->all()) === true) {
            $rules['department_id'] = ['required', 'exists:departments,id,deleted_at,NULL'];
        } else {
            $rules['employee_list']   = ['required', 'array'];
            $rules['employee_list.*'] = ['required', 'integer'];
        }

        return $rules;
    }
}

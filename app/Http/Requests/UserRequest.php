<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'level_id' => 'required',
            'name' => ['required', 'string'],
            'username' => ['required', 'unique:users', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:6']
        ];
    }
}

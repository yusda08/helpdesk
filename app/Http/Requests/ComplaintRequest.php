<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
            'ticket_categories.*' => 'required|array',
            'ticket_title' => 'required',
            'ticket_desc' => 'required',
            'nip' => 'required',
            'employee_name' => 'required',
            'employee_position' => 'required',
            'employee_unit' => 'required',
            'employee_satker' => 'required',
            'unit_kerja_kode' => 'required',
        ];
    }
}

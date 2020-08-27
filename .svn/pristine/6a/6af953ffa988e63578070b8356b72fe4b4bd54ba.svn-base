<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePpRegRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kd_dept_pembuat' => 'required|max:2',
            'pemakai' => 'required|max:200',
            'untuk' => 'required|max:200',
            'alasan' => 'required|max:200',
            'kd_supp' => 'max:10',
            'email_supp' => 'email|max:100',
            'no_ia_ea' => 'max:25',
            'no_ia_ea_urut' => 'max:5',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEngtTpfc1Request extends FormRequest
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
            'kd_cust' => 'required|max:2',
            'kd_model' => 'required|max:40',
            'kd_line' => 'required|max:5',
            'st_pfc' => 'required|max:10', 
            'reg_doc_type' => 'required|max:50', 
        ];
    }
}

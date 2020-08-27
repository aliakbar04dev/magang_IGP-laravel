<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePpctDprPicaRequest extends FormRequest
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
            'no_dpr' => 'required|max:20',
            'pc_man' => 'max:500', 
            'pc_material' => 'max:500', 
            'pc_machine' => 'max:500', 
            'pc_metode' => 'max:500', 
            'pc_environ' => 'max:500', 
            'ta_ket' => 'max:500', 
            'ta_pict' => 'image|mimes:jpeg,png,jpg|max:8192', 
            'cm_ket' => 'max:500', 
            'cm_pict' => 'image|mimes:jpeg,png,jpg|max:8192', 
            'is_man' => 'max:500', 
            'is_material' => 'max:500', 
            'is_machine' => 'max:500', 
            'is_metode' => 'max:500', 
            'is_environ' => 'max:500', 
            'rem_ket' => 'max:500', 
            'rem_pict' => 'image|mimes:jpeg,png,jpg|max:8192', 
            'com_ket' => 'max:500', 
        ];
    }
}

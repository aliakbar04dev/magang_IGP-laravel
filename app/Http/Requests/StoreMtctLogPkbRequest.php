<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMtctLogPkbRequest extends FormRequest
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
            'kd_plant' => 'required|max:1',
            'kd_item' => 'required|max:17',
            'nm_brg' => 'max:50',
            'nm_type' => 'max:50',
            'nm_merk' => 'max:50',
            'qty' => 'required|numeric|min:0|max:9999999999',
            'kd_sat' => 'max:3',
            'ket_mesin_line' => 'max:50',
            'lok_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'dok_ref' => 'max:50',
            'no_dok' => 'max:50',
        ];
    }
}

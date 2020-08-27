<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePrctSsr1Request extends FormRequest
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
            'tgl_ssr' => 'required',
            'nm_model' => 'required|max:40',
            'nm_drawing' => 'max:50',
            'dd_quot' => 'required',
            'support_doc' => 'max:50',
            'tech_no' => 'max:50',
            'vol_prod_year' => 'required|numeric|min:0|max:9999999999.99999',
            'reason_of_req' => 'max:100',
            'start_maspro' => 'required',
            'subcont1' => 'max:50',
            'subcont2' => 'max:50',
            'subcont3' => 'max:50',
            'er_usd' => 'numeric|min:0|max:9999999999.99999',
            'er_jpy' => 'numeric|min:0|max:9999999999.99999',
            'er_thb' => 'numeric|min:0|max:9999999999.99999',
            'er_cny' => 'numeric|min:0|max:9999999999.99999',
            'er_krw' => 'numeric|min:0|max:9999999999.99999',
            'er_eur' => 'numeric|min:0|max:9999999999.99999',
        ];
    }
}

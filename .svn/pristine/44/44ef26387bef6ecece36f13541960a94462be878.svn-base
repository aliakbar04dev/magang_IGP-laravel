<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMtctDftMslhRequest extends FormRequest
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
            'tgl_dm' => 'required',
            'kd_plant' => 'required|max:1',
            'kd_line' => 'required|max:10',
            'kd_mesin' => 'required|max:20',
            'ket_prob' => 'required|max:500',
            'ket_cm' => 'max:500',
            'ket_sp' => 'max:500',
            'ket_eva_hasil' => 'max:500',
            'ket_remain' => 'max:500',
            'ket_remark' => 'max:500',
            'lok_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
        ];
    }
}

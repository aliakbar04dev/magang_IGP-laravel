<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMgmtGembaRequest extends FormRequest
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
            'tgl_gemba' => 'required',
            'kd_site' => 'required|max:4',
            'pict_gemba' => 'image|mimes:jpeg,png,jpg|max:8192',
            'det_gemba' => 'required|max:500',
            'kd_area' => 'required|max:10',
            'lokasi' => 'max:50',
            'npk_pic' => 'required|max:5',
        ];
    }
}

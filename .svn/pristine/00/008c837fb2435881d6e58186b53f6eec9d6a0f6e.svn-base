<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePpctDprRequest extends FormRequest
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
            'tgl_dpr' => 'required',
            'kd_site' => 'required|max:4',
            'kd_bpid' => 'required|max:9',
            'problem_st' => 'required|max:20',
            'problem_oth' => 'max:50',
            'problem_title' => 'required|max:100',
            'st_ls' => 'required|max:1',
            'jml_ls_menit' => 'numeric|min:0.1|max:9999999.99',
            'problem_ket' => 'required|max:2000',
            'problem_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'problem_std' => 'required|max:500',
            'problem_act' => 'required|max:500',
        ];
    }
}

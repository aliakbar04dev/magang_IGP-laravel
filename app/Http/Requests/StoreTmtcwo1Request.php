<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTmtcwo1Request extends FormRequest
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
            'tgl_wo' => 'required',
            'st_close' => 'required|max:1',
            'lok_pt' => 'required|max:1',
            'shift' => 'max:1',
            'kd_line' => 'required|max:10',
            'kd_mesin' => 'required|max:20',
            'uraian_prob' => 'max:250',
            'uraian_penyebab' => 'max:250',
            'langkah_kerja' => 'max:2000',
            'est_jamstart' => 'required',
            'est_jamend' => 'required',
            'est_durasi' => 'numeric|min:0|max:9999999',
            'line_stop' => 'numeric|required|min:0|max:99999',
            'info_kerja' => 'max:10',
            'nm_pelaksana' => 'max:500',
            'catatan' => 'max:250',
            'st_main_item' => 'max:1',
            'no_lhp' => 'max:23',
            'lok_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'no_ic' => 'numeric',
        ];
    }
}

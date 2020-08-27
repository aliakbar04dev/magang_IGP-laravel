<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBgttKomite1Request extends FormRequest
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
            'tgl_pengajuan' => 'required',
            'npk_presenter' => 'required|max:5',
            'topik' => 'required|max:200',
            'jns_komite' => 'required|max:5',
            'no_ie_ea' => 'max:20',
            'catatan' => 'max:200',
        ];
    }
}

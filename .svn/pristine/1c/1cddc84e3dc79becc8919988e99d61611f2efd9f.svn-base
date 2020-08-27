<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePpctDnclaimSj1Request extends FormRequest
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
            // 'tgl_certi' => 'required',
            'no_sj' => 'required|max:50',
            'tgl_sj' => 'required',
            'no_dn' => 'required|max:10',
        ];
    }
}

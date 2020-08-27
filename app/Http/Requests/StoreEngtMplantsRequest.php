<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEngtMplantsRequest extends FormRequest
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
            'kd_plant' => 'required|min:1|max:1',
            'nm_plant' => 'required|min:1|max:50',
            'kd_site' => 'required|min:1|max:4',
            'st_aktif' => 'required|min:1|max:1',
        ];
    }
}

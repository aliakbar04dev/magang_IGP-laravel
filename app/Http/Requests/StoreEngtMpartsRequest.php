<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEngtMpartsRequest extends FormRequest
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
            'part_no' => 'required|min:1|max:40',
            'nm_part' => 'max:150',
            'nm_material' => 'max:50',
            'kd_kat' => 'max:3',
            'kd_model' => 'max:40',
            'st_aktif' => 'required|min:1|max:1',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEngtMcustsRequest extends FormRequest
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
            'kd_cust' => 'required|min:1|max:2',
            'nm_cust' => 'required|min:1|max:60',
            'kd_bpid' => 'required|max:10',
            'inisial' => 'required|max:5',
            'alamat' => 'required|max:200',
            'st_aktif' => 'required|min:1|max:1',
        ];
    }
}

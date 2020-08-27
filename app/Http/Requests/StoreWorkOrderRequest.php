<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWorkOrderRequest extends FormRequest
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
            'kd_pt' => 'required|max:3',
            'ext' => 'required|max:5',
            'jenis_orders' => 'required|max:50',
            'detail_orders' => 'max:50',
            'id_hw' => 'max:20',
            'uraian' => 'required|max:500',
        ];
    }
}

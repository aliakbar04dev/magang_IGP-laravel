<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEngtMmesinsRequest extends FormRequest
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
            'kd_mesin' => 'required|min:1|max:20',
            'nm_mesin' => 'required|min:1|max:50',
            'nm_maker' => 'max:50',
            'mdl_type' => 'max:50',
            'nm_proses' => 'max:50',
            'no_asset' => 'max:30',
            'no_asset_acc' => 'max:50',
            'curr_perolehan' => 'max:10',
            'kd_line' => 'max:5',
            'st_aktif' => 'required|min:1|max:1',
        ];
    }
}

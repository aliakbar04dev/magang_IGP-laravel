<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMgmtGembaEhsRequest extends StoreMgmtGembaEhsRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['cm_pict'] = 'image|mimes:jpeg,png,jpg|max:8192';
        $rules['cm_ket'] = 'max:500';
        $rules['st_gemba'] = 'max:1';
        return $rules;
    }
}

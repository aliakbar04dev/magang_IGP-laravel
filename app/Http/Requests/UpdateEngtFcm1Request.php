<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEngtFcm1Request extends StoreEngtFcm1Request
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['pict_dim_position'] = 'image|mimes:jpeg,png,jpg|max:8192';
        return $rules;
    }
}

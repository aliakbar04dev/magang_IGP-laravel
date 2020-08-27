<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHrdtIdp1Request extends StoreHrdtIdp1Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

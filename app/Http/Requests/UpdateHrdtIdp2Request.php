<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHrdtIdp2Request extends StoreHrdtIdp2Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

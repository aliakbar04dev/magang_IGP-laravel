<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHrdtIdpdep2Request extends StoreHrdtIdpdep2Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

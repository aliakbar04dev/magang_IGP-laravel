<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEngtMpartsRequest extends StoreEngtMpartsRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

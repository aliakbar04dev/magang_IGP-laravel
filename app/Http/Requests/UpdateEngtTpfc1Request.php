<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEngtTpfc1Request extends StoreEngtTpfc1Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

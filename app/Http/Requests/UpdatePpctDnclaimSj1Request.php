<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpctDnclaimSj1Request extends StorePpctDnclaimSj1Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

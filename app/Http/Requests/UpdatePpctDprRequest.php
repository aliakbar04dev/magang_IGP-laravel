<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpctDprRequest extends StorePpctDprRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpctDprPicaRequest extends StorePpctDprPicaRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

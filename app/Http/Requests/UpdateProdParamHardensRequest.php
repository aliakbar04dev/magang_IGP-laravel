<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdParamHardensRequest extends StoreProdParamHardensRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}
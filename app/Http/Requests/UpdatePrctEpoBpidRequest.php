<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrctEpoBpidRequest extends StorePrctEpoBpidRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

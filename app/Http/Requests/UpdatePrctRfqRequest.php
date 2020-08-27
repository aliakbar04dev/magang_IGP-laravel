<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrctRfqRequest extends StorePrctRfqRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkOrderRequest extends StoreWorkOrderRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

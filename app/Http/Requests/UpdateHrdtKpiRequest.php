<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHrdtKpiRequest extends StoreHrdtKpiRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

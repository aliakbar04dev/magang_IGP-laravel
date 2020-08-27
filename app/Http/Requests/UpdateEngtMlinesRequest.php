<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEngtMlinesRequest extends StoreEngtMlinesRequest
{
    public function rules()    {
        
            $rules = parent::rules();
            return $rules;
    }
}

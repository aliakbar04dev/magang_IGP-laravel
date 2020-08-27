<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMtctIsiOli1Request extends StoreMtctIsiOli1Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

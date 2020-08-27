<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBgttCrKategorRequest extends StoreBgttCrKategorRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}


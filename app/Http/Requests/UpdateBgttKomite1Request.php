<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBgttKomite1Request extends StoreBgttKomite1Request
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

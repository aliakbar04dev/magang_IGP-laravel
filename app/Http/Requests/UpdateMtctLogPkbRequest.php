<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMtctLogPkbRequest extends StoreMtctLogPkbRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

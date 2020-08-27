<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMtctDftMslhRequest extends StoreMtctDftMslhRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

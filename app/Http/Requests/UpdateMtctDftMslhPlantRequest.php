<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMtctDftMslhPlantRequest extends StoreMtctDftMslhPlantRequest
{
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}

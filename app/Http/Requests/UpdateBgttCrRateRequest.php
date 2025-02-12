<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBgttCrRateRequest extends StoreBgttCrRateRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['thn_period'] = 'required|min:4|max:4|unique:bgtt_cr_rates,thn_period,' . base64_decode($this->route('bgttcrrate')) . ',thn_period';
        return $rules;
    }
}

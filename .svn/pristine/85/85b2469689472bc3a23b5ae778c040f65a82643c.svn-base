<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpRegRequest extends StorePpRegRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['no_reg'] = 'required|unique:pp_regs,no_reg,' . base64_decode($this->route('ppreg'));
        return $rules;
    }
}

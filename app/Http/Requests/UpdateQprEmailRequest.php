<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQprEmailRequest extends StoreQprEmailRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['kd_supp'] = 'required|max:10|unique:qpr_emails,kd_supp,' . base64_decode($this->route('qpremail'));
        return $rules;
    }
}

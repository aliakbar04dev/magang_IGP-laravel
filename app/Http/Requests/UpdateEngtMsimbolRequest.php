<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEngtMsimbolRequest extends StoreEngtMsimbolRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['ket'] = 'required|min:1|max:50|unique:engt_msimbols,ket,' . base64_decode($this->route('engtmsimbol'));
        $rules['lokfile'] = 'image|mimes:jpeg,png,jpg|max:8192';
        return $rules;
    }
}

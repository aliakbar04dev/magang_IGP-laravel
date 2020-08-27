<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePicaRequest extends StorePicaRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['no_pica'] = 'required|min:5|max:30|unique:picas,no_pica,' . base64_decode($this->route('pica'));
        $rules['issue_no'] = 'required|min:1|max:30|unique:picas,issue_no,' . base64_decode($this->route('pica'));
        return $rules;
    }
}

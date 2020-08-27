<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBgttCrKlasifiRequest extends StoreBgttCrKlasifiRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['nm_klasifikasi'] = 'required|max:15|unique:bgtt_cr_klasifis,nm_klasifikasi,' . base64_decode($this->route('bgttcrrate')) . ',nm_klasifikasi';
        return $rules;
    }
}

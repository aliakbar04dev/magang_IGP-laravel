<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEhsmWpPicRequest extends StoreEhsmWpPicRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['npk'] = 'required|min:5|max:5|unique:ehsm_wp_pics,npk,' . base64_decode($this->route('ehsmwppic'));
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends StoreRoleRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['name'] = 'required|max:255|unique:roles,name,' . base64_decode($this->route('role'));
        return $rules;
    }
}

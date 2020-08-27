<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends StorePermissionRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['name'] = 'required|max:255|unique:permissions,name,' . base64_decode($this->route('permission'));
        return $rules;
    }
}

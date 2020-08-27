<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends StoreUserRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['username'] = 'required|min:5|max:50|unique:users,username,' . base64_decode($this->route('user'));
        $rules['email'] = 'required|unique:users,email,' . base64_decode($this->route('user'));
        //$rules['init_supp'] = 'required|unique:users,init_supp,' . base64_decode($this->route('user'));
        $rules['telegram_id'] = 'max:50|unique:users,telegram_id,' . base64_decode($this->route('user'));
        return $rules;
    }
}

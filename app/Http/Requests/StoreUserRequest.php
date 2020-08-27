<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:50|unique:users',
            'email' => 'required|email|max:255|unique:users',
            //'init_supp' => 'required|max:10|unique:users',
            'init_supp' => 'required|max:10',
            //'rolename' => 'required|exists:roles,name',
            'rolename' => 'required',
            'status_active' => 'required|max:1',
            'no_hp' => 'max:15',
            'telegram_id' => 'max:50|unique:users',
        ];
    }

    //Custom messages
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'name tidak boleh kosong!',
    //     ];
    // }
}

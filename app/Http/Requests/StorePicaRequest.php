<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePicaRequest extends FormRequest
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
            'no_pica' => 'required|min:5|max:30|unique:picas',
            'issue_no' => 'required|min:1|max:30|unique:picas',
            'fp_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_tools_subject' => 'max:500',
            'iop_tools_pc' => 'max:500',
            'iop_tools_std' => 'max:500',
            'iop_tools_act' => 'max:500',
            'iop_tools_status' => 'max:1',
            'iop_tools_why_occured' => 'max:500',
            'iop_tools_pict_occured' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_tools_why_outflow' => 'max:500',
            'iop_tools_pict_outflow' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_tools_root1' => 'max:500',
            'iop_tools_root2' => 'max:500',
            'iop_mat_subject' => 'max:500',
            'iop_mat_pc' => 'max:500',
            'iop_mat_std' => 'max:500',
            'iop_mat_act' => 'max:500',
            'iop_mat_status' => 'max:1',
            'iop_mat_why_occured' => 'max:500',
            'iop_mat_pict_occured' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_mat_why_outflow' => 'max:500',
            'iop_mat_pict_outflow' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_mat_root1' => 'max:500',
            'iop_mat_root2' => 'max:500',
            'iop_man_subject' => 'max:500',
            'iop_man_pc' => 'max:500',
            'iop_man_std' => 'max:500',
            'iop_man_act' => 'max:500',
            'iop_man_status' => 'max:1',
            'iop_man_why_occured' => 'max:500',
            'iop_man_pict_occured' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_man_why_outflow' => 'max:500',
            'iop_man_pict_outflow' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_man_root1' => 'max:500',
            'iop_man_root2' => 'max:500',
            'iop_met_subject' => 'max:500',
            'iop_met_pc' => 'max:500',
            'iop_met_std' => 'max:500',
            'iop_met_act' => 'max:500',
            'iop_met_status' => 'max:1',
            'iop_met_why_occured' => 'max:500',
            'iop_met_pict_occured' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_met_why_outflow' => 'max:500',
            'iop_met_pict_outflow' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_met_root1' => 'max:500',
            'iop_met_root2' => 'max:500',
            'iop_env_subject' => 'max:500',
            'iop_env_pc' => 'max:500',
            'iop_env_std' => 'max:500',
            'iop_env_act' => 'max:500',
            'iop_env_status' => 'max:1',
            'iop_env_why_occured' => 'max:500',
            'iop_env_pict_occured' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_env_why_outflow' => 'max:500',
            'iop_env_pict_outflow' => 'image|mimes:jpeg,png,jpg|max:8192',
            'iop_env_root1' => 'max:500',
            'iop_env_root2' => 'max:500',
            'cop_temp_action1' => 'max:500',
            'cop_temp_action1_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_temp_action2' => 'max:500',
            'cop_temp_action2_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_temp_action3' => 'max:500',
            'cop_temp_action3_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_temp_action4' => 'max:500',
            'cop_temp_action4_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_temp_action4' => 'max:500',
            'cop_temp_action5_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_perm_action1' => 'max:500',
            'cop_perm_action1_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_perm_action2' => 'max:500',
            'cop_perm_action2_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_perm_action3' => 'max:500',
            'cop_perm_action3_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_perm_action4' => 'max:500',
            'cop_perm_action4_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'cop_perm_action4' => 'max:500',
            'cop_perm_action5_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'fp_improve_pict' => 'image|mimes:jpeg,png,jpg|max:8192',
            'evaluation' => 'max:500',
        ];
    }
}

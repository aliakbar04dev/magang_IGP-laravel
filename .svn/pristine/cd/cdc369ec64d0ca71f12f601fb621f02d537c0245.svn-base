<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEhstWp1Request extends FormRequest
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
            'tgl_wp' => 'required',
            'kd_site' => 'required|max:4',
            'status_po' => 'max:1',
            'no_pp' => 'max:13',
            'no_po' => 'max:20',
            'nm_proyek' => 'required|max:100',
            'lok_proyek' => 'required|max:100',
            'pic_pp' => 'max:50',
            'kat_kerja_ket' => 'max:50',
            'alat_pakai' => 'max:200',
            'nm_mp_1' => 'max:50', 'no_id_1' => 'max:20', 'ket_remarks_1' => 'max:50',
            'nm_mp_2' => 'max:50', 'no_id_2' => 'max:20', 'ket_remarks_2' => 'max:50',
            'nm_mp_3' => 'max:50', 'no_id_3' => 'max:20', 'ket_remarks_3' => 'max:50',
            'nm_mp_4' => 'max:50', 'no_id_4' => 'max:20', 'ket_remarks_4' => 'max:50',
            'nm_mp_5' => 'max:50', 'no_id_5' => 'max:20', 'ket_remarks_5' => 'max:50',
            'nm_mp_6' => 'max:50', 'no_id_6' => 'max:20', 'ket_remarks_6' => 'max:50',
            'nm_mp_7' => 'max:50', 'no_id_7' => 'max:20', 'ket_remarks_7' => 'max:50',
            'nm_mp_8' => 'max:50', 'no_id_8' => 'max:20', 'ket_remarks_8' => 'max:50',
            'nm_mp_9' => 'max:50', 'no_id_9' => 'max:20', 'ket_remarks_9' => 'max:50',
            'nm_mp_10' => 'max:50', 'no_id_10' => 'max:20', 'ket_remarks_10' => 'max:50',
            'nm_mp_11' => 'max:50', 'no_id_11' => 'max:20', 'ket_remarks_11' => 'max:50',
            'nm_mp_12' => 'max:50', 'no_id_12' => 'max:20', 'ket_remarks_12' => 'max:50',
            'nm_mp_13' => 'max:50', 'no_id_13' => 'max:20', 'ket_remarks_13' => 'max:50',
            'nm_mp_14' => 'max:50', 'no_id_14' => 'max:20', 'ket_remarks_14' => 'max:50',
            'nm_mp_15' => 'max:50', 'no_id_15' => 'max:20', 'ket_remarks_15' => 'max:50',
            'nm_mp_16' => 'max:50', 'no_id_16' => 'max:20', 'ket_remarks_16' => 'max:50',
            'nm_mp_17' => 'max:50', 'no_id_17' => 'max:20', 'ket_remarks_17' => 'max:50',
            'nm_mp_18' => 'max:50', 'no_id_18' => 'max:20', 'ket_remarks_18' => 'max:50',
            'nm_mp_19' => 'max:50', 'no_id_19' => 'max:20', 'ket_remarks_19' => 'max:50',
            'nm_mp_20' => 'max:50', 'no_id_20' => 'max:20', 'ket_remarks_20' => 'max:50',
            'ket_aktifitas_1' => 'max:100', 'ib_potensi_1' => 'max:200', 'ib_resiko_1' => 'max:200',  'pencegahan_1' => 'max:200', 
            'ket_aktifitas_2' => 'max:100', 'ib_potensi_2' => 'max:200', 'ib_resiko_2' => 'max:200', 'pencegahan_2' => 'max:200', 
            'ket_aktifitas_3' => 'max:100', 'ib_potensi_3' => 'max:200', 'ib_resiko_3' => 'max:200', 'pencegahan_3' => 'max:200', 
            'ket_aktifitas_4' => 'max:100', 'ib_potensi_4' => 'max:200', 'ib_resiko_4' => 'max:200', 'pencegahan_4' => 'max:200', 
            'ket_aktifitas_5' => 'max:100', 'ib_potensi_5' => 'max:200', 'ib_resiko_5' => 'max:200', 'pencegahan_5' => 'max:200', 
            'ket_aktifitas_6' => 'max:100', 'ib_potensi_6' => 'max:200', 'ib_resiko_6' => 'max:200', 'pencegahan_6' => 'max:200', 
            'ket_aktifitas_7' => 'max:100', 'ib_potensi_7' => 'max:200', 'ib_resiko_7' => 'max:200', 'pencegahan_7' => 'max:200', 
            'ket_aktifitas_8' => 'max:100', 'ib_potensi_8' => 'max:200', 'ib_resiko_8' => 'max:200', 'pencegahan_8' => 'max:200', 
            'ket_aktifitas_9' => 'max:100', 'ib_potensi_9' => 'max:200', 'ib_resiko_9' => 'max:200', 'pencegahan_9' => 'max:200', 
            'ket_aktifitas_10' => 'max:100', 'ib_potensi_10' => 'max:200', 'ib_resiko_10' => 'max:200', 'pencegahan_10' => 'max:200', 
            'ket_aktifitas_env_1' => 'max:100', 'ket_aspek_1' => 'max:200', 'ket_dampak_1' => 'max:200',  'pencegahan_env_1' => 'max:200', 
            'ket_aktifitas_env_2' => 'max:100', 'ket_aspek_2' => 'max:200', 'ket_dampak_2' => 'max:200', 'pencegahan_env_2' => 'max:200', 
            'ket_aktifitas_env_3' => 'max:100', 'ket_aspek_3' => 'max:200', 'ket_dampak_3' => 'max:200', 'pencegahan_env_3' => 'max:200', 
            'ket_aktifitas_env_4' => 'max:100', 'ket_aspek_4' => 'max:200', 'ket_dampak_4' => 'max:200', 'pencegahan_env_4' => 'max:200', 
            'ket_aktifitas_env_5' => 'max:100', 'ket_aspek_5' => 'max:200', 'ket_dampak_5' => 'max:200', 'pencegahan_env_5' => 'max:200', 
            'ket_aktifitas_env_6' => 'max:100', 'ket_aspek_6' => 'max:200', 'ket_dampak_6' => 'max:200', 'pencegahan_env_6' => 'max:200', 
            'ket_aktifitas_env_7' => 'max:100', 'ket_aspek_7' => 'max:200', 'ket_dampak_7' => 'max:200', 'pencegahan_env_7' => 'max:200', 
            'ket_aktifitas_env_8' => 'max:100', 'ket_aspek_8' => 'max:200', 'ket_dampak_8' => 'max:200', 'pencegahan_env_8' => 'max:200', 
            'ket_aktifitas_env_9' => 'max:100', 'ket_aspek_9' => 'max:200', 'ket_dampak_9' => 'max:200', 'pencegahan_env_9' => 'max:200', 
            'ket_aktifitas_env_10' => 'max:100', 'ket_aspek_10' => 'max:200', 'ket_dampak_10' => 'max:200', 'pencegahan_env_10' => 'max:200', 
        ];
    }
}

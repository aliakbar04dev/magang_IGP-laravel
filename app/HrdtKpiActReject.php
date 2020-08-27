<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtKpiActReject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_kpi_reject_id', 'kd_item', 'activity', 'kpi_ref', 'target_q1', 'tgl_start_q1', 'tgl_finish_q1', 'target_q1_2', 'tgl_start_q1_2', 'tgl_finish_q1_2', 'target_q2', 'tgl_start_q2', 'tgl_finish_q2', 'target_q1_3', 'tgl_start_q1_3', 'tgl_finish_q1_3', 'target_q2_3', 'tgl_start_q2_3', 'tgl_finish_q2_3', 'target_q3', 'tgl_start_q3', 'tgl_finish_q3', 'target_q1_4', 'tgl_start_q1_4', 'tgl_finish_q1_4', 'target_q2_4', 'tgl_start_q2_4', 'tgl_finish_q2_4', 'target_q3_4', 'tgl_start_q3_4', 'tgl_finish_q3_4', 'target_q4', 'tgl_start_q4', 'tgl_finish_q4', 'target_q1_act', 'tgl_start_q1_act', 'tgl_finish_q1_act', 'persen_q1', 'problem_q1', 'target_q1_2_act', 'tgl_start_q1_2_act', 'tgl_finish_q1_2_act', 'persen_q1_2', 'problem_q1_2', 'target_q2_act', 'tgl_start_q2_act', 'tgl_finish_q2_act', 'persen_q2', 'problem_q2', 'target_q1_3_act', 'tgl_start_q1_3_act', 'tgl_finish_q1_3_act', 'persen_q1_3', 'problem_q1_3', 'target_q2_3_act', 'tgl_start_q2_3_act', 'tgl_finish_q2_3_act', 'persen_q2_3', 'problem_q2_3', 'target_q3_act', 'tgl_start_q3_act', 'tgl_finish_q3_act', 'persen_q3', 'problem_q3', 'target_q1_4_act', 'tgl_start_q1_4_act', 'tgl_finish_q1_4_act', 'persen_q1_4', 'problem_q1_4', 'target_q2_4_act', 'tgl_start_q2_4_act', 'tgl_finish_q2_4_act', 'persen_q2_4', 'problem_q2_4', 'target_q3_4_act', 'tgl_start_q3_4_act', 'tgl_finish_q3_4_act', 'persen_q3_4', 'problem_q3_4', 'target_q4_act', 'tgl_start_q4_act', 'tgl_finish_q4_act', 'persen_q4', 'problem_q4', 'weight', 'keterangan', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public function hrdtKpiReject() {
		return $this->belongsTo('App\HrdtKpiReject');
	}

	public function hrdtKpiDepRejects() {
		return $this->hasMany('App\HrdtKpiDepReject');
	}

    public function getDepartemenAttribute()
    {
        $departemens = [];
        $hrdtkpideps = $this->hrdtKpiDepRejects()->where("status", "=", "I")->get();
        foreach ($hrdtkpideps as $hrdtkpidep) {
            array_push($departemens, $hrdtkpidep->kd_dep);
        }
        return $departemens;
    }

    public function getDepartemen2Attribute()
    {
        $departemens = [];
        $hrdtkpideps = $this->hrdtKpiDepRejects()->where("status", "=", "E")->get();
        foreach ($hrdtkpideps as $hrdtkpidep) {
            array_push($departemens, $hrdtkpidep->kd_dep);
        }
        return $departemens;
    }

	public function getKpiRefDescAttribute()
    {
        $kpi_ref_desc = "-";
        $kpi_ref = DB::table("hrdm_kpi_refs")
            ->select(DB::raw("strategy_priority, strategy, coy_kpi, target, initiatives, div, due_date, id"))
            ->where("id", "=", $this->kpi_ref)
            ->first();
        if($kpi_ref != null) {
            $kpi_ref_desc = "Strategy Priority: ".$kpi_ref->strategy_priority."\nStrategy: ".$kpi_ref->strategy."\nCOY KPI: ".$kpi_ref->coy_kpi."\nTarget: ".$kpi_ref->target."\nInitiatives: ".$kpi_ref->initiatives."\nDIV: ".$kpi_ref->div."\nDue Date: ".$kpi_ref->due_date;
        }
        return $kpi_ref_desc;
    }

    public function getKpiRefDesc2Attribute()
    {
        $kpi_ref_desc = "-";
        $kpi_ref = DB::table("hrdm_kpi_refs")
            ->select(DB::raw("strategy_priority, strategy, coy_kpi, target, initiatives, div, due_date, id"))
            ->where("id", "=", $this->kpi_ref)
            ->first();
        if($kpi_ref != null) {
            $kpi_ref_desc = "Strategy Priority: ".$kpi_ref->strategy_priority."<BR>Strategy: ".$kpi_ref->strategy."<BR>COY KPI: ".$kpi_ref->coy_kpi."<BR>Target: ".$kpi_ref->target."<BR>Initiatives: ".$kpi_ref->initiatives."<BR>DIV: ".$kpi_ref->div."<BR>Due Date: ".$kpi_ref->due_date;
        }
        return $kpi_ref_desc;
    }

	public function getTotalWeightAttribute()
    {
    	return HrdtKpiActReject::where('hrdt_kpi_reject_id', $this->hrdt_kpi_reject_id)->sum('weight');
    }

	public function getKetItemAttribute()
    {
        $ket_item = "-";
        if($this->kd_item != null) {
            if($this->kd_item === "FP") {
                $ket_item = "FINANCIAL PERFORMANCE";
            } else if($this->kd_item === "CS") {
                $ket_item = "CUSTOMER";
            } else if($this->kd_item === "IP") {
                $ket_item = "INTERNAL PROCESS";
            } else if($this->kd_item === "LG") {
                $ket_item = "LEARNING & GROWTH";
            } else if($this->kd_item === "CR") {
                $ket_item = "COMPLIANCE REPORTING";
            }
        }
        return $ket_item;
    }
}

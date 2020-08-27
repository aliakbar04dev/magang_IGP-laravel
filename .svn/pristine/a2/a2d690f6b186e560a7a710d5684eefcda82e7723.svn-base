<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtKpiAct extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_kpi_id', 'kd_item', 'activity', 'kpi_ref', 'target_q1', 'tgl_start_q1', 'tgl_finish_q1', 'target_q1_2', 'tgl_start_q1_2', 'tgl_finish_q1_2', 'target_q2', 'tgl_start_q2', 'tgl_finish_q2', 'target_q1_3', 'tgl_start_q1_3', 'tgl_finish_q1_3', 'target_q2_3', 'tgl_start_q2_3', 'tgl_finish_q2_3', 'target_q3', 'tgl_start_q3', 'tgl_finish_q3', 'target_q1_4', 'tgl_start_q1_4', 'tgl_finish_q1_4', 'target_q2_4', 'tgl_start_q2_4', 'tgl_finish_q2_4', 'target_q3_4', 'tgl_start_q3_4', 'tgl_finish_q3_4', 'target_q4', 'tgl_start_q4', 'tgl_finish_q4', 'target_q1_act', 'tgl_start_q1_act', 'tgl_finish_q1_act', 'persen_q1', 'problem_q1', 'target_q1_2_act', 'tgl_start_q1_2_act', 'tgl_finish_q1_2_act', 'persen_q1_2', 'problem_q1_2', 'target_q2_act', 'tgl_start_q2_act', 'tgl_finish_q2_act', 'persen_q2', 'problem_q2', 'target_q1_3_act', 'tgl_start_q1_3_act', 'tgl_finish_q1_3_act', 'persen_q1_3', 'problem_q1_3', 'target_q2_3_act', 'tgl_start_q2_3_act', 'tgl_finish_q2_3_act', 'persen_q2_3', 'problem_q2_3', 'target_q3_act', 'tgl_start_q3_act', 'tgl_finish_q3_act', 'persen_q3', 'problem_q3', 'target_q1_4_act', 'tgl_start_q1_4_act', 'tgl_finish_q1_4_act', 'persen_q1_4', 'problem_q1_4', 'target_q2_4_act', 'tgl_start_q2_4_act', 'tgl_finish_q2_4_act', 'persen_q2_4', 'problem_q2_4', 'target_q3_4_act', 'tgl_start_q3_4_act', 'tgl_finish_q3_4_act', 'persen_q3_4', 'problem_q3_4', 'target_q4_act', 'tgl_start_q4_act', 'tgl_finish_q4_act', 'persen_q4', 'problem_q4', 'weight', 'keterangan', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtkpiact) {
            $hrdtkpi = $hrdtkpiact->hrdtKpi()->first();
			if($hrdtkpi->checkEdit() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat diubah."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
        });

		self::deleting(function($hrdtkpiact) {
			$hrdtkpi = $hrdtkpiact->hrdtKpi()->first();
			if($hrdtkpi->checkDelete() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat dihapus."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
		});
	}

	public function hrdtKpi() {
		return $this->belongsTo('App\HrdtKpi');
	}

	public function hrdtKpiDeps() {
		return $this->hasMany('App\HrdtKpiDep');
	}

    public function getDepartemenAttribute()
    {
        $departemens = [];
        $hrdtkpideps = $this->hrdtKpiDeps()->where("status", "=", "I")->get();
        foreach ($hrdtkpideps as $hrdtkpidep) {
            array_push($departemens, $hrdtkpidep->kd_dep);
        }
        return $departemens;
    }

    public function getDepartemen2Attribute()
    {
        $departemens = [];
        $hrdtkpideps = $this->hrdtKpiDeps()->where("status", "=", "E")->get();
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
    	return HrdtKpiAct::where('hrdt_kpi_id', $this->hrdt_kpi_id)->sum('weight');
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

    public function getJmlTargetAttribute()
    {
        $jml_target = 0;
        if(!empty($this->target_q1)) {
            $jml_target = $jml_target + 1;
        }
        if(!empty($this->target_q2)) {
            $jml_target = $jml_target + 1;
        }
        if(!empty($this->target_q3)) {
            $jml_target = $jml_target + 1;
        }
        if(!empty($this->target_q4)) {
            $jml_target = $jml_target + 1;
        }
        $jml_target = 4;
        return $jml_target;
    }

    public function getStatusTgl1Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q1;
        $due_date = $this->tgl_finish_q1;
        $act_date = $this->tgl_finish_q1_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
        }
        return $bgcolor;
    }

    public function getStatusTgl2Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q2;
        $due_date = $this->tgl_finish_q2;
        $act_date = $this->tgl_finish_q2_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
        }
        return $bgcolor;
    }

    public function getStatusTgl3Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q3;
        $due_date = $this->tgl_finish_q3;
        $act_date = $this->tgl_finish_q3_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
        }
        return $bgcolor;
    }

    public function getStatusTgl4Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q4;
        $due_date = $this->tgl_finish_q4;
        $act_date = $this->tgl_finish_q4_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
        }
        return $bgcolor;
    }

    public function getStatusPersen1Attribute()
    {
        $status_persen = null;
        $target = $this->target_q1;
        $persen = $this->persen_q1;
        if(!empty($target)) {
            if($persen > 80) {
                $status_persen = "images/green_16.png";
            } else if($persen > 60 && $persen <= 80) {
                $status_persen = "images/yellow_16.png";
            } else {
                $status_persen = "images/red_16.png";
            }
        }
        return $status_persen;
    }

    public function getStatusPersen2Attribute()
    {
        $status_persen = null;
        $target = $this->target_q2;
        $persen = $this->persen_q2;
        if(!empty($target)) {
            if($persen > 80) {
                $status_persen = "images/green_16.png";
            } else if($persen > 60 && $persen <= 80) {
                $status_persen = "images/yellow_16.png";
            } else {
                $status_persen = "images/red_16.png";
            }
        }
        return $status_persen;
    }

    public function getStatusPersen3Attribute()
    {
        $status_persen = null;
        $target = $this->target_q3;
        $persen = $this->persen_q3;
        if(!empty($target)) {
            if($persen > 80) {
                $status_persen = "images/green_16.png";
            } else if($persen > 60 && $persen <= 80) {
                $status_persen = "images/yellow_16.png";
            } else {
                $status_persen = "images/red_16.png";
            }
        }
        return $status_persen;
    }

    public function getStatusPersen4Attribute()
    {
        $status_persen = null;
        $target = $this->target_q4;
        $persen = $this->persen_q4;
        if(!empty($target)) {
            if($persen > 80) {
                $status_persen = "images/green_16.png";
            } else if($persen > 60 && $persen <= 80) {
                $status_persen = "images/yellow_16.png";
            } else {
                $status_persen = "images/red_16.png";
            }
        }
        return $status_persen;
    }

    public function getWarnaPersen1Attribute()
    {
        $color = "grey";
        $target = $this->target_q1;
        $persen = $this->persen_q1;
        if(!empty($target)) {
            if($persen > 80) {
                $color = "green";
            } else if($persen > 60 && $persen <= 80) {
                $color = "yellow";
            } else {
                $color = "red";
            }
        }
        return $color;
    }

    public function getWarnaPersen2Attribute()
    {
        $color = "grey";
        $target = $this->target_q2;
        $persen = $this->persen_q2;
        if(!empty($target)) {
            if($persen > 80) {
                $color = "green";
            } else if($persen > 60 && $persen <= 80) {
                $color = "yellow";
            } else {
                $color = "red";
            }
        }
        return $color;
    }

    public function getWarnaPersen3Attribute()
    {
        $color = "grey";
        $target = $this->target_q3;
        $persen = $this->persen_q3;
        if(!empty($target)) {
            if($persen > 80) {
                $color = "green";
            } else if($persen > 60 && $persen <= 80) {
                $color = "yellow";
            } else {
                $color = "red";
            }
        }
        return $color;
    }

    public function getWarnaPersen4Attribute()
    {
        $color = "grey";
        $target = $this->target_q4;
        $persen = $this->persen_q4;
        if(!empty($target)) {
            if($persen > 80) {
                $color = "green";
            } else if($persen > 60 && $persen <= 80) {
                $color = "yellow";
            } else {
                $color = "red";
            }
        }
        return $color;
    }

    public function getTooltip1Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q1;
        $due_date = $this->tgl_finish_q1;
        $act_date = $this->tgl_finish_q1_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
            $html = "Due Date: ".Carbon::parse($due_date)->format('d/m/Y')."<br>";
            $html .= "Act Date: ".Carbon::parse($act_date)->format('d/m/Y')."<br>";
            $html .= "Act Target: ".$this->target_q1_act;
            return $html;
        } else {
            return "Tidak ada target.";
        }
    }

    public function getTooltip2Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q2;
        $due_date = $this->tgl_finish_q2;
        $act_date = $this->tgl_finish_q2_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
            $html = "Due Date: ".Carbon::parse($due_date)->format('d/m/Y')."<br>";
            $html .= "Act Date: ".Carbon::parse($act_date)->format('d/m/Y')."<br>";
            $html .= "Act Target: ".$this->target_q2_act;
            return $html;
        } else {
            return "Tidak ada target.";
        }
    }

    public function getTooltip3Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q3;
        $due_date = $this->tgl_finish_q3;
        $act_date = $this->tgl_finish_q3_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
            $html = "Due Date: ".Carbon::parse($due_date)->format('d/m/Y')."<br>";
            $html .= "Act Date: ".Carbon::parse($act_date)->format('d/m/Y')."<br>";
            $html .= "Act Target: ".$this->target_q3_act;
            return $html;
        } else {
            return "Tidak ada target.";
        }
    }

    public function getTooltip4Attribute()
    {
        $bgcolor = null;
        $target = $this->target_q4;
        $due_date = $this->tgl_finish_q4;
        $act_date = $this->tgl_finish_q4_act;
        if(empty($act_date)) {
            $act_date = Carbon::now();
        }
        if(!empty($target)) {
            if(!empty($due_date) && !empty($act_date)) {
                if(Carbon::parse($act_date)->format('Ymd') > Carbon::parse($due_date)->format('Ymd')) {
                    $bgcolor = "red";
                }
            }
            $html = "Due Date: ".Carbon::parse($due_date)->format('d/m/Y')."<br>";
            $html .= "Act Date: ".Carbon::parse($act_date)->format('d/m/Y')."<br>";
            $html .= "Act Target: ".$this->target_q4_act;
            return $html;
        } else {
            return "Tidak ada target.";
        }
    }
}

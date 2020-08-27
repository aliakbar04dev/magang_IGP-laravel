<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaanPo2Reject extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'no_po', 'no_revisi', 'pono_po', 'no_pp', 'pono_pp', 'item_no', 'item_name', 'qty_po', 'unit', 'hrg_unit', 'no_acc', 'dim1', 'dim2', 'dim3', 'dim4', 'dim5', 'clyn', 'cwar', 'cpay', 'kd_cvat', 
    ];
}

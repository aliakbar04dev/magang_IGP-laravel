<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BgttCrKategor extends Model
{
    protected $fillable = [
        'nm_klasifikasi', 'nm_kategori', 'st_aktif', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];
}

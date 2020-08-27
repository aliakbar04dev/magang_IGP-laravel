<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use App\User;

class SyncsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can(['user-create'])) {
            return view('sync.index');
        } else {
            return view('errors.403');
        }
    }

	public function satu($param1)
    {
    	$param1 = base64_decode($param1);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }

    public function dua($param1, $param2)
    {
    	$param1 = base64_decode($param1);
    	$param2 = base64_decode($param2);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }

    public function tiga($param1, $param2, $param3)
    {
    	$param1 = base64_decode($param1);
    	$param2 = base64_decode($param2);
    	$param3 = base64_decode($param3);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2 $param3");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2 $param3");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }

    public function empat($param1, $param2, $param3, $param4)
    {
    	$param1 = base64_decode($param1);
    	$param2 = base64_decode($param2);
    	$param3 = base64_decode($param3);
    	$param4 = base64_decode($param4);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2 $param3 $param4");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2 $param3 $param4");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }

    public function lima($param1, $param2, $param3, $param4, $param5)
    {
    	$param1 = base64_decode($param1);
    	$param2 = base64_decode($param2);
    	$param3 = base64_decode($param3);
    	$param4 = base64_decode($param4);
    	$param5 = base64_decode($param5);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2 $param3 $param4 $param5");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2 $param3 $param4 $param5");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }

    public function enam($param1, $param2, $param3, $param4, $param5, $param6)
    {
    	$param1 = base64_decode($param1);
    	$param2 = base64_decode($param2);
    	$param3 = base64_decode($param3);
    	$param4 = base64_decode($param4);
    	$param5 = base64_decode($param5);
    	$param6 = base64_decode($param6);
        if(config('app.env', 'local') === 'production') {
            $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2 $param3 $param4 $param5 $param6");
        } else {
            $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2 $param3 $param4 $param5 $param6");
        }
        if (strpos($output, "BERHASIL") === false) {
        	$level = "danger";
        } else {
        	$level = "success";
        }
        Session::flash("flash_notification", [
            "level"=>$level,
            "message"=>$output
        ]);
        return redirect()->back();
    }
}

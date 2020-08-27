<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hash;

class UserShouldActived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        $response = $next($request);
        if (Auth::check()) {
            $valid = "T";
            $msg = "";
            $level = "warning";
            if(Auth::user()->status_active !== 'T') {
                $valid = "F";
                $msg = "Akun Anda sudah tidak aktif. Silahkan hubungi Administrator ".config('app.name', 'Laravel')." untuk info lebih lanjut.";
            } else {
                if(config('app.env', 'local') === 'production') {
                    if(Hash::check(Auth::user()->username, Auth::user()->password)) {
                        $valid = "F";
                        $msg = "Akun Anda menggunakan password yang sama dengan username. Silahkan kunjungi <a href=".url('password/reset').">Reset Password</a> dan masukan email Anda atau hubungi Administrator ".config('app.name', 'Laravel')." untuk info lebih lanjut.";
                    }
                }
            }

            if(strlen(Auth::user()->username) == 5 && $valid === "T") {
                if(Auth::user()->masKaryawan() != null) {
                    if(Auth::user()->masKaryawan()->tgl_keluar != null) {
                        $valid = "F";
                        $msg = "Akun Anda sudah keluar. Silahkan hubungi Administrator ".config('app.name', 'Laravel')." untuk info lebih lanjut.";
                        $level = "danger";
                    }
                } else {
                    $valid = "F";
                    $msg = "Akun Anda sudah keluar. Silahkan hubungi Administrator ".config('app.name', 'Laravel')." untuk info lebih lanjut.";
                    $level = "danger";
                }
            }
            
            if($valid === "F") {
                Auth::logout();
                Session::flash("flash_notification", [
                    "level" => $level,
                    "message" => $msg
                ]);
                return redirect('/login');
            } else if(config('app.env', 'local') === 'production') {
                if(strlen(Auth::user()->username) == 5) {
                    if(config('app.url', 'https://vendor.igp-astra.co.id') === 'https://vendor.igp-astra.co.id') {
                        Session::flash("sweet_alert", [
                            "type"=>"info",
                            "title"=>"FYI",
                            "text"=>"Anda bisa juga mengakses portal melalui https://iaess.igp-astra.co.id (khusus internal)",
                            // "timer"=>2000,
                            // "showConfirmButton"=>true
                        ]);
                    }
                } else if(strlen(Auth::user()->username) > 5) {
                    if(config('app.url', 'https://iaess.igp-astra.co.id') === 'https://iaess.igp-astra.co.id') {
                        // Session::flash("sweet_alert", [
                        //     "type"=>"info",
                        //     "title"=>"FYI",
                        //     "text"=>"Anda bisa juga mengakses portal melalui https://vendor.igp-astra.co.id (khusus supplier)",
                        //     // "timer"=>2000,
                        //     // "showConfirmButton"=>true
                        // ]);
                        
                        $valid = "F";
                        $msg = "Mohon maaf, untuk saat ini silahkan mengakses portal melalui https://vendor.igp-astra.co.id (khusus supplier)";
                        $level = "danger";
                        Auth::logout();
                        Session::flash("flash_notification", [
                            "level" => $level,
                            "message" => $msg
                            ]);
                        return redirect('/login');
                    }
                }
            }
        }
        return $response;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserShouldVerified
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
            if(!Auth::user()->is_verified) {
                $link = url('auth/send-verification').'?email='.urlencode(Auth::user()->email);
                Auth::logout();

                Session::flash("flash_notification", [
                    "level" => "warning",
                    "message" => "Akun Anda belum aktif. Silahkan klik pada link aktivasi yang telah kami kirim. <a class='alert-link' href='$link'>Kirim lagi</a>."
                ]);

                return redirect('/login');
            } else if(strlen(Auth::user()->username) == 5 && config('app.env', 'local') === 'production') {
                $email = Auth::user()->email;
                $email_1 = Auth::user()->username."@igp-astra.co.id";
                $email_2 = Auth::user()->username."@gkd-astra.co.id";
                $email_3 = Auth::user()->username."@asanogear.co.id";

                if($email === $email_1 || $email === $email_2 || $email === $email_3) {
                    Session::flash("flash_notification", [
                        "level" => "warning",
                        "message" => "Email tidak boleh ".$email.". Mohon update data email Anda. Jika tidak mempunyai email kantor, silahkan menggunakan email pribadi. Terima Kasih."
                    ]);
                    return redirect('/settings/profile/edit');
                }
            }
        }
        return $response;
    }
}

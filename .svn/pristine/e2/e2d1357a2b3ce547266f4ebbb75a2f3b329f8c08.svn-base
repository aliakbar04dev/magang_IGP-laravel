<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Exception;

class LogLastLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $client_ip = \Request::ip();
        try {
            $json_ip = json_decode(file_get_contents("https://api.ipify.org?format=json"), true);
            $client_ip = $json_ip['ip']." / ".\Request::ip();
        } catch (Exception $ex) {
            
        }
        session(['client_ip' => $client_ip]);
        
        $user = $event->user;
        $user->last_login = new \DateTime;
        $user->last_login_ip = \Request::session()->get('client_ip');
        $user->save();
    }
}

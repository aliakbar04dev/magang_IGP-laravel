<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        // $this->middleware('auth');
        $this->middleware('user-should-verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    public function registration(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:5|max:5|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users', 
            'password' => 'required|min:6|confirmed',
            'tgl_lahir' => 'required',
            'tgl_masuk' => 'required',
        ]);

        DB::connection("pgsql")->beginTransaction();
        try {

            $data = $request->all();
            $username = strtolower($data['username']);
            $name = strtoupper($data['name']);
            $password = $data['password'];
            $email = strtolower($data['email']);
            $tgl_lahir = Carbon::parse($data['tgl_lahir']);
            $tgl_masuk = Carbon::parse($data['tgl_masuk']);

            if($username == $password) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Password tidak boleh sama dengan NPK!"
                    ]);
                return redirect()->back()->withInput(Input::all());
            } else {
                $v_mas_karyawan = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, tgl_masuk_gkd, tgl_lahir"))
                ->whereNull('tgl_keluar')
                ->where("npk", "=", $username)
                ->first();

                if($v_mas_karyawan == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"NPK tidak valid!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    if($tgl_lahir->format('Ymd') != Carbon::parse($v_mas_karyawan->tgl_lahir)->format('Ymd')) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Tgl Lahir tidak valid!"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    } else if($tgl_masuk->format('Ymd') != Carbon::parse($v_mas_karyawan->tgl_masuk_gkd)->format('Ymd')) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Tgl Masuk IGP Group tidak valid!"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        $data['username'] = $username;
                        $data['name'] = $name;
                        $data['password'] = bcrypt($password);
                        $data['email'] = $email;
                        $data['init_supp'] = $username;
                        $user = User::create($data);

                        $userRole = Role::where('name', 'karyawan')->first();
                        $user->attachRole($userRole);
                        $user->sendVerification();

                        $log_keterangan = "Registrasi User ".$user->username." Berhasil";
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => $user->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Proses Registrasi Berhasil! Silahkan klik pada link aktivasi yang telah kami kirim ke email."
                            ]);
                        return redirect('/login');
                    }
                }
            }
        } catch (Exception $ex) {
            DB::connection("pgsql")->rollback();
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Proses Registrasi Gagal! Silahkan coba lagi atau hubungi HRD."
                ]);
            return redirect()->back()->withInput(Input::all());
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $userRole = Role::where('name', 'user')->first();
        $user->attachRole($userRole);
        $user->sendVerification();
        return $user;
    }

    public function verify(Request $request, $token) 
    { 
        $email = $request->get('email');
        $user = User::where('verification_token', $token)->where('email', $email)->first();
        if ($user) {
            $user->verify();
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil melakukan verifikasi."
            ]);
            Auth::login($user);
        }
        return redirect('/');
    }

    public function sendVerification(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        if ($user && !$user->is_verified) {
            $user->sendVerification();
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Silahkan klik pada link aktivasi yang telah kami kirim."
            ]);
        }
        return redirect('/login');
        // return redirect('/register');
    }
}

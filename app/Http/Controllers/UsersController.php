<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\User;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Exception;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['admin-view', 'user-view'])) {
            return view('users.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can(['admin-view', 'user-view'])) {
                // $users = User::All();
                if(Auth::user()->can('admin-view')) {
                    $users = User::select(['id', 'name', 'username', 'email', 'init_supp', 'status_active', 'no_hp', 'telegram_id'])->whereNotIn('username', ['ian']);
                } else {
                    $users = User::select(['id', 'name', 'username', 'email', 'init_supp', 'status_active', 'no_hp', 'telegram_id'])->whereNotIn('username', ['ian', 'root']);
                }

                if ($request->get('status') == 'T') $users->active();
                if ($request->get('status') == 'F') $users->notActive();
                if ($request->get('status_user') == 'K') $users->karyawan();
                if ($request->get('status_user') == 'S') $users->supplier();
                if ($request->get('status_online') == 'O') $users->online();
                if ($request->get('status_online') == 'F') $users->notOnline();

                return Datatables::of($users)
                    ->addColumn('rolename', function($user){
                        $role_name = "";
                        $roles = $user->roles()->orderBy('name')->get();
                        foreach ($roles as $role) {
                            if($role_name === "") {
                                $role_name = $role->name;
                            } else {
                                $role_name = $role_name.' | '.$role->name;
                            }
                        }
                        return $role_name;
                    })
                    ->filterColumn('rolename', function ($query, $keyword) {
                        $query->whereRaw("(select string_agg(name, ' | ' order by name) from roles where roles.id in (select role_id from role_user where role_user.user_id = users.id)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('status_active', function($user){
                        if($user->status_active === 'T') {
                            return 'Ya';
                        } else {
                            return 'Tidak';
                        }
                    })
                    ->addColumn('online', function($user){
                        if ($user->isOnline()) {
                            $loc_image = asset("images/green_16.png");
                            return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="Online">';
                        } else {
                            $loc_image = asset("images/red_16.png");
                            return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="Offline">';
                        }
                    })
                    ->addColumn('action', function($user){
                        if ($user->can(['admin-edit', 'admin-delete'])) {
                            return '';
                        } else if ($user->can(['user-edit', 'user-delete'])) {
                            if(Auth::user()->can(['admin-edit', 'admin-delete'])) {
                                return view('datatable._action', [
                                    'model' => $user,
                                    'form_url' => route('users.destroy', base64_encode($user->id)),
                                    'edit_url' => route('users.edit', base64_encode($user->id)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$user->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus ' . $user->name . '?'
                                ]);
                            } else {
                                return '';
                            }
                        } else {
                            if(Auth::user()->can(['admin-edit', 'admin-delete','user-edit', 'user-delete'])) {
                                return view('datatable._action', [
                                    'model' => $user,
                                    'form_url' => route('users.destroy', base64_encode($user->id)),
                                    'edit_url' => route('users.edit', base64_encode($user->id)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$user->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus ' . $user->name . '?'
                                ]);
                            } else {
                                return '';
                            }
                        }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can(['admin-create', 'user-create'])) {
            return view('users.create');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if(Auth::user()->can(['admin-create', 'user-create'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $data = $request->all();
                if(config('app.env', 'local') === 'production') {
                    $password = str_random(6);
                } else {
                    $password = strtolower($data['username']);
                }
                $data['username'] = strtolower($data['username']);
                $data['name'] = strtoupper($data['name']);
                $data['password'] = bcrypt($password);
                $data['email'] = strtolower($data['email']);
                $data['init_supp'] = strtoupper($data['init_supp']);
                $data['telegram_id'] = trim($data['telegram_id']) !== '' ? trim($data['telegram_id']) : null;
                $data['no_hp'] = trim($data['no_hp']) !== '' ? trim($data['no_hp']) : null;
                // bypass verifikasi
                // if(config('app.env', 'local') === 'local') {
                    $data['is_verified'] = 1;
                // }

                $user = User::create($data);
                // set role
                $userRoles = Role::whereIn('name', $request->get('rolename'))->get();
                $user->attachRoles($userRoles);

                if(config('app.env', 'local') === 'production') {
                    // kirim email
                    $explode = explode(".", $user->username);
                    $kd_supp = $explode[0];
                    $kd_supp = strtoupper($kd_supp);

                    if (substr($kd_supp,0,3) !== "BTI") {
                        Mail::send('auth.emails.invite', compact('user', 'password'), function ($m) use ($user) {
                            $m->to($user->email, $user->name)
                            ->bcc("septian@igp-astra.co.id")
                            ->subject('Anda telah didaftarkan di '. config('app.name', 'Laravel'). '!');
                        });
                    } else {
                        Mail::send('auth.emails.invite-eng', compact('user', 'password'), function ($m) use ($user) {
                            $m->to($user->email, $user->name)
                            ->bcc("septian@igp-astra.co.id")
                            ->subject('You have been registered in '.explode(' ', config('app.name', 'Laravel'))[1].' '.explode(' ', config('app.name', 'Laravel'))[0].'!');
                        });
                    }
                }

                try {
                    // kirim telegram
                    $token_bot = config('app.token_igp_astra_bot', '-');

                    $admins = DB::table("users")
                    ->whereNotNull("telegram_id")
                    ->whereRaw("length(trim(telegram_id)) > 0")
                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('admin-create','telegram-notif-createuser'))")
                    ->get();

                    if(config('app.env', 'local') === 'production') {
                        $pesan = salam()." ".$user->name.", \n\n";
                    } else {
                        $pesan = "<strong>TRIAL</strong>\n\n";
                        $pesan .= salam()." ".$user->name.", \n\n";
                    }
                    $pesan .= "Admin Kami telah mendaftarkan Anda ke ".config('app.name', 'Laravel').".\n\n";
                    $pesan .= "Untuk login, silahkan kunjungi <a href='".url('login')."'>".url('login')."</a>.\n\n";
                    $pesan .= "Setelah itu, silahkan login dengan menggunakan: \n\n";
                    $pesan .= "Username: <strong>".$user->username."</strong>\n";
                    $pesan .= "Email: <strong>".$user->email."</strong>\n";
                    $pesan .= "Password: <strong>".$password."</strong>\n\n";
                    if (strlen($user->username) == 5) {
                        $pesan .= "<strong>Anda juga bisa login menggunakan password aplikasi Intranet atau IGPro.</strong>\n\n";
                    }
                    $pesan .= "Jika Anda ingin mengubah password, silahkan kunjungi <a href='".url('password/reset')."'>".url('password/reset')."</a> dan masukan email Anda."; 

                    foreach ($admins as $admin) {
                        $data_telegram = array(
                            'chat_id' => $admin->telegram_id,
                            'text'=> $pesan,
                            'parse_mode'=>'HTML'
                            );
                        $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                    }
                } catch (Exception $exception) {

                }

                //insert logs
                $log_keterangan = "UsersController.store: Create User Berhasil. ".$user->id." - ".$user->username;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menyimpan user dengan email " .
                    "<strong>" . $data['email'] . "</strong>" .
                    " dan password <strong>" . $password . "</strong>."
                ]);
                DB::connection("pgsql")->commit();
                return redirect()->route('users.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('users.index');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can(['admin-view', 'user-view'])) {
            $user = User::find(base64_decode($id));
            return view('users.show', compact('user'));
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can(['admin-edit', 'user-edit'])) {
            $user = User::find(base64_decode($id));
            if ($user->can(['admin-edit'])) {
                return view('errors.403');
            } else if ($user->can(['user-edit'])) {
                if(Auth::user()->can(['admin-edit'])) {
                    return view('users.edit')->with(compact('user'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('users.edit')->with(compact('user'));
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if(Auth::user()->can(['admin-edit', 'user-edit'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $user = User::find(base64_decode($id));

                $data = $request->only('name','username','email','init_supp','status_active','no_hp','telegram_id');
                $data['username'] = strtolower($data['username']);
                $data['name'] = strtoupper($data['name']);
                $data['email'] = strtolower($data['email']);
                $data['init_supp'] = strtoupper($data['init_supp']);
                $data['telegram_id'] = trim($data['telegram_id']) !== '' ? trim($data['telegram_id']) : null;
                $data['no_hp'] = trim($data['no_hp']) !== '' ? trim($data['no_hp']) : null;

                $user->update($data);  

                //update role_user
                $userRoles = Role::whereIn('name', $request->get('rolename'))->get();
                $user->detachRoles();
                $user->attachRoles($userRoles);

                //insert logs
                $log_keterangan = "UsersController.update: Update User Berhasil. ".$user->id." - ".$user->username;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan $user->username - $user->name"
                ]);

                DB::connection("pgsql")->commit();
                return redirect()->route('users.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('users.index');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can(['admin-delete', 'user-delete'])) {
            try {
                $user = User::find(base64_decode($id));
                $user_id = $user->id;
                $user_username = $user->username;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'User berhasil dihapus.';

                    if($user->can(['admin-delete'])) {
                        $status = 'NG';
                        $msg = 'User gagal dihapus karena memiliki role Super Administrator.';
                    } else if($user->can(['user-delete'])) {
                        if(Auth::user()->can(['admin-delete'])) {
                            DB::connection("pgsql")->beginTransaction();
                            $user->delete();

                            //insert logs
                            $log_keterangan = "UsersController.destroy: Delete User Berhasil. ".$user_id." - ".$user_username;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        } else {
                            $status = 'NG';
                            $msg = 'User gagal dihapus karena memiliki role Administrator.';
                        }
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        $user->delete();

                        //insert logs
                        $log_keterangan = "UsersController.destroy: Delete User Berhasil. ".$user_id." - ".$user_username;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if($user->can(['admin-delete'])) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"User gagal dihapus karena memiliki role Super Administrator."
                        ]);
                    } else if($user->can(['user-delete'])) {
                        if(Auth::user()->can(['admin-delete'])) {
                            DB::connection("pgsql")->beginTransaction();
                            $user->delete();

                            //insert logs
                            $log_keterangan = "UsersController.destroy: Delete User Berhasil. ".$user_id." - ".$user_username;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"User berhasil dihapus."
                            ]);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"User gagal dihapus karena memiliki role Administrator."
                            ]);
                        }
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        $user->delete();

                        //insert logs
                        $log_keterangan = "UsersController.destroy: Delete User Berhasil. ".$user_id." - ".$user_username;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                            
                        DB::connection("pgsql")->commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"User berhasil dihapus."
                        ]);
                    }
                    return redirect()->route('users.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'User tidak bisa dihapus karena sudah digunakan untuk Master/Transaksi!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"User tidak bisa dihapus karena sudah digunakan untuk Master/Transaksi!"
                    ]);
                    return redirect()->route('users.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS USER!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function daftarUser()
    {
        return view('users.daftar');
    }

    public function listuser(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'username', 'email', 'status_active', 'init_supp', 'no_hp', 'telegram_id'])->where(DB::raw("split_part(upper(username),'.',1)"), "=", Auth::user()->kd_supp);

            if ($request->get('status') == 'T') $users->active();
            if ($request->get('status') == 'F') $users->notActive();
            if ($request->get('status_online') == 'O') $users->online();
            if ($request->get('status_online') == 'F') $users->notOnline();

            return Datatables::of($users)
                ->addColumn('rolename', function($user){
                    $role_name = "";
                    $roles = $user->roles()->orderBy('display_name')->get();
                    foreach ($roles as $role) {
                        if($role_name === "") {
                            $role_name = $role->display_name;
                        } else {
                            $role_name = $role_name.' | '.$role->display_name;
                        }
                    }
                    return $role_name;
                })
                ->filterColumn('rolename', function ($query, $keyword) {
                    $query->whereRaw("(select string_agg(display_name, ' | ' order by display_name) from roles where roles.id in (select role_id from role_user where role_user.user_id = users.id)) like ?", ["%$keyword%"]);
                })
                ->editColumn('status_active', function($user){
                    if($user->status_active === 'T') {
                        return 'Ya';
                    } else {
                        return 'Tidak';
                    }
                })
                ->addColumn('online', function($user){
                    if ($user->isOnline()) {
                        $loc_image = asset("images/green_16.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="Online">';
                    } else {
                        $loc_image = asset("images/red_16.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="Offline">';
                    }
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function logs()
    {
        if(Auth::user()->can(['admin-view', 'user-view'])) {
            return view('users.logs');
        } else {
            return view('errors.403');
        }
    }

    public function logusers(Request $request)
    {
        if(Auth::user()->can(['admin-view', 'user-view'])) {
            if ($request->ajax()) {
                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $status_user = "ALL";
                if(!empty($request->get('status_user'))) {
                    $status_user = $request->get('status_user');
                }
                $status_username = "ALL";
                if(!empty($request->get('status_username'))) {
                    $status_username = $request->get('status_username');
                }
                
                if($status_user === "ALL") {
                    if($status_username === "ALL") {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir);
                    } else {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir)
                        ->where(DB::raw("u.username"), $status_username);
                    }
                } else if($status_user === "K") { 
                    if($status_username === "ALL") {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir)
                        ->whereRaw("length(u.username) = 5");
                    } else {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir)
                        ->whereRaw("length(u.username) = 5")
                        ->where(DB::raw("u.username"), $status_username);
                    }
                } else {
                    if($status_username === "ALL") {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir)
                        ->whereRaw("length(u.username) > 5");
                    } else {
                        $lists = DB::table(DB::raw("logs l, users u"))
                        ->select(DB::raw("u.username, u.name, l.keterangan, l.ip, l.created_at as tgl"))
                        ->whereRaw("l.user_id = u.id")
                        ->whereNotIn('u.username', ['ian'])
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') >= ?", $awal)
                        ->whereRaw("to_char(l.created_at,'yyyymmdd') <= ?", $akhir)
                        ->whereRaw("length(u.username) > 5")
                        ->where(DB::raw("u.username"), $status_username);
                    }
                }
                return Datatables::of($lists)
                    ->addColumn('tgl', function($data){
                        return Carbon::parse($data->tgl)->format('d/m/Y H:i');
                    })
                    ->filterColumn('tgl', function ($query, $keyword) {
                        $query->whereRaw("to_char(l.created_at,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                    })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function phpinfo()
    {
        if(Auth::user()->can(['admin-view', 'user-view'])) {
            phpinfo();
        } else {
            return view('errors.403');
        }
    }

    public function cekefaktur()
    {
        try {
            $status = 'OK';
            $msg = 'Proses validasi link E-Faktur berhasil.';
            $url = "http://svc.efaktur.pajak.go.id/validasi/faktur/025902818048000/0001861449748/3031300D0609608648016503040201050004202E16BF97C9A11A55B1EE2886F31D756609C9FBAC46CDC19342A77D2B24AFE609";

            $xml = simplexml_load_file(rawurlencode($url));
            // echo "<pre>";
            // print_r($xml);

            $tgl_fp = (string) $xml->tanggalFaktur;
            echo "TGL FP: ". $tgl_fp ."<br>";
            $no_fp = (string) $xml->kdJenisTransaksi.$xml->fgPengganti.$xml->nomorFaktur;
            echo "No FP: ". $no_fp ."<br>";
            $no_seri_fp = substr($no_fp,0,3).'.'.substr($no_fp,3,3).'-'.substr($no_fp,6,2);
            echo "No Seri FP: ". $no_seri_fp ."<br>";
            $no_faktur = substr($no_fp,-8,8);
            echo "NO FAKTUR: ". $no_faktur ."<br>";
            $npwpLawanTransaksi = (string) $xml->npwpLawanTransaksi;
            echo "NPWP PT: ". $npwpLawanTransaksi ."<br>";
            $npwpPenjual = (string) $xml->npwpPenjual;
            echo "NPWP Supplier: ". $npwpPenjual ."<br>";
            $jumlahDpp = (string) $xml->jumlahDpp;
            echo "Nilai DPP: ". $jumlahDpp ."<br>";
            $jumlahPpn = (string) $xml->jumlahPpn;
            echo "Nilai PPN: ". $jumlahPpn ."<br>";
            $jumlahPpnBm = (string) $xml->jumlahPpnBm;
            echo "Nilai PPN BM: ". $jumlahPpnBm ."<br>";
            $statusApproval = (string) $xml->statusApproval;
            echo "Status Approval: ". $statusApproval ."<br>";
            $statusFaktur = (string) $xml->statusFaktur;
            echo "Status Faktur: ". $statusFaktur ."<br>";
            $referensi = null;
            if($xml->referensi != null) {
                $referensi = (string) $xml->referensi;
            }
            if($referensi !== '') {
                echo "Referensi: ". $referensi ."<br>";
            }
            // echo "<br>";
            // echo $xml->getName() . "<br>";
            // foreach($xml->children() as $child)
            // {
            //     echo $child->getName() . ": " . $child . "<br>";
            // }
            echo "OK";
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function cleanup(Request $request)
    {
        if(Auth::user()->can(['admin-view', 'user-view']) && Auth::user()->username === "ian") {
            try {
                DB::connection("pgsql")->beginTransaction();
                DB::connection("pgsql-mobile")->beginTransaction();

                //USER PORTAL
                $users = DB::table("users")
                ->whereRaw("length(username) = 5 and not exists (select 1 from v_mas_karyawan where v_mas_karyawan.npk = users.username and v_mas_karyawan.tgl_keluar is null) and status_active = 'T'");

                //USER INTRANET
                $user1 = DB::connection('pgsql-mobile')
                ->table("user1")
                ->whereRaw("not exists (select 1 from v_mas_karyawan where v_mas_karyawan.npk = user1.username and v_mas_karyawan.tgl_keluar is null)");

                //DATA GAJI
                $v_gaji = DB::connection('pgsql-mobile')
                ->table("v_gaji")
                ->whereRaw("not exists (select 1 from v_mas_karyawan where v_mas_karyawan.npk = v_gaji.npk_asli)");

                //DATA PK
                $v_pk = DB::connection('pgsql-mobile')
                ->table("v_pk")
                ->whereRaw("not exists (select 1 from v_mas_karyawan where v_mas_karyawan.npk = v_pk.npk)");

                $info = "User Portal: ".$users->get()->count()." Data dinonaktifkan.";
                $info .= "<br>"."User Intranet: ".$user1->get()->count()." Data dihapus.";
                $info .= "<br>"."Data Gaji: ".$v_gaji->get()->count()." Data dihapus.";
                $info .= "<br>"."Data PK: ".$v_pk->get()->count()." Data dihapus.";

                $users->update(["status_active" => "F"]);
                $user1->delete();
                $v_gaji->delete();
                $v_pk->delete();

                //insert logs
                $log_keterangan = "UsersController.cleanup: Cleanup Berhasil.";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();
                DB::connection("pgsql-mobile")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>$info
                    ]);
                return redirect()->route('users.index');
            } catch(Exception $ex) {
                DB::connection("pgsql")->rollback();
                DB::connection("pgsql-mobile")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Proses Cleanup Gagal: ".$ex
                    ]);
                return redirect()->route('users.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatesvn()
    {
        if (Auth::user()->username === "14438" || Auth::user()->username === "08268" || Auth::user()->username === "14523" || Auth::user()->username === "16266") {
            $level = "info";
            $output = shell_exec("bash -lc 'echo Kosongin01 | /usr/bin/sudo -S /usr/share/nginx/html/portaligp/update.sh'");
            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>"<pre>$output</pre>"
            ]);
            return redirect('/');
        } else {
            return view('errors.403');
        }
    }

    public function mappingserverh()
    {
        if (Auth::user()->username === "14438" || Auth::user()->username === "08268") {
            $level = "info";
            $ip_h = config('app.ip_h', '-');
            $ip_x = config('app.ip_x', '-');

            $output = shell_exec("bash -lc 'echo Kosongin01 | /usr/bin/sudo -S mount -t cifs //$ip_h /serverh -o user=14438,password=anianda7,domain=ADMINITE,gid=nginx,file_mode=0775,dir_mode=0775,iocharset=utf8,sec=ntlm'");

            $output = shell_exec("bash -lc 'echo Kosongin01 | /usr/bin/sudo -S mount -t cifs //$ip_x/Public /serverx -o user=14438,password=anianda7,domain=ADMIN,gid=nginx,file_mode=0775,dir_mode=0775,iocharset=utf8,sec=ntlm'");

            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>"<pre>$output</pre>"
            ]);
            return redirect('/');
        } else {
            return view('errors.403');
        }
    }

    public function mappingserverhkim()
    {
        if (Auth::user()->username === "14438" || Auth::user()->username === "08268") {
            $level = "info";
            $output = shell_exec("bash -lc 'echo Kosongin01 | /usr/bin/sudo -S mount -t cifs //10.15.0.5/Public /serverhkim -o user=administrator,password=*fileKim0106,domain=KIM,gid=nginx,file_mode=0775,dir_mode=0775,iocharset=utf8,sec=ntlm'");

            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>"<pre>$output</pre>"
            ]);
            return redirect('/');
        } else {
            return view('errors.403');
        }
    }

    public function cektelegram()
    {
        if (Auth::user()->username === "14438") {
            try {
                // kirim telegram
                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                $token_bot_eksternal = config('app.token_igp_group_bot', '-');
                $telegram_id_ian = config('app.telegram_id_ian', '-');

                $pesan = config('app.url', 'http://localhost')." : Test kirim pesan melalui telegram berhasil!";

                $data_telegram = array(
                    'chat_id' => $telegram_id_ian,
                    'text'=> $pesan,
                    'parse_mode'=>'HTML'
                    );
                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);

                $data_telegram = array(
                    'chat_id' => $telegram_id_ian,
                    'text'=> $pesan,
                    'parse_mode'=>'HTML'
                    );
                $result = KirimPerintah("sendMessage", $token_bot_eksternal, $data_telegram);

                echo $pesan;
            } catch (Exception $exception) {
                echo "Test kirim pesan melalui telegram GAGAL: ".$exception;
            }
        } else {
            return view('errors.403');
        }
    }

    public function rebootserver()
    {
        if (Auth::user()->username === "14438" || Auth::user()->username === "08268") {
            $level = "info";
            $output = shell_exec("bash -lc 'echo Kosongin01 | /usr/bin/sudo -S reboot'");

            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>"<pre>$output</pre>"
            ]);
            return redirect('/');
        } else {
            return view('errors.403');
        }
    }
}

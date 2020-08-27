<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\Permission;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('admin-view')) {
            return view('roles.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('admin-view')) {
                // $roles = Role::All();
                $roles = Role::select(['id', 'name', 'display_name', 'description']);

                return Datatables::of($roles)
                    ->addColumn('permissionname', function($role){
                        $permission_name = "";
                        $permissions = $role->permissions()->get();
                        foreach ($permissions as $permission) {
                            if($permission_name === "") {
                                $permission_name = $permission->name;
                            } else {
                                $permission_name = $permission_name.' | '.$permission->name;
                            }
                        }
                        return $permission_name;
                    })
                    ->filterColumn('permissionname', function ($query, $keyword) {
                        $query->whereRaw("(select string_agg(name, ' | ' order by name) from permissions where permissions.id in (select permission_id from permission_role where permission_role.role_id = roles.id)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($role){
                        if(Auth::user()->can(['admin-edit', 'admin-delete'])) {
                            return view('datatable._action', [
                                'model' => $role,
                                'form_url' => route('roles.destroy', base64_encode($role->id)),
                                'edit_url' => route('roles.edit', base64_encode($role->id)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$role->id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus ' . $role->name . '?'
                            ]);
                        } else {
                            return '';
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
        if(Auth::user()->can('admin-create')) {
            return view('roles.create');
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
    public function store(StoreRoleRequest $request)
    {
        if(Auth::user()->can('admin-create')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $data = $request->all();
                $role = new Role();
                $role->name         = $data['name'];
                $role->display_name = $data['display_name'];
                $role->description  = $data['description'];
                $role->save();

                // set permissions
                $rolePermissions = Permission::whereIn('name', $request->get('permissionname'))->get();
                $role->attachPermissions($rolePermissions);

                //insert logs
                $log_keterangan = "RolesController.store: Create Role Berhasil. ".$role->name;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menyimpan $role->name"
                ]);
                DB::connection("pgsql")->commit();
                return redirect()->route('roles.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('roles.index');
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
        if(Auth::user()->can('admin-view')) {
            $role = Role::find(base64_decode($id));
            return view('roles.show', compact('role'));
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
        if(Auth::user()->can('admin-edit')) {
            $role = Role::find(base64_decode($id));
            return view('roles.edit')->with(compact('role'));
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
    public function update(UpdateRoleRequest $request, $id)
    {
        if(Auth::user()->can('admin-edit')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $role = Role::find(base64_decode($id));
                $data = $request->only('name','display_name','description');
                $role->name         = $data['name'];
                $role->display_name = $data['display_name'];
                $role->description  = $data['description'];
                $role->update();

                //update permission_role
                $rolePermissions = Permission::whereIn('name', $request->get('permissionname'))->get();
                $role->detachPermissions($role->permissions()->get());
                $role->attachPermissions($rolePermissions);

                //insert logs
                $log_keterangan = "RolesController.update: Update Role Berhasil. ".$role->name;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan $role->name"
                ]);
                DB::connection("pgsql")->commit();
                return redirect()->route('roles.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('roles.index');
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
        if(Auth::user()->can('admin-delete')) {
            try {
                $role = Role::find(base64_decode($id));
                $role_name = $role->name;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Role berhasil dihapus.';

                    DB::connection("pgsql")->beginTransaction();
                    $role->delete();

                    //insert logs
                    $log_keterangan = "RolesController.destroy: Delete Role Berhasil. ".$role_name;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("pgsql")->beginTransaction();
                    $role->delete();

                    //insert logs
                    $log_keterangan = "RolesController.destroy: Delete Role Berhasil. ".$role_name;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    
                    DB::connection("pgsql")->commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Role berhasil dihapus."
                    ]);
                    return redirect()->route('roles.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Role gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Role gagal dihapus!"
                    ]);
                    return redirect()->route('roles.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS ROLE!']);
            } else {
                return view('errors.403');
            }
        }
    }
}

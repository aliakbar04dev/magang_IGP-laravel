<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Permission;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('admin-view')) {
            return view('permissions.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('admin-view')) {
                // $permissions = Permission::All();
                $permissions = Permission::select(['id', 'name', 'display_name', 'description']);

                return Datatables::of($permissions)
                    ->addColumn('action', function($permission){
                        if(Auth::user()->can(['admin-edit', 'admin-delete'])) {
                            return view('datatable._action', [
                                'model' => $permission,
                                'form_url' => route('permissions.destroy', base64_encode($permission->id)),
                                'edit_url' => route('permissions.edit', base64_encode($permission->id)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$permission->id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus ' . $permission->name . '?'
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
            return view('permissions.create');
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
    public function store(StorePermissionRequest $request)
    {
        if(Auth::user()->can('admin-create')) {
            try {
                DB::connection("pgsql")->beginTransaction();

                $data = $request->all();
                $permission = new Permission();
                $permission->name         = $data['name'];
                $permission->display_name = $data['display_name'];
                $permission->description  = $data['description'];
                $permission->save();

                //insert logs
                $log_keterangan = "PermissionsController.store: Create Permission Berhasil. ".$permission->name;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menyimpan $permission->name"
                ]);
                return redirect()->route('permissions.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('permissions.index');
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
            $permission = Permission::find(base64_decode($id));
            return view('permissions.show', compact('permission'));
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
            $permission = Permission::find(base64_decode($id));
            return view('permissions.edit')->with(compact('permission'));
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
    public function update(UpdatePermissionRequest $request, $id)
    {
        if(Auth::user()->can('admin-edit')) {
            try {
                DB::connection("pgsql")->beginTransaction();

                $permission = Permission::find(base64_decode($id));
                $data = $request->only('name','display_name','description');
                $permission->name         = $data['name'];
                $permission->display_name = $data['display_name'];
                $permission->description  = $data['description'];
                $permission->update();

                //insert logs
                $log_keterangan = "PermissionsController.update: Update Permission Berhasil. ".$permission->name;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan $permission->name"
                ]);
                return redirect()->route('permissions.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!"
                ]);
                return redirect()->route('permissions.index');
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
                $permission = Permission::find(base64_decode($id));
                $permission_name = $permission->name;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Permission berhasil dihapus.';

                    DB::connection("pgsql")->beginTransaction();
                    $permission->delete();

                    //insert logs
                    $log_keterangan = "PermissionsController.destroy: Delete Permission Berhasil. ".$permission_name;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("pgsql")->beginTransaction();
                    $permission->delete();

                    //insert logs
                    $log_keterangan = "PermissionsController.destroy: Delete Permission Berhasil. ".$permission_name;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    
                    DB::connection("pgsql")->commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Permission berhasil dihapus."
                    ]);
                    return redirect()->route('permissions.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Permission gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Permission gagal dihapus!"
                    ]);
                    return redirect()->route('permissions.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS PERMISSION!']);
            } else {
                return view('errors.403');
            }
        }
    }
}

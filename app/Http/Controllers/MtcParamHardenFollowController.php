<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use App\EngtMdlLines;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;

class MtcParamHardenFollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-param-harden-follow'])) {
            return view('mtc.paramharden.index');
        } else {
            return view('errors.403');
        }    
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('mtc-param-harden-follow')) {
            if ($request->ajax()) {

              $list = DB::table("qct_par_harden01")
              ->select(DB::raw("*"))
              ->where("judge", "=", "NG")
              // ->where("judge", "=", "OK")
              ;
              //rubah jadi NG 

              return Datatables::of($list)
                ->editColumn('tanggal', function($tanggal){
                    return \Carbon\Carbon::parse($tanggal->tanggal)->format('m/d/Y');
                })
                ->editColumn('tgl_follow_up', function($tgl_follow_up){
                    if ($tgl_follow_up->tgl_follow_up == '') {
                        return '';
                    } else {
                        return \Carbon\Carbon::parse($tgl_follow_up->tgl_follow_up)->format('m/d/Y h:i');
                    }
                })
                ->addColumn('action', function($mtcparamharden){

                    $form_id = str_replace('/', '', $mtcparamharden->no_doc);
                    $form_id = str_replace('-', '', $form_id);
                    $form_id = str_replace(' ', '', $form_id);

                    // penggunaan $form_id digunakan untuk yang IDnya mempunyai symbol 

                    if($mtcparamharden->tgl_follow_up == ''){
                        return view('datatable._action-edit-only', [
                            'edit_url' => route('mtcparamhardenfollow.edit', base64_encode($mtcparamharden->no_doc))
                        ]);
                    }
                })
                ->make(true);
            } else {
              return redirect('home');
            }
        } else {
          return view('errors.403');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::user()->can(['mtc-param-harden-follow'])) {
          $id = base64_decode($id);
          $qct_par_harden01 = DB::table('qct_par_harden01')
          ->select("*")
          ->where(DB::raw("no_doc"), '=', $id)
          ->get()
          ->first();

          
          $qct_par_harden02 = DB::table('qct_par_harden02')
          ->select("*")
          ->where(DB::raw("no_doc"), '=', $id)
          ->orderBy("no_seq", "asc")
          ->get();

          return view('mtc.paramharden.edit', compact('qct_par_harden01', 'qct_par_harden02'));
      } else {
          return view('errors.403');
      }
    }

    public function UpdateFollow($id)
    {
      if(Auth::user()->can(['mtc-param-harden-follow'])) {
          $id = base64_decode($id);
          $qct_par_harden01 = DB::table('qct_par_harden01')
          ->where(DB::raw("no_doc"), '=', $id)
          ->update(['tgl_follow_up' => DB::raw("current_timestamp")]);

          
            Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Data berhasil di followUp dengan No Doc: ".$id]);

          return view('mtc.paramharden.index');
      } else {
          return view('errors.403');
      }
    }

    public function UpdateFollow2($id)
    {
      // $id = base64_decode($id);
      if ($id == 'OK'){
        $qct_par_harden01 = DB::connection("sqlsrv")
        ->table('Req_Dandory')
        ->update(['TC_OK' => 1]);

      } else {
        $qct_par_harden01 = DB::connection("sqlsrv")
        ->table('Req_Dandory')
        ->update(['TC_NG' => 1]);
      }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

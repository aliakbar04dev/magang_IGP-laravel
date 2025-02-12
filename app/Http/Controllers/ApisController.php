<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\File;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Qpr;
use App\QprEmail;
use Carbon\Carbon;

class ApisController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function milkruns(Request $request)
    {
        /*
        // if ($request->ajax()) {
            $data = DB::connection("oracle-baan")
                    ->table(DB::raw("baandb.vwmlk"))
                    ->select(DB::raw("trim(nopo) no_nopo, trim(nodn) no_nodn, trim(shipto) kd_shipto, trim(cean) kd_cean, trim(model) kd_model, qodr qty_qodr, trim(item) kd_item, oddt tgl_oddt"))
                    ->orderByRaw("trim(nodn), trim(nopo)");
            //return json_encode($data->get());
            //return json_encode($data->get(), JSON_FORCE_OBJECT);
            //return json_decode($data->get());
            //return json_decode($data->get(), true);
            //return response()->json($data->get());
            //return Datatables::of($data)->make(true);
            if($data->get()->count() > 0) {

                // $data_json = json_encode($data->get());

                // $file = 'milkrun_'.date('YmdHis', time()).'.json';
                // $destinationPath=public_path()."/filejson/milkrun/";
                // if (!is_dir($destinationPath)) {  
                //     mkdir($destinationPath, 0777, true);
                //     chown($destinationPath, "nginx");
                // }
                // File::put($destinationPath.$file, $data_json);
            }
            return json_encode($data->get());
        // } else {
        //     return redirect('home');
        // }
        */
       return view('errors.403');
    }

    public function milkruns2(Request $request)
    {
        // if ($request->ajax()) {
            $url = "https://webapi.akebono-astra.co.id/MilkrunAAIJ/DS/";
            $json = file_get_contents($url);
            $datas = json_decode($json, true);
            // return $datas;
            
            $client_ip = \Request::ip();
            try {
                $json_ip = json_decode(file_get_contents("https://api.ipify.org?format=json"), true);
                $client_ip = $json_ip['ip']." / ".\Request::ip();
            } catch (Exception $ex) {
                
            }

            DB::connection("oracle-usrigpmfg")->beginTransaction();
            try {

                $text = "";
                foreach ($datas as $key => $value) {
                    $po = $value['po'];
                    $dn = $value['dn'];
                    $shipto = $value['shipto'];
                    $custitem = $value['custitem'];
                    $model = $value['model'];
                    $qty = $value['qty'];
                    $item = $value['item'];
                    $ds = $value['ds'];

                    if($text === "") {
                        $text = $po."|".$dn."|".$shipto."|".$custitem."|".$model."|".$qty."|".$item."|".$ds."\r\n";
                    } else {
                        $text .= $po."|".$dn."|".$shipto."|".$custitem."|".$model."|".$qty."|".$item."|".$ds."\r\n";
                    }

                    DB::connection("oracle-usrigpmfg")
                    ->table(DB::raw("usrbaan.baan_milkrun_aaij"))
                    ->insert(['po' => $po, 'dn' => $dn, 'shipto' => $shipto, 'custitem' => $custitem, 'model' => $model, 'qty' => $qty, 'item' => $item, 'ds' => $ds, 'dtcrea' => Carbon::now(), 'ip' => $client_ip]);
                }
                DB::connection("oracle-usrigpmfg")->commit();

                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."milkrun".DIRECTORY_SEPARATOR;
                } else {
                    $destinationPath = "\\\\192.168.42.28\\txtakebono\\";
                }

                $file = 'milkrun_'.date('YmdHis', time()).'.txt';
                if (is_dir($destinationPath)) {  
                    $text = str_replace ('<br>', "\r\n", $text);
                    File::put($destinationPath.$file, $text);
                }

                $status = 'OK';
                $msg = 'Proses tarik data berhasil!';
            } catch (Exception $ex) {
                DB::connection("oracle-usrigpmfg")->rollback();
                $status = 'NG';
                $msg = 'Proses tarik data gagal!';
            }
            return response()->json(['status' => $status, 'message' => $msg, 'jml_data' => count($datas)]);
        // } else {
        //     return redirect('home');
        // }
    }

    public function mierukaigp(Request $request, $tgl_awal = null, $tgl_akhir = null)
    {
        // if ($request->ajax()) {

            if($tgl_awal == null) {
                $tgl_awal = Carbon::now()->startOfMonth()->format('Y-m-d');
            }
            if($tgl_akhir == null) {
                try {
                    $tgl_akhir = Carbon::createFromFormat('Y-m-d', $tgl_awal);
                    $tgl_akhir = $tgl_akhir->endOfMonth()->format('Y-m-d');
                } catch (Exception $ex) {
                    $tgl_akhir = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
            }
            $url = "https://mierukaigp.akebono-astra.co.id/api/?date=$tgl_awal&date2=$tgl_akhir";
            $json = file_get_contents($url);
            $datas = json_decode($json, true);
            // return $datas;
            
            // $client_ip = \Request::ip();
            // try {
            //     $json_ip = json_decode(file_get_contents("https://api.ipify.org?format=json"), true);
            //     $client_ip = $json_ip['ip']." / ".\Request::ip();
            // } catch (Exception $ex) {
                
            // }

            DB::connection("oracle-usrbaan")->beginTransaction();
            try {

                $cdate_awal = str_replace('-', '', $tgl_awal);
                $cdate_akhir = str_replace('-', '', $tgl_akhir);

                DB::connection("oracle-usrbaan")
                ->table("ds_meiruka")
                ->whereRaw("to_char(cdate,'yyyymmdd') >= ?", $cdate_awal)
                ->whereRaw("to_char(cdate,'yyyymmdd') <= ?", $cdate_akhir)
                ->delete();

                $text = "";
                foreach ($datas as $key => $value) {
                    if($value['po'] != null) {
                        $no_po = trim($value['po']) !== '' ? trim($value['po']) : null;
                    } else {
                        $no_po = NULL;
                    }
                    if($value['ds'] != null) {
                        $no_ds = trim($value['ds']) !== '' ? trim($value['ds']) : null;
                    } else {
                        $no_ds = NULL;
                    }
                    if($value['itm_igp'] != null) {
                        $item_igp = trim($value['itm_igp']) !== '' ? trim($value['itm_igp']) : null;
                    } else {
                        $item_igp = NULL;
                    }
                    if($value['itm'] != null) {
                        $item_no = trim($value['itm']) !== '' ? trim($value['itm']) : null;
                    } else {
                        $item_no = NULL;
                    }
                    if($value['mdl'] != null) {
                        $nm_mdl = trim($value['mdl']) !== '' ? trim($value['mdl']) : null;
                    } else {
                        $nm_mdl = NULL;
                    }
                    if($value['qty'] != null) {
                        $qty_ds = trim($value['qty']) !== '' ? trim($value['qty']) : null;
                    } else {
                        $qty_ds = NULL;
                    }
                    if($value['cdate'] != null) {
                        $cdate = Carbon::parse($value['cdate']);
                    } else {
                        $cdate = Carbon::createFromFormat('Y-m-d', $tgl_awal);
                    }

                    if($text === "") {
                        $text = $no_po."|".$no_ds."|".$item_igp."|".$item_no."|".$nm_mdl."|".$qty_ds."|".$cdate."\r\n";
                    } else {
                        $text .= $no_po."|".$no_ds."|".$item_igp."|".$item_no."|".$nm_mdl."|".$qty_ds."|".$cdate."\r\n";
                    }

                    DB::connection("oracle-usrbaan")
                    ->table("ds_meiruka")
                    ->insert(['no_po' => $no_po, 'no_ds' => $no_ds, 'item_igp' => $item_igp, 'item_no' => $item_no, 'nm_mdl' => $nm_mdl, 'qty_ds' => $qty_ds, 'cdate' => $cdate]);
                }
                DB::connection("oracle-usrbaan")->commit();

                // if(config('app.env', 'local') === 'production') {
                //     $destinationPath = DIRECTORY_SEPARATOR."milkrun".DIRECTORY_SEPARATOR;
                // } else {
                //     $destinationPath = "\\\\192.168.42.28\\txtakebono\\";
                // }

                // $file = 'milkrun_'.date('YmdHis', time()).'.txt';
                // if (is_dir($destinationPath)) {  
                //     $text = str_replace ('<br>', "\r\n", $text);
                //     File::put($destinationPath.$file, $text);
                // }

                $status = 'OK';
                $msg = 'PROSES TARIK DATA MIERUKA IGP BERHASIL!';
            } catch (Exception $ex) {
                DB::connection("oracle-usrbaan")->rollback();
                $status = 'NG';
                $msg = 'PROSES TARIK DATA MIERUKA IGP GAGAL!'.$ex;
            }
            return response()->json(['status' => $status, 'message' => $msg, 'jml_data' => count($datas)]);
        // } else {
        //     return redirect('home');
        // }
    }

    public function qprs(Request $request)
    {
        // php artisan route:call --uri=/notifikasi/qprs

        if(config('app.env', 'local') === 'production') {
            //NOTIFIKASI FM->SH
            echo "Send telegram NOTIFIKASI FM->SH: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, portal_tgl, 
                to_char((select dd from generate_series(portal_tgl, portal_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> portal_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_1,
                to_char((select dd from generate_series(emailsh_1_tgl, emailsh_1_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(emailsh_2_tgl, emailsh_2_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(emailsh_3_tgl, emailsh_3_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_3_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp, portal_sh_tgl 
                from qprs 
                where portal_tgl is not null 
                and to_char(issue_date,'YYYYMM') >= '201903' 
                and portal_sh_tgl is null 
                and portal_sh_tgl_reject is null 
                and portal_tgl_terima is null 
                and portal_tgl_reject is null 
                and ((emailsh_1_tgl is null or emailsh_2_tgl is null or emailsh_3_tgl is null) or (emailsh_1_tgl is not null and emailsh_2_tgl is not null and emailsh_3_tgl is not null))
                ) v"))
            ->select(DB::raw("v.issue_no, v.portal_sh_tgl, v.portal_tgl, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            ->orderByRaw("v.portal_tgl")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $emailsh_1_tgl = $qpr->emailsh_1_tgl;
                        $emailsh_2_tgl = $qpr->emailsh_2_tgl;
                        $emailsh_3_tgl = $qpr->emailsh_3_tgl;
                        
                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        if($emailsh_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "SH_1";
                            }
                        } else if($emailsh_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "SH_2";
                            }
                        } else if($emailsh_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "SH_3";
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "SH_4";
                            }
                        }

                        $plant = $qpr->plant;

                        if($mode === "SH_1" || $mode === "SH_2" || $mode === "SH_3") {
                            $email_sh = "";
                            $to = [];
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-approve','qpr-reject'))")
                            ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                            ->get();

                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                    if($email_sh == "") {
                                        $email_sh = $user_to_email->email;
                                    } else {
                                        $email_sh = $email_sh + "," + $user_to_email->email;
                                    }
                                }
                            } else {
                                if($plant != null) {
                                    if($plant != "1" && $plant != "2" && $plant != "3") {
                                        array_push($to, "triyono@igp-astra.co.id");
                                        $email_sh = "triyono@igp-astra.co.id";
                                    } else {
                                        array_push($to, "geowana.yuka@igp-astra.co.id");
                                        $email_sh = "geowana.yuka@igp-astra.co.id";
                                    }
                                } else {
                                    array_push($to, "triyono@igp-astra.co.id");
                                    array_push($to, "geowana.yuka@igp-astra.co.id");
                                    $email_sh = "triyono@igp-astra.co.id,geowana.yuka@igp-astra.co.id";
                                }
                            }

                            $cc = [];
                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('REMINDER QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL REMINDER QPR: '.$issue_no);
                                });
                            }

                            if($email_sh == "") {
                                $email_sh = null;
                            }

                            if($mode == "SH_1") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_1_tgl" => Carbon::now(), "emailsh_1" => $email_sh]);
                            } else if($mode == "SH_2") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_2_tgl" => Carbon::now(), "emailsh_2" => $email_sh]);
                            } else if($mode == "SH_3") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_3_tgl" => Carbon::now(), "emailsh_3" => $email_sh]);
                            }

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            try {
                                // kirim telegram
                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                if(config('app.env', 'local') === 'production') {
                                    $pesan = "<strong>REMINDER QPR</strong>\n\n";
                                    $pesan .= salam().",\n\n";
                                } else {
                                    $pesan = "<strong>TRIAL REMINDER QPR</strong>\n\n";
                                    $pesan .= salam().",\n\n";
                                }
                                $pesan .= "Kepada: <strong>SECTION HEAD</strong>\n\n";
                                $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                $pesan .= "Mohon Segera diproses.\n\n";

                                if(!empty($qpr->portal_pict)) {
                                    $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                } else {
                                    $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                }
                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                $pesan .= "Salam,\n\n";
                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                //SECTION HEAD
                                array_push($to, "agus.purwanto@igp-astra.co.id");
                                array_push($to, "septian@igp-astra.co.id");

                                $karyawans = DB::table("users")
                                ->whereRaw("length(username) = 5")
                                ->whereIn("email", $to)
                                ->whereNotNull("telegram_id")
                                ->whereRaw("length(trim(telegram_id)) > 0")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                ->get();

                                foreach ($karyawans as $karyawan) {
                                    $data_telegram = array(
                                        'chat_id' => $karyawan->telegram_id,
                                        'text'=> $pesan,
                                        'parse_mode'=>'HTML'
                                        );
                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                }
                            } catch (Exception $exception) {
                                echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                echo "<BR>";
                            }

                            echo "Send email notifikasi ".$issue_no." BERHASIL!";
                            echo "<BR>";
                        } else if($mode === "SH_4") {
                            //AUTO APPROVE
                            DB::table("qprs")
                            ->where("issue_no", $issue_no)
                            ->whereNull("portal_sh_tgl")
                            ->whereNull("portal_sh_tgl_reject")
                            ->whereNull("portal_tgl_terima")
                            ->whereNull("portal_tgl_reject")
                            ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => "00000"]);

                            DB::connection('oracle-usrigpmfg')
                            ->table("qpr")
                            ->where("issue_no", $issue_no)
                            ->whereNull("portal_sh_tgl")
                            ->whereNull("portal_sh_tgl_reject")
                            ->whereNull("portal_tgl_terima")
                            ->whereNull("portal_tgl_reject")
                            ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => "00000", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            echo "AUTO APPROVE QPR: ".$issue_no." BERHASIL!";
                            echo "<BR>";

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                            ->get();

                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                }
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            } else {
                                if($plant != null) {
                                    if($plant != "1" && $plant != "2" && $plant != "3") {
                                        array_push($to, "triyono@igp-astra.co.id");
                                    } else {
                                        array_push($to, "geowana.yuka@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($to, "triyono@igp-astra.co.id");
                                    array_push($to, "geowana.yuka@igp-astra.co.id");
                                }
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            }

                            array_push($cc, "ajie.priambudi@igp-astra.co.id");
                            array_push($cc, "albertus.janiardi@igp-astra.co.id");
                            array_push($cc, "apip.supendi@igp-astra.co.id");
                            array_push($cc, "arif.kurnianto@igp-astra.co.id");
                            array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                            array_push($cc, "achmad.fauzi@igp-astra.co.id");
                            array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                            array_push($cc, "igpprc1_scm@igp-astra.co.id");
                            array_push($cc, "meylati.nuryani@igp-astra.co.id");
                            array_push($cc, "mituhu@igp-astra.co.id");
                            array_push($cc, "qa_igp@igp-astra.co.id");
                            array_push($cc, "qc_igp@igp-astra.co.id");
                            array_push($cc, "qc_lab.igp@igp-astra.co.id");
                            array_push($cc, "qcigp2.igp@igp-astra.co.id");
                            array_push($cc, "risti@igp-astra.co.id");
                            array_push($cc, "sugandi@igp-astra.co.id");

                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "triyono@igp-astra.co.id");
                                } else {
                                    array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }
                            } else {
                                array_push($cc, "david.kurniawan@igp-astra.co.id");
                                array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                array_push($cc, "triyono@igp-astra.co.id");
                                array_push($cc, "geowana.yuka@igp-astra.co.id");
                                array_push($cc, "wawan@igp-astra.co.id");
                            }

                            $mode = "SH";
                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SH->SUPPLIER
            echo "Send telegram NOTIFIKASI SH->SUPPLIER: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, coalesce(portal_sh_tgl_no, portal_sh_tgl) portal_sh_tgl_approve, 
                to_char((select dd from generate_series(coalesce(portal_sh_tgl_no, portal_sh_tgl), coalesce(portal_sh_tgl_no, portal_sh_tgl) + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> coalesce(portal_sh_tgl_no, portal_sh_tgl) limit 1 offset 0),'yyyymmddhh24miss') notif_1, 
                to_char((select dd from generate_series(email_1_tgl, email_1_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(email_2_tgl, email_2_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(email_3_tgl, email_3_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_3_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp 
                from qprs 
                where coalesce(portal_sh_tgl_no, portal_sh_tgl) is not null 
                and to_char(issue_date,'YYYYMM') >= '201903' 
                and portal_sh_tgl_reject is null 
                and portal_tgl_terima is null 
                and (portal_tgl_reject is null or (portal_tgl_reject is not null and portal_apr_reject = 'F')) 
                and ((email_1_tgl is null or email_2_tgl is null or email_3_tgl is null) or (email_1_tgl is not null and email_2_tgl is not null and email_3_tgl is not null))
                ) v, qpr_emails q"))
            ->select(DB::raw("v.issue_no, v.portal_sh_tgl_approve, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp, q.email_1, q.email_2, q.email_3"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("v.kd_supp = q.kd_supp")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            ->orderByRaw("v.portal_sh_tgl_approve")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $email_1_tgl = $qpr->email_1_tgl;
                        $email_2_tgl = $qpr->email_2_tgl;
                        $email_3_tgl = $qpr->email_3_tgl;

                        $email_1 = $data->email_1;
                        $email_2 = $data->email_2;
                        $email_3 = $data->email_3;

                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        $to = [];
                        $valid_email = "F";
                        if($email_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "1";
                                $list_email = explode(",", $email_1);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($email_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "2";
                                $list_email = explode(",", $email_2);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($email_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "3";
                                $list_email = explode(",", $email_3);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "4";
                            }
                        }

                        if($mode === "1" || $mode === "2" || $mode === "3") {
                            if($valid_email === "T") {
                                $cc = [];
                                array_push($cc, "ajie.priambudi@igp-astra.co.id");
                                array_push($cc, "albertus.janiardi@igp-astra.co.id");
                                array_push($cc, "apip.supendi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                                array_push($cc, "igpprc1_scm@igp-astra.co.id");
                                array_push($cc, "meylati.nuryani@igp-astra.co.id");
                                array_push($cc, "mituhu@igp-astra.co.id");
                                array_push($cc, "qa_igp@igp-astra.co.id");
                                array_push($cc, "qc_igp@igp-astra.co.id");
                                array_push($cc, "qc_lab.igp@igp-astra.co.id");
                                array_push($cc, "qcigp2.igp@igp-astra.co.id");
                                array_push($cc, "risti@igp-astra.co.id");
                                array_push($cc, "sugandi@igp-astra.co.id");

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        array_push($cc, "david.kurniawan@igp-astra.co.id");
                                        array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                        array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                        array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                        array_push($cc, "triyono@igp-astra.co.id");
                                    } else {
                                        array_push($cc, "geowana.yuka@igp-astra.co.id");
                                        array_push($cc, "wawan@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "triyono@igp-astra.co.id");
                                    array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }

                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('REMINDER QPR: '.$issue_no);
                                    });
                                } else {
                                    Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL REMINDER QPR: '.$issue_no);
                                    });
                                }

                                if($mode == "1") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_1_tgl" => Carbon::now(), "email_1" => $email_1]);
                                } else if($mode == "2") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_2_tgl" => Carbon::now(), "email_2" => $email_2]);
                                } else if($mode == "3") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_3_tgl" => Carbon::now(), "email_3" => $email_3]);
                                }

                                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>REMINDER QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL REMINDER QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$qpr->namaSupp($qpr->kd_supp)." (".$qpr->kd_supp.")</strong>\n\n";
                                    $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                    $pesan .= "Mohon Segera diproses.\n\n";

                                    if(!empty($qpr->portal_pict)) {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    //KARYAWAN
                                    $plant = $qpr->plant;
                                    $karyawans = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                                    ->get();

                                    foreach ($karyawans as $karyawan) {
                                        $data_telegram = array(
                                            'chat_id' => $karyawan->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    //SUPPLIER
                                    $suppliers = DB::table("users")
                                    ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($suppliers as $supplier) {
                                        $data_telegram = array(
                                            'chat_id' => $supplier->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_eksternal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                    echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                    echo "<BR>";
                                }
                                
                                echo "Send email notifikasi ".$issue_no." BERHASIL!";
                                echo "<BR>";
                            } else {
                                echo "Send email notifikasi ".$issue_no." GAGAL! Tidak ada email yang valid!";
                                echo "<BR>";
                            }
                        } else if($mode === "4") {
                            //AUTO APPROVE BY SUPPLIER
                            /*OFF
                            DB::table("qprs")
                            ->where("issue_no", $issue_no)
                            ->whereNotNull("portal_sh_tgl")
                            ->whereNull("portal_tgl_terima")
                            ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => "00000"]);

                            DB::connection('oracle-usrigpmfg')
                            ->table("qpr")
                            ->where("issue_no", $issue_no)
                            ->whereNotNull("portal_sh_tgl")
                            ->whereNull("portal_tgl_terima")
                            ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => "00000", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            echo "AUTO APPROVE SUPPLIER QPR: ".$issue_no." BERHASIL!";
                            echo "<BR>";

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            
                            array_push($to, "qc_lab.igp@igp-astra.co.id");

                            $user_cc_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                            ->get();

                            array_push($cc, "sugandi@igp-astra.co.id");
                            array_push($cc, "arif.kurnianto@igp-astra.co.id");
                            foreach ($user_cc_emails as $user_cc_email) {
                                array_push($cc, $user_cc_email->email);
                            }

                            array_push($bcc, "agus.purwanto@igp-astra.co.id");

                            $mode = "SP";
                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                            */
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SUPPLIER->SUBMIT PICA
            echo "Send telegram NOTIFIKASI SUPPLIER->SUBMIT PICA: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, portal_tgl_terima, 
                to_char((select dd from generate_series(portal_tgl_terima, portal_tgl_terima + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> portal_tgl_terima limit 1 offset 0),'yyyymmddhh24miss') notif_1, 
                to_char((select dd from generate_series(emailpica_1_tgl, emailpica_1_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailpica_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(emailpica_2_tgl, emailpica_2_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailpica_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(coalesce(emailpica_n_tgl, emailpica_3_tgl), coalesce(emailpica_n_tgl, emailpica_3_tgl) + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> coalesce(emailpica_n_tgl, emailpica_3_tgl) limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp 
                from qprs 
                where portal_tgl_terima is not null 
                and to_char(issue_date,'YYYYMM') >= '201905' 
                and not exists (select 1 from picas where picas.issue_no = qprs.issue_no and picas.submit_tgl is not null) 
                and ((emailpica_1_tgl is null or emailpica_2_tgl is null or emailpica_3_tgl is null) or (emailpica_1_tgl is not null and emailpica_2_tgl is not null and emailpica_3_tgl is not null)) 
                ) v, qpr_emails q"))
            ->select(DB::raw("v.issue_no, v.portal_tgl_terima, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp, q.email_1, q.email_2, q.email_3"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("v.kd_supp = q.kd_supp")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            ->orderByRaw("v.portal_tgl_terima")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $emailpica_1_tgl = $qpr->emailpica_1_tgl;
                        $emailpica_2_tgl = $qpr->emailpica_2_tgl;
                        $emailpica_3_tgl = $qpr->emailpica_3_tgl;
                        $emailpica_n_tgl = $qpr->emailpica_n_tgl;

                        $email_1 = $data->email_1;
                        $email_2 = $data->email_2;
                        $email_3 = $data->email_3;

                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        $to = [];
                        $cc = [];
                        $valid_email = "F";
                        if($emailpica_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "1";
                                $list_email = explode(",", $email_1);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($emailpica_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "2";
                                $list_email = explode(",", $email_2);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($emailpica_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "3";
                                $list_email = explode(",", $email_3);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "4";
                            }
                        }

                        $plant = $qpr->plant;

                        if($mode === "1" || $mode === "2" || $mode === "3" || $mode === "4") {
                            if($valid_email === "T") {
                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-approve','qpr-reject'))")
                                ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                                ->get();

                                if($user_cc_emails->count() > 0) {
                                    foreach ($user_cc_emails as $user_cc_email) {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                } else {
                                    if($plant != null) {
                                        if($plant != "1" && $plant != "2" && $plant != "3") {
                                            array_push($cc, "triyono@igp-astra.co.id");
                                        } else {
                                            array_push($cc, "geowana.yuka@igp-astra.co.id");
                                        }
                                    } else {
                                        array_push($cc, "triyono@igp-astra.co.id");
                                        array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    }
                                }

                                array_push($cc, "ajie.priambudi@igp-astra.co.id");
                                array_push($cc, "albertus.janiardi@igp-astra.co.id");
                                array_push($cc, "apip.supendi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                                array_push($cc, "igpprc1_scm@igp-astra.co.id");
                                array_push($cc, "meylati.nuryani@igp-astra.co.id");
                                array_push($cc, "mituhu@igp-astra.co.id");
                                array_push($cc, "qa_igp@igp-astra.co.id");
                                array_push($cc, "qc_igp@igp-astra.co.id");
                                array_push($cc, "qc_lab.igp@igp-astra.co.id");
                                array_push($cc, "qcigp2.igp@igp-astra.co.id");
                                array_push($cc, "risti@igp-astra.co.id");
                                array_push($cc, "sugandi@igp-astra.co.id");

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        array_push($cc, "david.kurniawan@igp-astra.co.id");
                                        array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                        array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                        array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    } else {
                                        array_push($cc, "wawan@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }
                                
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eqc.qprs.emailnotifsubmitpica', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('REMINDER SUBMIT PICA QPR: '.$issue_no);
                                    });
                                } else {
                                    Mail::send('eqc.qprs.emailnotifsubmitpica', compact('qpr','mode'), function ($m) use ($issue_no) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL REMINDER SUBMIT PICA QPR: '.$issue_no);
                                    });
                                }

                                if($mode == "1") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_1_tgl" => Carbon::now(), "emailpica_1" => $email_1]);
                                } else if($mode == "2") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_2_tgl" => Carbon::now(), "emailpica_2" => $email_2]);
                                } else if($mode == "3") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_3_tgl" => Carbon::now(), "emailpica_3" => $email_3]);
                                } else if($mode == "4") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_n_tgl" => Carbon::now(), "emailpica_n" => $email_3]);
                                }

                                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>REMINDER SUBMIT PICA QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL REMINDER SUBMIT PICA QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$qpr->namaSupp($qpr->kd_supp)." (".$qpr->kd_supp.")</strong>\n\n";
                                    $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                    $pesan .= "<strong>Mohon Segera dibuatkan PICA dan di-SUBMIT ke ".strtoupper(config('app.nm_pt', 'Laravel')).".</strong>\n\n";

                                    if(!empty($qpr->portal_pict)) {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    //SECTION HEAD
                                    array_push($cc, "agus.purwanto@igp-astra.co.id");
                                    array_push($cc, "septian@igp-astra.co.id");

                                    $karyawans = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereIn("email", $cc)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($karyawans as $karyawan) {
                                        $data_telegram = array(
                                            'chat_id' => $karyawan->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    //SUPPLIER
                                    $suppliers = DB::table("users")
                                    ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($suppliers as $supplier) {
                                        $data_telegram = array(
                                            'chat_id' => $supplier->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_eksternal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                    echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                    echo "<BR>";
                                }

                                echo "Send email notifikasi ".$issue_no." BERHASIL!";
                                echo "<BR>";
                            } else {
                                echo "Send email notifikasi ".$issue_no." GAGAL! Tidak ada email yang valid!";
                                echo "<BR>";
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            echo "Proses send email notifikasi selesai.";
        } else {
            $url = "https://iaess.igp-astra.co.id/notifikasi/qprs";
            $result = file_get_contents($url);
            echo $result;
        }
    }

    public function qprstrial(Request $request)
    {
        if(config('app.env', 'local') !== 'production') {
            //NOTIFIKASI FM->SH
            echo "Send telegram NOTIFIKASI FM->SH: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, portal_tgl, 
                to_char((select dd from generate_series(portal_tgl, portal_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> portal_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_1,
                to_char((select dd from generate_series(emailsh_1_tgl, emailsh_1_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(emailsh_2_tgl, emailsh_2_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(emailsh_3_tgl, emailsh_3_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailsh_3_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp, portal_sh_tgl 
                from qprs 
                where portal_tgl is not null 
                and to_char(issue_date,'YYYYMM') >= '201903' 
                and portal_sh_tgl is null 
                and portal_sh_tgl_reject is null 
                and portal_tgl_terima is null 
                and portal_tgl_reject is null 
                and ((emailsh_1_tgl is null or emailsh_2_tgl is null or emailsh_3_tgl is null) or (emailsh_1_tgl is not null and emailsh_2_tgl is not null and emailsh_3_tgl is not null))
                ) v"))
            ->select(DB::raw("v.issue_no, v.portal_sh_tgl, v.portal_tgl, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            // ->whereRaw("v.issue_no = 'QUINZA'")
            ->orderByRaw("v.portal_tgl")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $emailsh_1_tgl = $qpr->emailsh_1_tgl;
                        $emailsh_2_tgl = $qpr->emailsh_2_tgl;
                        $emailsh_3_tgl = $qpr->emailsh_3_tgl;
                        
                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        if($emailsh_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "SH_1";
                            }
                        } else if($emailsh_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "SH_2";
                            }
                        } else if($emailsh_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "SH_3";
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "SH_4";
                            }
                        }

                        $plant = $qpr->plant;

                        if($mode === "SH_1" || $mode === "SH_2" || $mode === "SH_3") {
                            $email_sh = "";
                            $to = [];
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-approve','qpr-reject'))")
                            ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                            ->get();

                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                    if($email_sh == "") {
                                        $email_sh = $user_to_email->email;
                                    } else {
                                        $email_sh = $email_sh + "," + $user_to_email->email;
                                    }
                                }
                            } else {
                                if($plant != null) {
                                    if($plant != "1" && $plant != "2" && $plant != "3") {
                                        array_push($to, "triyono@igp-astra.co.id");
                                        $email_sh = "triyono@igp-astra.co.id";
                                    } else {
                                        array_push($to, "geowana.yuka@igp-astra.co.id");
                                        $email_sh = "geowana.yuka@igp-astra.co.id";
                                    }
                                } else {
                                    array_push($to, "triyono@igp-astra.co.id");
                                    array_push($to, "geowana.yuka@igp-astra.co.id");
                                    $email_sh = "triyono@igp-astra.co.id,geowana.yuka@igp-astra.co.id";
                                }
                            }

                            $cc = [];
                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('REMINDER QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL REMINDER QPR: '.$issue_no);
                                });
                            }

                            if($email_sh == "") {
                                $email_sh = null;
                            }

                            if($mode == "SH_1") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_1_tgl" => Carbon::now(), "emailsh_1" => $email_sh]);
                            } else if($mode == "SH_2") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_2_tgl" => Carbon::now(), "emailsh_2" => $email_sh]);
                            } else if($mode == "SH_3") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->update(["emailsh_3_tgl" => Carbon::now(), "emailsh_3" => $email_sh]);
                            }

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            try {
                                // kirim telegram
                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                if(config('app.env', 'local') === 'production') {
                                    $pesan = "<strong>REMINDER QPR</strong>\n\n";
                                    $pesan .= salam().",\n\n";
                                } else {
                                    $pesan = "<strong>TRIAL REMINDER QPR</strong>\n\n";
                                    $pesan .= salam().",\n\n";
                                }
                                $pesan .= "Kepada: <strong>SECTION HEAD</strong>\n\n";
                                $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                $pesan .= "Mohon Segera diproses.\n\n";

                                if(!empty($qpr->portal_pict)) {
                                    $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                } else {
                                    $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                }
                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                $pesan .= "Salam,\n\n";
                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                //SECTION HEAD
                                array_push($to, "agus.purwanto@igp-astra.co.id");
                                array_push($to, "septian@igp-astra.co.id");

                                $karyawans = DB::table("users")
                                ->whereRaw("length(username) = 5")
                                ->whereIn("email", $to)
                                ->whereNotNull("telegram_id")
                                ->whereRaw("length(trim(telegram_id)) > 0")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                ->get();

                                foreach ($karyawans as $karyawan) {
                                    $data_telegram = array(
                                        'chat_id' => $karyawan->telegram_id,
                                        'text'=> $pesan,
                                        'parse_mode'=>'HTML'
                                        );
                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                }
                            } catch (Exception $exception) {
                                echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                echo "<BR>";
                            }

                            echo "Send email notifikasi ".$issue_no." BERHASIL!";
                            echo "<BR>";
                        } else if($mode === "SH_4") {
                            //AUTO APPROVE
                            DB::table("qprs")
                            ->where("issue_no", $issue_no)
                            ->whereNull("portal_sh_tgl")
                            ->whereNull("portal_sh_tgl_reject")
                            ->whereNull("portal_tgl_terima")
                            ->whereNull("portal_tgl_reject")
                            ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => "00000"]);

                            DB::connection('oracle-usrigpmfg')
                            ->table("qpr")
                            ->where("issue_no", $issue_no)
                            ->whereNull("portal_sh_tgl")
                            ->whereNull("portal_sh_tgl_reject")
                            ->whereNull("portal_tgl_terima")
                            ->whereNull("portal_tgl_reject")
                            ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => "00000", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            echo "AUTO APPROVE QPR: ".$issue_no." BERHASIL!";
                            echo "<BR>";

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                            ->get();

                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                }
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            } else {
                                if($plant != null) {
                                    if($plant != "1" && $plant != "2" && $plant != "3") {
                                        array_push($to, "triyono@igp-astra.co.id");
                                    } else {
                                        array_push($to, "geowana.yuka@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($to, "triyono@igp-astra.co.id");
                                    array_push($to, "geowana.yuka@igp-astra.co.id");
                                }
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            }

                            array_push($cc, "ajie.priambudi@igp-astra.co.id");
                            array_push($cc, "albertus.janiardi@igp-astra.co.id");
                            array_push($cc, "apip.supendi@igp-astra.co.id");
                            array_push($cc, "arif.kurnianto@igp-astra.co.id");
                            array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                            array_push($cc, "achmad.fauzi@igp-astra.co.id");
                            array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                            array_push($cc, "igpprc1_scm@igp-astra.co.id");
                            array_push($cc, "meylati.nuryani@igp-astra.co.id");
                            array_push($cc, "mituhu@igp-astra.co.id");
                            array_push($cc, "qa_igp@igp-astra.co.id");
                            array_push($cc, "qc_igp@igp-astra.co.id");
                            array_push($cc, "qc_lab.igp@igp-astra.co.id");
                            array_push($cc, "qcigp2.igp@igp-astra.co.id");
                            array_push($cc, "risti@igp-astra.co.id");
                            array_push($cc, "sugandi@igp-astra.co.id");

                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "triyono@igp-astra.co.id");
                                } else {
                                    array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }
                            } else {
                                array_push($cc, "david.kurniawan@igp-astra.co.id");
                                array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                array_push($cc, "triyono@igp-astra.co.id");
                                array_push($cc, "geowana.yuka@igp-astra.co.id");
                                array_push($cc, "wawan@igp-astra.co.id");
                            }

                            $mode = "SH";
                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SH->SUPPLIER
            echo "Send telegram NOTIFIKASI SH->SUPPLIER: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, coalesce(portal_sh_tgl_no, portal_sh_tgl) portal_sh_tgl_approve, to_char((select dd from generate_series(coalesce(portal_sh_tgl_no, portal_sh_tgl), coalesce(portal_sh_tgl_no, portal_sh_tgl) + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> coalesce(portal_sh_tgl_no, portal_sh_tgl) limit 1 offset 0),'yyyymmddhh24miss') notif_1, 
                to_char((select dd from generate_series(email_1_tgl, email_1_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(email_2_tgl, email_2_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(email_3_tgl, email_3_tgl + '10 day'::interval, '6 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> email_3_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp 
                from qprs 
                where coalesce(portal_sh_tgl_no, portal_sh_tgl) is not null 
                and to_char(issue_date,'YYYYMM') >= '201903' 
                and portal_sh_tgl_reject is null 
                and portal_tgl_terima is null 
                and (portal_tgl_reject is null or (portal_tgl_reject is not null and portal_apr_reject = 'F')) 
                and ((email_1_tgl is null or email_2_tgl is null or email_3_tgl is null) or (email_1_tgl is not null and email_2_tgl is not null and email_3_tgl is not null))
                ) v, qpr_emails q"))
            ->select(DB::raw("v.issue_no, v.portal_sh_tgl_approve, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp, q.email_1, q.email_2, q.email_3"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("v.kd_supp = q.kd_supp")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            // ->whereRaw("v.issue_no = 'QUINZA'")
            ->orderByRaw("v.portal_sh_tgl_approve")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $email_1_tgl = $qpr->email_1_tgl;
                        $email_2_tgl = $qpr->email_2_tgl;
                        $email_3_tgl = $qpr->email_3_tgl;

                        $email_1 = $data->email_1;
                        $email_2 = $data->email_2;
                        $email_3 = $data->email_3;

                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        $to = [];
                        $valid_email = "F";
                        if($email_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "1";
                                $list_email = explode(",", $email_1);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($email_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "2";
                                $list_email = explode(",", $email_2);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($email_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "3";
                                $list_email = explode(",", $email_3);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "4";
                            }
                        }

                        if($mode === "1" || $mode === "2" || $mode === "3") {
                            if($valid_email === "T") {
                                $cc = [];
                                array_push($cc, "ajie.priambudi@igp-astra.co.id");
                                array_push($cc, "albertus.janiardi@igp-astra.co.id");
                                array_push($cc, "apip.supendi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                                array_push($cc, "igpprc1_scm@igp-astra.co.id");
                                array_push($cc, "meylati.nuryani@igp-astra.co.id");
                                array_push($cc, "mituhu@igp-astra.co.id");
                                array_push($cc, "qa_igp@igp-astra.co.id");
                                array_push($cc, "qc_igp@igp-astra.co.id");
                                array_push($cc, "qc_lab.igp@igp-astra.co.id");
                                array_push($cc, "qcigp2.igp@igp-astra.co.id");
                                array_push($cc, "risti@igp-astra.co.id");
                                array_push($cc, "sugandi@igp-astra.co.id");

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        array_push($cc, "david.kurniawan@igp-astra.co.id");
                                        array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                        array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                        array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                        array_push($cc, "triyono@igp-astra.co.id");
                                    } else {
                                        array_push($cc, "geowana.yuka@igp-astra.co.id");
                                        array_push($cc, "wawan@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "triyono@igp-astra.co.id");
                                    array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }

                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('REMINDER QPR: '.$issue_no);
                                    });
                                } else {
                                    Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL REMINDER QPR: '.$issue_no);
                                    });
                                }

                                if($mode == "1") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_1_tgl" => Carbon::now(), "email_1" => $email_1]);
                                } else if($mode == "2") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_2_tgl" => Carbon::now(), "email_2" => $email_2]);
                                } else if($mode == "3") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["email_3_tgl" => Carbon::now(), "email_3" => $email_3]);
                                }

                                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>REMINDER QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL REMINDER QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$qpr->namaSupp($qpr->kd_supp)." (".$qpr->kd_supp.")</strong>\n\n";
                                    $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                    $pesan .= "Mohon Segera diproses.\n\n";

                                    if(!empty($qpr->portal_pict)) {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    //KARYAWAN
                                    $plant = $qpr->plant;
                                    $karyawans = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                                    ->get();

                                    foreach ($karyawans as $karyawan) {
                                        $data_telegram = array(
                                            'chat_id' => $karyawan->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    //SUPPLIER
                                    $suppliers = DB::table("users")
                                    ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($suppliers as $supplier) {
                                        $data_telegram = array(
                                            'chat_id' => $supplier->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_eksternal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                    echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                    echo "<BR>";
                                }

                                echo "Send email notifikasi ".$issue_no." BERHASIL!";
                                echo "<BR>";
                            } else {
                                echo "Send email notifikasi ".$issue_no." GAGAL! Tidak ada email yang valid!";
                                echo "<BR>";
                            }
                        } else if($mode === "4") {
                            //AUTO APPROVE BY SUPPLIER
                            DB::table("qprs")
                            ->where("issue_no", $issue_no)
                            ->whereNotNull("portal_sh_tgl")
                            ->whereNull("portal_tgl_terima")
                            ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => "00000"]);

                            DB::connection('oracle-usrigpmfg')
                            ->table("qpr")
                            ->where("issue_no", $issue_no)
                            ->whereNotNull("portal_sh_tgl")
                            ->whereNull("portal_tgl_terima")
                            ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => "00000", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            echo "AUTO APPROVE SUPPLIER QPR: ".$issue_no." BERHASIL!";
                            echo "<BR>";

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            
                            array_push($to, "qc_lab.igp@igp-astra.co.id");

                            $user_cc_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                            ->get();

                            array_push($cc, "sugandi@igp-astra.co.id");
                            array_push($cc, "arif.kurnianto@igp-astra.co.id");
                            foreach ($user_cc_emails as $user_cc_email) {
                                array_push($cc, $user_cc_email->email);
                            }

                            array_push($bcc, "agus.purwanto@igp-astra.co.id");

                            $mode = "SP";
                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailnotif', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SUPPLIER->SUBMIT PICA
            echo "Send telegram NOTIFIKASI SUPPLIER->SUBMIT PICA: ";
            echo "<BR>";
            $qprs = DB::table(DB::raw("(
                select issue_no, portal_tgl_terima, 
                to_char((select dd from generate_series(portal_tgl_terima, portal_tgl_terima + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> portal_tgl_terima limit 1 offset 0),'yyyymmddhh24miss') notif_1, 
                to_char((select dd from generate_series(emailpica_1_tgl, emailpica_1_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailpica_1_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_2, 
                to_char((select dd from generate_series(emailpica_2_tgl, emailpica_2_tgl + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> emailpica_2_tgl limit 1 offset 0),'yyyymmddhh24miss') notif_3, 
                to_char((select dd from generate_series(coalesce(emailpica_n_tgl, emailpica_3_tgl), coalesce(emailpica_n_tgl, emailpica_3_tgl) + '10 day'::interval, '24 hour'::interval) dd where extract(DOW from dd) not in (6,0) and dd <> coalesce(emailpica_n_tgl, emailpica_3_tgl) limit 1 offset 0),'yyyymmddhh24miss') notif_4, 
                to_char(now(),'yyyymmddhh24miss') sysdate, kd_supp 
                from qprs 
                where portal_tgl_terima is not null 
                and to_char(issue_date,'YYYYMM') >= '201905' 
                and not exists (select 1 from picas where picas.issue_no = qprs.issue_no and picas.submit_tgl is not null) 
                and ((emailpica_1_tgl is null or emailpica_2_tgl is null or emailpica_3_tgl is null) or (emailpica_1_tgl is not null and emailpica_2_tgl is not null and emailpica_3_tgl is not null)) 
                ) v, qpr_emails q"))
            ->select(DB::raw("v.issue_no, v.portal_tgl_terima, v.notif_1, v.notif_2, v.notif_3, v.notif_4, v.sysdate, v.kd_supp, q.email_1, q.email_2, q.email_3"))
            ->whereRaw("(v.notif_1 < v.sysdate or v.notif_2 < v.sysdate or v.notif_3 < v.sysdate)")
            ->whereRaw("v.kd_supp = q.kd_supp")
            ->whereRaw("(to_char(now(),'hh24mi') >= '0700' and to_char(now(),'hh24mi') <= '1700')")
            // ->whereRaw("v.issue_no = 'QUINZA'")
            ->orderByRaw("v.portal_tgl_terima")
            ->get();

            foreach ($qprs as $data) {
                $issue_no = $data->issue_no;
                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();
                if($qpr != null) {
                    try {

                        $mode = "";

                        $emailpica_1_tgl = $qpr->emailpica_1_tgl;
                        $emailpica_2_tgl = $qpr->emailpica_2_tgl;
                        $emailpica_3_tgl = $qpr->emailpica_3_tgl;
                        $emailpica_n_tgl = $qpr->emailpica_n_tgl;

                        $email_1 = $data->email_1;
                        $email_2 = $data->email_2;
                        $email_3 = $data->email_3;

                        if(config('app.env', 'local') === 'production') {
                            $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                    $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }
                        } else {
                            $file = $qpr->portal_pict;
                        }

                        $to = [];
                        $cc = [];
                        $valid_email = "F";
                        if($emailpica_1_tgl == null) {
                            if($data->notif_1 < $data->sysdate) {
                                $mode = "1";
                                $list_email = explode(",", $email_1);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($emailpica_2_tgl == null) {
                            if($data->notif_2 < $data->sysdate) {
                                $mode = "2";
                                $list_email = explode(",", $email_2);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else if($emailpica_3_tgl == null) {
                            if($data->notif_3 < $data->sysdate) {
                                $mode = "3";
                                $list_email = explode(",", $email_3);
                                foreach($list_email as $email) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($to, $email);
                                        $valid_email = "T";
                                    }
                                }
                            }
                        } else {
                            if($data->notif_4 < $data->sysdate) {
                                $mode = "4";
                            }
                        }

                        $plant = $qpr->plant;

                        if($mode === "1" || $mode === "2" || $mode === "3" || $mode === "4") {
                            if($valid_email === "T") {
                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-approve','qpr-reject'))")
                                ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                                ->get();

                                if($user_cc_emails->count() > 0) {
                                    foreach ($user_cc_emails as $user_cc_email) {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                } else {
                                    if($plant != null) {
                                        if($plant != "1" && $plant != "2" && $plant != "3") {
                                            array_push($cc, "triyono@igp-astra.co.id");
                                        } else {
                                            array_push($cc, "geowana.yuka@igp-astra.co.id");
                                        }
                                    } else {
                                        array_push($cc, "triyono@igp-astra.co.id");
                                        array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    }
                                }

                                array_push($cc, "ajie.priambudi@igp-astra.co.id");
                                array_push($cc, "albertus.janiardi@igp-astra.co.id");
                                array_push($cc, "apip.supendi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                                array_push($cc, "igpprc1_scm@igp-astra.co.id");
                                array_push($cc, "meylati.nuryani@igp-astra.co.id");
                                array_push($cc, "mituhu@igp-astra.co.id");
                                array_push($cc, "qa_igp@igp-astra.co.id");
                                array_push($cc, "qc_igp@igp-astra.co.id");
                                array_push($cc, "qc_lab.igp@igp-astra.co.id");
                                array_push($cc, "qcigp2.igp@igp-astra.co.id");
                                array_push($cc, "risti@igp-astra.co.id");
                                array_push($cc, "sugandi@igp-astra.co.id");

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        array_push($cc, "david.kurniawan@igp-astra.co.id");
                                        array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                        array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                        array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    } else {
                                        array_push($cc, "wawan@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }

                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eqc.qprs.emailnotifsubmitpica', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('REMINDER SUBMIT PICA QPR: '.$issue_no);
                                    });
                                } else {
                                    Mail::send('eqc.qprs.emailnotifsubmitpica', compact('qpr','mode'), function ($m) use ($issue_no) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL REMINDER SUBMIT PICA QPR: '.$issue_no);
                                    });
                                }

                                if($mode == "1") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_1_tgl" => Carbon::now(), "emailpica_1" => $email_1]);
                                } else if($mode == "2") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_2_tgl" => Carbon::now(), "emailpica_2" => $email_2]);
                                } else if($mode == "3") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_3_tgl" => Carbon::now(), "emailpica_3" => $email_3]);
                                } else if($mode == "4") {
                                    DB::table("qprs")
                                    ->where("issue_no", $issue_no)
                                    ->update(["emailpica_n_tgl" => Carbon::now(), "emailpica_n" => $email_3]);
                                }

                                $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>REMINDER SUBMIT PICA QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL REMINDER SUBMIT PICA QPR</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$qpr->namaSupp($qpr->kd_supp)." (".$qpr->kd_supp.")</strong>\n\n";
                                    $pesan .= "Berikut Informasi mengenai QPR dengan No: <strong>".$qpr->issue_no."</strong>\n\n";
                                    $pesan .= "<strong>Mohon Segera dibuatkan PICA dan di-SUBMIT ke ".strtoupper(config('app.nm_pt', 'Laravel')).".</strong>\n\n";

                                    if(!empty($qpr->portal_pict)) {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a> atau download melalui link <a href='".str_replace('iaess','vendor', route('qprs.downloadqpr', [base64_encode($qpr->kd_supp), base64_encode($qpr->issue_no)]))."'>Download File QPR</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail QPR tsb silahkan masuk ke <a href='".str_replace('iaess','vendor', url('login'))."'>".str_replace('iaess','vendor', url('login'))."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    //SECTION HEAD
                                    array_push($cc, "agus.purwanto@igp-astra.co.id");
                                    array_push($cc, "septian@igp-astra.co.id");
                                    
                                    $karyawans = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereIn("email", $cc)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($karyawans as $karyawan) {
                                        $data_telegram = array(
                                            'chat_id' => $karyawan->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    //SUPPLIER
                                    $suppliers = DB::table("users")
                                    ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-qpr'))")
                                    ->get();

                                    foreach ($suppliers as $supplier) {
                                        $data_telegram = array(
                                            'chat_id' => $supplier->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_eksternal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                    echo "Send telegram notifikasi ".$issue_no." GAGAL!";
                                    echo "<BR>";
                                }

                                echo "Send email notifikasi ".$issue_no." BERHASIL!";
                                echo "<BR>";
                            } else {
                                echo "Send email notifikasi ".$issue_no." GAGAL! Tidak ada email yang valid!";
                                echo "<BR>";
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Send email notifikasi ".$issue_no." GAGAL!";
                        echo "<BR>";
                    }
                }
            }
            echo "<BR>";

            echo "Proses send email notifikasi selesai.";
        } else {
            return view('errors.403');
        }
    }

    public function baanpo1s(Request $request)
    {
        // php artisan route:call --uri=/notifikasi/baanpo1s

        if(config('app.env', 'local') === 'production') {
            //NOTIFIKASI PIC->SH
            echo "Send telegram NOTIFIKASI PIC->SH: ";
            echo "<BR>";
            $npks = DB::table("baan_po1s")
            ->select(DB::raw("distinct (select npk_sec_head from v_mas_karyawan v where v.npk = baan_po1s.apr_pic_npk limit 1) npk_sec_head"))
            ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                and apr_sh_tgl is null and rjt_sh_tgl is null 
                and apr_dep_tgl is null and rjt_dep_tgl is null 
                and apr_div_tgl is null and rjt_div_tgl is null 
                and to_char(apr_pic_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            ")
            ->get();

            foreach ($npks as $data) {
                $npk_sec_head = $data->npk_sec_head;
                echo $npk_sec_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is null and rjt_sh_tgl is null 
                    and apr_dep_tgl is null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_pic_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                ->where(DB::raw("(select npk_sec_head from v_mas_karyawan v where v.npk = baan_po1s.apr_pic_npk limit 1)"), $npk_sec_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $section_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_sec_head)
                    ->whereNotNull('email')
                    ->first();

                    if($section_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($section_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $section_head->nama." - ".$section_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO SH: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO SH: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO SH: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO SH: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SH->DEP
            echo "Send telegram NOTIFIKASI SH->DEP: ";
            echo "<BR>";
            $npks = DB::table("baan_po1s")
            ->select(DB::raw("distinct (select npk_dep_head from v_mas_karyawan v where v.npk = baan_po1s.apr_sh_npk limit 1) npk_dep_head"))
            ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                and apr_sh_tgl is not null and rjt_sh_tgl is null 
                and apr_dep_tgl is null and rjt_dep_tgl is null 
                and apr_div_tgl is null and rjt_div_tgl is null 
                and to_char(apr_sh_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            ")
            ->get();

            foreach ($npks as $data) {
                $npk_dep_head = $data->npk_dep_head;
                echo $npk_dep_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is not null and rjt_sh_tgl is null 
                    and apr_dep_tgl is null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_sh_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                ->where(DB::raw("(select npk_dep_head from v_mas_karyawan v where v.npk = baan_po1s.apr_sh_npk limit 1)"), $npk_dep_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $dep_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_dep_head)
                    ->whereNotNull('email')
                    ->first();

                    if($dep_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($dep_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $dep_head->nama." - ".$dep_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO DEP: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO DEP: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO DEP: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO DEP: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI DEP->DIV
            echo "Send telegram NOTIFIKASI DEP->DIV: ";
            echo "<BR>";
            // $npks = DB::table("baan_po1s")
            // ->select(DB::raw("distinct (select npk_div_head from v_mas_karyawan v where v.npk = baan_po1s.apr_dep_npk limit 1) npk_div_head"))
            // ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
            //     and apr_sh_tgl is not null and rjt_sh_tgl is null 
            //     and apr_dep_tgl is not null and rjt_dep_tgl is null 
            //     and apr_div_tgl is null and rjt_div_tgl is null 
            //     and to_char(apr_dep_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            // ")
            // ->get();

            // foreach ($npks as $data) {
                // $npk_div_head = $data->npk_div_head;
                $npk_div_head = "20385";
                echo $npk_div_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is not null and rjt_sh_tgl is null 
                    and apr_dep_tgl is not null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_dep_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                //->where(DB::raw("(select npk_div_head from v_mas_karyawan v where v.npk = baan_po1s.apr_dep_npk limit 1)"), $npk_div_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $div_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_div_head)
                    ->whereNotNull('email')
                    ->first();

                    if($div_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($div_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $div_head->nama." - ".$div_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO DIV: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO DIV: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO DIV: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO DIV: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            // }
            echo "<BR>";

            echo "Proses send email notifikasi selesai.";
        } else {
            $url = "https://iaess.igp-astra.co.id/notifikasi/baanpo1s";
            $result = file_get_contents($url);
            echo $result;
        }
    }

    public function baanpo1strial(Request $request)
    {
        if(config('app.env', 'local') !== 'production') {
            //NOTIFIKASI PIC->SH
            echo "Send telegram NOTIFIKASI PIC->SH: ";
            echo "<BR>";
            $npks = DB::table("baan_po1s")
            ->select(DB::raw("distinct (select npk_sec_head from v_mas_karyawan v where v.npk = baan_po1s.apr_pic_npk limit 1) npk_sec_head"))
            ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                and apr_sh_tgl is null and rjt_sh_tgl is null 
                and apr_dep_tgl is null and rjt_dep_tgl is null 
                and apr_div_tgl is null and rjt_div_tgl is null 
                and to_char(apr_pic_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            ")
            ->get();

            foreach ($npks as $data) {
                $npk_sec_head = $data->npk_sec_head;
                echo $npk_sec_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is null and rjt_sh_tgl is null 
                    and apr_dep_tgl is null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_pic_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                ->where(DB::raw("(select npk_sec_head from v_mas_karyawan v where v.npk = baan_po1s.apr_pic_npk limit 1)"), $npk_sec_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $section_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_sec_head)
                    ->whereNotNull('email')
                    ->first();

                    if($section_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($section_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $section_head->nama." - ".$section_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO SH: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO SH: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO SH: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO SH: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI SH->DEP
            echo "Send telegram NOTIFIKASI SH->DEP: ";
            echo "<BR>";
            $npks = DB::table("baan_po1s")
            ->select(DB::raw("distinct (select npk_dep_head from v_mas_karyawan v where v.npk = baan_po1s.apr_sh_npk limit 1) npk_dep_head"))
            ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                and apr_sh_tgl is not null and rjt_sh_tgl is null 
                and apr_dep_tgl is null and rjt_dep_tgl is null 
                and apr_div_tgl is null and rjt_div_tgl is null 
                and to_char(apr_sh_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            ")
            ->get();

            foreach ($npks as $data) {
                $npk_dep_head = $data->npk_dep_head;
                echo $npk_dep_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is not null and rjt_sh_tgl is null 
                    and apr_dep_tgl is null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_sh_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                ->where(DB::raw("(select npk_dep_head from v_mas_karyawan v where v.npk = baan_po1s.apr_sh_npk limit 1)"), $npk_dep_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $dep_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_dep_head)
                    ->whereNotNull('email')
                    ->first();

                    if($dep_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($dep_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $dep_head->nama." - ".$dep_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO DEP: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO DEP: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO DEP: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO DEP: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            }
            echo "<BR>";

            //NOTIFIKASI DEP->DIV
            echo "Send telegram NOTIFIKASI DEP->DIV: ";
            echo "<BR>";
            // $npks = DB::table("baan_po1s")
            // ->select(DB::raw("distinct (select npk_div_head from v_mas_karyawan v where v.npk = baan_po1s.apr_dep_npk limit 1) npk_div_head"))
            // ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
            //     and apr_sh_tgl is not null and rjt_sh_tgl is null 
            //     and apr_dep_tgl is not null and rjt_dep_tgl is null 
            //     and apr_div_tgl is null and rjt_div_tgl is null 
            //     and to_char(apr_dep_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
            // ")
            // ->get();

            // foreach ($npks as $data) {
                // $npk_div_head = $data->npk_div_head;
                $npk_div_head = "20385";
                echo $npk_div_head;
                echo ": ";
                echo "<BR>";

                $baan_po1s = DB::table("baan_po1s")
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("apr_pic_tgl is not null and rjt_pic_tgl is null 
                    and apr_sh_tgl is not null and rjt_sh_tgl is null 
                    and apr_dep_tgl is not null and rjt_dep_tgl is null 
                    and apr_div_tgl is null and rjt_div_tgl is null 
                    and to_char(apr_dep_tgl,'yyyymmdd') < to_char(now(),'yyyymmdd')
                ")
                //->where(DB::raw("(select npk_div_head from v_mas_karyawan v where v.npk = baan_po1s.apr_dep_npk limit 1)"), $npk_div_head)
                ->orderByRaw("tgl_po")
                ->get();

                if($baan_po1s->count() > 0) {
                    $div_head = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, email"))
                    ->where("npk", "=", $npk_div_head)
                    ->whereNotNull('email')
                    ->first();

                    if($div_head != null) {
                        $to = [];
                        $cc = [];
                        $bcc = [];

                        array_push($to, strtolower($div_head->email));
                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                        $nama = $div_head->nama." - ".$div_head->npk;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('Reminder Approval PO DIV: '.Carbon::now()->format('d/m/Y'));
                            });
                        } else {
                            Mail::send('eproc.po.emailnotif', compact('baan_po1s', 'nama'), function ($m) use ($to, $cc, $bcc) {
                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                ->bcc($bcc)
                                ->subject('TRIAL Reminder Approval PO DIV: '.Carbon::now()->format('d/m/Y'));
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Reminder Approval PO DIV: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Reminder Approval PO DIV: ".Carbon::now()->format('d/m/Y')."</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Kepada: <strong>".$nama."</strong>\n\n";
                            $pesan .= "Berikut terdapat beberapa PO yang belum disetujui:\n\n";

                            $no = 0;
                            foreach ($baan_po1s as $baan_po1) {

                                $no = $no + 1;
                                echo $no.". ";
                                echo "No. PO: ".$baan_po1->no_po;
                                echo ", No. Revisi: ".$baan_po1->no_revisi;
                                echo ", Tgl PO: ".Carbon::parse($baan_po1->tgl_po)->format('d/m/Y');
                                echo ", Tgl Kirim: ".Carbon::parse($baan_po1->ddat)->format('d/m/Y');
                                echo ", Supplier: ".$baan_po1->nm_supp;
                                echo "<BR>";

                                $pesan .= $no.". ";
                                $pesan .= $baan_po1->no_po."\n";
                            }
                            $pesan .= "\nMohon Segera diproses.\n\n";
                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                            $pesan .= "Salam,\n\n";
                            $pesan .= "SYSTEM PORTAL\n";
                            $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                }
            // }
            echo "<BR>";

            echo "Proses send email notifikasi selesai.";
        } else {
            return view('errors.403');
        }
    }

    public function proseslaporanlch()
    {
        // php artisan route:call --uri=/notifikasi/proseslaporanlch
        
        if(config('app.env', 'local') === 'production') {
            $tahun = Carbon::now()->format('Y');
            $bulan = Carbon::now()->format('m');
            $msg = "Proses Laporan LCH Alat Angkut Tahun: ".$tahun.", Bulan: ".$bulan." Berhasil!";

            DB::connection("pgsql")->beginTransaction();
            try {
                DB::table("mtct_lch_forklif_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

                $mmtcmesins = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn"))
                ->whereRaw("st_me = 'F' and nvl(st_aktif,'T') = 'T'");

                $mschtgls = DB::connection("oracle-usrintra")
                ->table("usrhrcorp.mschtgl")
                ->select(DB::raw("tgl, bln, thn, ket"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->orderByRaw("tgl");

                $sch = [];
                for ($tanggal = 0; $tanggal <= 30; $tanggal++) {
                    $sch[$tanggal] = "M";
                }

                foreach ($mschtgls->get() as $mschtgl) {
                    $param = $mschtgl->tgl - 1;
                    if($mschtgl->ket === "LB" || $mschtgl->ket === "LR" || $mschtgl->ket === "LA" || $mschtgl->ket === "LC") {
                        $sch[$param] = "L";
                    } else {
                        $sch[$param] = "M";
                    }
                }

                $dtcrea = Carbon::now();
                foreach ($mmtcmesins->get() as $mmtcmesin) {
                    $kd_mesin = $mmtcmesin->kd_mesin;

                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["kd_site"] = "IGPJ";
                    $data_detail["kd_forklif"] = $kd_mesin;
                    $data_detail["dtcrea"] = $dtcrea;
                    $data_detail["creaby"] = Auth::user()->username;

                    for ($shift = 1; $shift <= 3; $shift++) {
                        $param_shift = $shift . "";
                        for ($tgl = 1; $tgl <= 31; $tgl++) {
                            $param_tgl = $tgl;
                            if ($tgl < 10) {
                                $param_tgl = "0" . $tgl;
                            }

                            $yyyymmdd = $tahun . "" . $bulan . "" . $param_tgl;

                            $mtct_lch_forklif1 = DB::table("mtct_lch_forklif1s")
                                ->select(DB::raw("id, st_unit, (select 'F' from mtct_lch_forklif2s where mtct_lch_forklif2s.mtct_lch_forklif1_id = mtct_lch_forklif1s.id and st_cek = 'F' limit 1) status"))
                                ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), $yyyymmdd)
                                ->where("kd_forklif", $kd_mesin)
                                ->where("shift", $param_shift)
                                ->first();

                            if ($mtct_lch_forklif1 != null) {
                                if($mtct_lch_forklif1->st_unit != null) {
                                    if($mtct_lch_forklif1->st_unit === "OVERHOUL") {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."M";
                                    } else if($mtct_lch_forklif1->st_unit === "UNIT OFF") {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."B";
                                    } else {
                                        if ($mtct_lch_forklif1->status != null) {
                                            $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."K";
                                        } else {
                                            $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."H";
                                        }
                                    }
                                } else {
                                    if ($mtct_lch_forklif1->status != null) {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."K";
                                    } else {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."H";
                                    }
                                }
                            } else {
                                $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."I";
                            }
                        }
                    }

                    DB::table("mtct_lch_forklif_reps")->insert($data_detail);
                }

                DB::connection("pgsql")->commit();
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                $msg = "Proses Laporan LCH Alat Angkut Tahun: ".$tahun.", Bulan: ".$bulan." Gagal! ".$ex;
            }
            echo $msg;
        } else {
            $url = "https://iaess.igp-astra.co.id/notifikasi/proseslaporanlch";
            $result = file_get_contents($url);
            echo $result;
        }
    }
}
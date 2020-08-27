<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pistandard;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use Session;
use exception;
use Carbon\Carbon;
use DB;
use App\User;
use Alert;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;


class PisstaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aprovalstaf(Request $request, Builder $htmlBuilder)
    {
        //
       if ($request->ajax()) {
            $pistandards = DB::table("pistandards")
             ->whereIn('status',[1,2,3]) 
             ->select(DB::raw("no_pisigp, no_pis, model, part_no, part_name, nama_supplier, status, max(norev) norev"))
             ->groupBy(DB::raw("no_pisigp, no_pis, model, part_no, part_name, nama_supplier, status"))
             ->get();

            return Datatables::of($pistandards)
            ->editColumn('status', function($pistandard){
              if($pistandard->status == 0){
                   return '<b class="btn-xs btn-info btn-icon-pg" action="disable"> Belum Submit</b>';
                }
                elseif($pistandard->status == 1){
                   return '<b class="btn-xs btn-info btn-icon-pg"  action="disable"> Belum Approv </b>';
                }
                elseif($pistandard->status == 2){
                   return '<b class="btn-xs btn-success btn-icon-pg"  action="disable"> Disetujui </b>';
                }
                elseif($pistandard->status == 3){
                   return '<b class="btn-xs btn-danger btn-icon-pg" action="disable"> Ditolak</b>';
                }
            })

            ->editColumn('no_pis', function($pistandard) {
                return '<a href="'.route('pisstaff.show', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="check Document No Pis '. $pistandard->no_pis .'">'.$pistandard->no_pis.'</a>';
            })

          

            ->addColumn('action', function($pistandard){
                if ($pistandard->status == 1) {
                     return ([
                      
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print/Preview " class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="'.route('pisdepthead.unlock', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Unlock for editing" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>']);
                     
                }elseif ($pistandard->status == 2) {
                     return ([
                      
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print/Preview " class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="'.route('pisdepthead.unlock', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Unlock for editing" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>']);

                }elseif ($pistandard->status == 3) {
                     return (['<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print/Preview" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>']);   
                }
            })

            ->editColumn('rev_doc', function($pistandard){
                  return "Rev.".$pistandard->norev;
             })->make(true);
        
        } 
        return view('pis.staff.aprovalstaf')->with(compact('$pistandard'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */        


    public function index()
    {
        //
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
       $data = $request->all();
       $no_pisigp = $data['no_pisigp']; 
       $no_pis = $data['no_pis'];   
       $norev = $data['norev']; 
       $submit = $data['submit']; 

       $date = Carbon::now()->format('d-m-Y');    
       $time = Carbon::now()->format('h:i:s'); 
       $jamTgl = $date." ".$time;
       $jamTgl=date("Y-m-d h:i:s",strtotime($jamTgl)); 
       $data['tgl_submit'] = $jamTgl; 

       $date = Carbon::now()->format('d-m-Y');    
       $time = Carbon::now()->format('h:i:s'); 
       $jamTgl = $date." ".$time;
       $jamTgl=date("Y-m-d h:i:s",strtotime($jamTgl)); 
       $data['tgl_draft'] = $jamTgl;

       $date = Carbon::now()->format('d-m-Y');    
       $time = Carbon::now()->format('h:i:s'); 
       $jamTgl = $date." ".$time;
       $jamTgl=date("Y-m-d h:i:s",strtotime($jamTgl)); 
       $data['tanggal'] = $jamTgl;

       $linehidden = trim($data['linehidden']) !== '' ? trim($data['linehidden']) : '0';
       $linehidden1 = trim($data['linehidden1']) !== '' ? trim($data['linehidden1']) : '0';
       $linehidden2 = trim($data['linehidden2']) !== '' ? trim($data['linehidden2']) : '0';
       $linehidden3 = trim($data['linehidden3']) !== '' ? trim($data['linehidden3']) : '0';
       $linehidden4 = trim($data['linehidden4']) !== '' ? trim($data['linehidden4']) : '0';
       $linehidden5 = trim($data['linehidden5']) !== '' ? trim($data['linehidden5']) : '0';
       $linehidden6 = trim($data['linehidden6']) !== '' ? trim($data['linehidden6']) : '0';
       $linehidden7 = trim($data['linehidden7']) !== '' ? trim($data['linehidden7']) : '0';

       $entity = new Pistandard;
       $pistandard = DB::table('pistandards')
       ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
       ->where(DB::raw("norev"), '=', $norev)
       ->first(); 

            // no_rev otomatis
       $nourutakhir=DB::table("pistandards")
       ->where("no_pisigp")
       ->max("norev");
       $nourut=$nourutakhir;
       $nourut++;
       $new_no_doc['norev']= $nourut;

        // echo $new_no_doc['submit'];
        // die();
        //upload ttd logo supplier
       $filename1 = $pistandard->logo_supplier;
           if ($request->hasFile('logo_supplier')) {
                $uploaded_cover = $request->file('logo_supplier');
                $extension = $uploaded_cover->getClientOriginalExtension();
                $filename1 = md5(time()) . '.' . $extension;
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\logospy";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\logospy";
                }
                $img = Image::make($uploaded_cover->getRealPath());
                if($img->filesize()/1024 > 1024) {
                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename1, 75);
                } else {
                    $uploaded_cover->move($destinationPath, $filename1);
                }
            }

           // SKETCHDRWAING1
            $filename5 = $pistandard->sketchdrawing;
            if ($request->hasFile('sketchdrawing')) {
              $uploaded_cover = $request->file('sketchdrawing');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename5 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\gambar1";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar1";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename5, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename5);
              }
            }

            // SKETCHDRWAING2
            $filename6 = $pistandard->sketchmmethode;
            if ($request->hasFile('sketchmmethode')) {
              $uploaded_cover = $request->file('sketchmmethode');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename6 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\gambar2";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar2";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename6, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename6);
              }
            }

             // SKETCHDRWAING3
            $filename7 = $pistandard->sketchappearance;
            if ($request->hasFile('sketchappearance')) {
              $uploaded_cover = $request->file('sketchappearance');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename7 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\gambar3";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar3";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename7, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename7);
              }
            }

            // Part Routing
            $filename8 = $pistandard->part_routing;
            if ($request->hasFile('part_routing')) {
              $uploaded_cover = $request->file('part_routing');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename8 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\part_routing";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\part_routing";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename8, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename8);
              }
            }

              //upload ttd staff supplier
            $filename2 = $pistandard->staff_spy;
            if ($request->hasFile('staff_spy')) {
              $uploaded_cover = $request->file('staff_spy');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename2 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\staff_spy";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\staff_spy";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename2, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename2);
              }
            }

              //upload ttd spv supplier
            $filename3 = $pistandard->supervisor_spy;
            if ($request->hasFile('supervisor_spy')) {
              $uploaded_cover = $request->file('supervisor_spy');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename3 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\supervisor_spy";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\supervisor_spy";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename3, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename3);
              }
            }

            //upload ttd menejer supplier
             $filename4 = $pistandard->manager_spy;
            if ($request->hasFile('manager_spy')) {
              $uploaded_cover = $request->file('manager_spy');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename4 = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\manager_spy";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\manager_spy";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename4, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename4);
              }
            }

       $pistandard = DB::table('pistandards')
       ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
       ->where(DB::raw("norev"), '=', $norev)
       ->first();
       $dateissue=$pistandard->date_issue;

        DB::table("pistandards")
        ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
        ->where(DB::raw("norev"), '=', $norev)
        ->update(['status'=>5,]); 

        switch ($request->input('post')){

            case 'savekuy': 
                  //action savekuy
                  DB::table("pistandards")
                      ->insert([
                             'no_pisigp'=>$request->no_pisigp,
                             'no_pis'=>$request->no_pis,
                             'model'=>$request->model,
                             'part_no'=>$request->part_no,
                             'part_name'=>$request->part_name,
                             'nama_supplier'=>$request->nama_supplier,
                             'email'=>$request->email,
                             'kode_supp'=>$request->kode_supp,
                             'reff_no'=>$request->reff_no,
                             'material'=>$request->material,
                             'general_tol'=>json_encode($request->general_tol),
                             'weight'=>$request->weight,
                             'supp_dept'=>$request->supp_dept,
                             'status'=>1,
                             'submit'=>1,
                             'date_issue'=>$dateissue,
                             'tgl_submit'=> $data['tgl_submit'],
                             'status_doc'=>$request->status_doc,
                             'norev'=> $new_no_doc['norev'],
                             'status_doc'=>$request->status_doc,
                             'logo_supplier'=>$request->logo_supplier = $filename1,
                             'sketchdrawing'=>$request->sketchdrawing = $filename5,
                             'sketchmmethode'=>$request->sketchmmethode = $filename6,
                             'sketchappearance'=>$request->sketchappearance = $filename7,
                             'staff_spy'=>$request->staff_spy = $filename2,
                             'supervisor_spy'=>$request->supervisor_spy = $filename3,
                             'manager_spy'=>$request->manager_spy = $filename4,
                             'part_routing'=>$request->part_routing = $filename8,
                             'staff_name'=>$request->staff_name,
                             'supervisor_name'=>$request->supervisor_name,
                             'manager_name'=>$request->manager_name,
                             'c_logosupplier'=>$request->c_logosupplier,
                             'c_nopis'=>$request->c_nopis,
                             'c_supname'=>$request->c_supname,
                             'c_dateissue'=>$request->c_dateissue,
                             'c_model'=>$request->c_model,
                             'c_refno'=>$request->c_refno,
                             'c_material'=>$request->c_material,
                             'c_generaltol'=>json_encode($request->c_generaltol),
                             'c_weight'=>$request->c_weight,
                             'c_partno'=>$request->c_partno,
                             'c_partname'=>$request->c_partname,
                             'c_stat_doc'=>$request->c_stat_doc,
                             'c_supp_dept'=>$request->c_supp_dept,
                            
                            
                              ]);        

             //      $to = [];
             //      array_push($to, "fadlya179@gmail.com");
             //      $pis=$request->no_pis;
             //      $tgl= $data['tgl_submit'];
             //      $supplier= $request->nama_supplier;
             //      Mail::send('pis.supplier.emailsubmit', compact('pis','tgl','supplier'), function ($m) use ($to, $no_pis) {
             //        $m->to($to)
             //        ->subject('PIS: '.$no_pis);
             // });     

              Alert::success("Berhasil Submit","Nomor $request->no_pis")
              ->autoclose(2000000)
              ->persistent("Close");
            break;
            case 'draftkuy': 
             //action for save-draft REVISI here
                  DB::table("pistandards")
                      ->insert([
                                'no_pisigp'=>$request->no_pisigp,
                                'no_pis'=>$request->no_pis,
                                'model'=>$request->model,
                                'part_no'=>$request->part_no,
                                'part_name'=>$request->part_name,
                                'nama_supplier'=>$request->nama_supplier,
                                'email'=>$request->email,
                                'kode_supp'=>$request->kode_supp,
                                'reff_no'=>$request->reff_no,
                                'date_issue'=>$dateissue,
                                'material'=>$request->material,
                                'general_tol'=>json_encode($request->general_tol),
                                'weight'=>$request->weight,
                                'supp_dept'=>$request->supp_dept,
                                'tgl_draft'=>$data['tgl_draft'],
                                'status_doc'=>$request->status_doc,
                                'norev'=> $new_no_doc['norev'],
                                'status_doc'=>$request->status_doc,
                                'logo_supplier'=>$request->logo_supplier = $filename1,
                                'sketchdrawing'=>$request->sketchdrawing = $filename5,
                                'sketchmmethode'=>$request->sketchmmethode = $filename6,
                                'sketchappearance'=>$request->sketchappearance = $filename7,
                                'staff_spy'=>$request->staff_spy = $filename2,
                                'supervisor_spy'=>$request->supervisor_spy = $filename3,
                                'manager_spy'=>$request->manager_spy = $filename4,
                                'part_routing'=>$request->part_routing = $filename8,
                                'staff_name'=>$request->staff_name,
                                'supervisor_name'=>$request->supervisor_name,
                                'manager_name'=>$request->manager_name,
                                'c_logosupplier'=>$request->c_logosupplier,
                                'c_nopis'=>$request->c_nopis,
                                'c_supname'=>$request->c_supname,
                                'c_dateissue'=>$request->c_dateissue,
                                'c_model'=>$request->c_model,
                                'c_refno'=>$request->c_refno,
                                'c_material'=>$request->c_material,
                                'c_generaltol'=>json_encode($request->c_generaltol),
                                'c_weight'=>$request->c_weight,
                                'c_partno'=>$request->c_partno,
                                'c_partname'=>$request->c_partname,
                                'c_stat_doc'=>$request->c_stat_doc,
                                'c_supp_dept'=>$request->c_supp_dept,
                            ]);  

                  Alert::success("Data Disimpan Sebagai Draft","Nomor $request->no_pis")
                  ->autoclose(2000000)
                  ->persistent("Close");  
            break;
        }


         /////CHEMICAL COMPOSITION
        for ($i = 1; $i <= $linehidden; $i++) {
              $cno = trim($data['cno_'.$i]) !== '' ? trim($data['cno_'.$i]) : '';
              $citem = trim($data['citem_'.$i]) !== '' ? trim($data['citem_'.$i]) : '';
              $cnom = trim($data['cnom_'.$i]) !== '' ? trim($data['cnom_'.$i]) : '';
              $ctol = trim($data['ctol_'.$i]) !== '' ? trim($data['ctol_'.$i]) : '';
              $cins = trim($data['cins_'.$i]) !== '' ? trim($data['cins_'.$i]) : '';
              $crank = trim($data['crank_'.$i]) !== '' ? trim($data['crank_'.$i]) : '';
              $cpro = trim($data['cpro_'.$i]) !== '' ? trim($data['cpro_'.$i]) : '';
              $cdel = trim($data['cdel_'.$i]) !== '' ? trim($data['cdel_'.$i]) : '';
              $crem = trim($data['crem_'.$i]) !== '' ? trim($data['crem_'.$i]) : '';
              $a_item = trim($data['a_item_'.$i]) !== '' ? trim($data['a_item_'.$i]) : '';
              $a_nominal = trim($data['a_nominal_'.$i]) !== '' ? trim($data['a_nominal_'.$i]) : '';
              $a_tolerance = trim($data['a_tolerance_'.$i]) !== '' ? trim($data['a_tolerance_'.$i]) : '';
              $a_instrument = trim($data['a_instrument_'.$i]) !== '' ? trim($data['a_instrument_'.$i]) : '';
              $a_rank = trim($data['a_rank_'.$i]) !== '' ? trim($data['a_rank_'.$i]) : '';
              $a_proses = trim($data['a_proses_'.$i]) !== '' ? trim($data['a_proses_'.$i]) : '';
              $a_delivery = trim($data['a_delivery_'.$i]) !== '' ? trim($data['a_delivery_'.$i]) : '';
              $a_remarks = trim($data['a_remarks_'.$i]) !== '' ? trim($data['a_remarks_'.$i]) : '';
               // no_doc otomatis
              
             
               DB::table("pisccompositions")
              ->insert([
                  'no_pisigp'=>$request->no_pisigp,
                  'no_pis'=>$request->no_pis,
                  'no' =>$cno,
                  'item' =>$citem,
                  'nominal' =>$cnom,
                  'tolerance' => $ctol,
                  'instrument' => $cins,
                  'rank' => $crank,
                  'proses' => $cpro,
                  'delivery' => $cdel,
                  'remarks' => $crem,
                  'norev'=> $new_no_doc['norev'],
                  'a_item' =>$a_item,
                  'a_nominal' =>$a_nominal,
                  'a_tolerance' => $a_tolerance,
                  'a_instrument' => $a_instrument,
                  'a_rank' => $a_rank,
                  'a_proses' => $a_proses,
                  'a_delivery' => $a_delivery,
                  'a_remarks' => $a_remarks,
                    
                  ]);   
             
           }

        
         // echo json_encode($pistandard) ;
         //   die();
         return redirect()->route('pistandards.index');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($no_pisigp,$norev)
    {
          $no_pisigp = base64_decode($no_pisigp); 
          $norev = base64_decode($norev); 
         $pistandards = DB::table('pistandards')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->where(DB::raw("norev"), '=', $norev)
                    ->first(); 

               
         $composition = DB::table('pisccompositions')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

         $properties = DB::table('pismproperties')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $performances = DB::table('piswperformances')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $treatements = DB::table('pisstreatements')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $htreatements = DB::table('pishtreatements')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $appearences = DB::table('pisappearences')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $dimentions = DB::table('pisdimentions')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $socfs = DB::table('pissocfs')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $routs = DB::table('pisroutes')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();
           $revisi = DB::table('pisrevisions')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->first();

             $logo_supplier = "";
            if (!empty($pistandards->logo_supplier)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."logospy".DIRECTORY_SEPARATOR.$pistandard->logo_supplier;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\logospy\\".$pistandards->logo_supplier;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $logo_supplier = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $staff_spy = "";
            if (!empty($pistandards->staff_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."staff_spy".DIRECTORY_SEPARATOR.$pistandards->staff_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\staff_spy\\".$pistandards->staff_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $staff_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }


             $supervisor_spy = "";
            if (!empty($pistandards->supervisor_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."supervisor_spy".DIRECTORY_SEPARATOR.$pistandards->supervisor_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\supervisor_spy\\".$pistandards->supervisor_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $supervisor_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             $manager_spy = "";
            if (!empty($pistandards->manager_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."manager_spy".DIRECTORY_SEPARATOR.$pistandards->manager_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\manager_spy\\".$pistandards->manager_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $manager_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            //sketcdrawing1
            $sketchdrawing = "";
            if (!empty($pistandards->sketchdrawing)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar1".DIRECTORY_SEPARATOR.$pistandards->sketchdrawing;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar1\\".$pistandards->sketchdrawing;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchdrawing = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             //sketchmmethode
            $sketchmmethode = "";
            if (!empty($pistandards->sketchmmethode)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar2".DIRECTORY_SEPARATOR.$pistandards->sketchmmethode;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar2\\".$pistandards->sketchmmethode;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchmmethode = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }


            //sketchappearance
            $sketchappearance = "";
            if (!empty($pistandards->sketchappearance)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar3".DIRECTORY_SEPARATOR.$pistandards->sketchappearance;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar3\\".$pistandards->sketchappearance;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchappearance = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            //approve_staff
            $approve_staff = "";
            if (!empty($pistandards->approve_staff)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."staffigp".DIRECTORY_SEPARATOR.$pistandards->approve_staff;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\staffigp\\".$pistandards->approve_staff;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $approve_staff = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             $approve_sect = "";
            if (!empty($pistandards->approve_sect)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."secthead".DIRECTORY_SEPARATOR.$pistandards->approve_sect;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\secthead\\".$pistandards->approve_sect;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $approve_sect = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             $approve_dept = "";
            if (!empty($pistandards->approve_dept)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."depthead".DIRECTORY_SEPARATOR.$pistandards->approve_dept;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\depthead\\".$pistandards->approve_dept;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $approve_dept = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
            
             $part_routing = "";
            if (!empty($pistandards->part_routing)) {
              if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."part_routing".DIRECTORY_SEPARATOR.$pistandards->part_routing;
              } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\part_routing\\".$pistandards->part_routing;
              }

              if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $part_routing = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
              }
            }
            $entity = new Pistandard();
            
             // echo json_encode($pistandards->c_refno) ;
            // die();

       return view('pis.staff.upload')->with(compact(['approve_dept','approve_sect','approve_staff','sketchdrawing','sketchmmethode','sketchappearance','manager_spy','supervisor_spy','staff_spy','logo_supplier','pistandards','composition','properties','performances','treatements','htreatements','appearences','dimentions','socfs','routs','revisi', 'entity','no_pisigp','logo_supplier','staff_spy','supervisor_spy','manager_spy','part_routing']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($no_pisigp,$norev)
    {
       $no_pisigp = base64_decode($no_pisigp); 
        $norev = base64_decode($norev); 
       $pistandard = DB::table('pistandards')
       ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
       ->where(DB::raw("norev"), '=', $norev)
       ->first();  

       $composition = DB::table('pisccompositions')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();
         

        $entity = new Pistandard();

        echo json_encode($composition) ;
            die();


       return view('pis.staff.upload')->with(compact('pistandard'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
       
        $data = $request->all();
        $norev = trim($data['norev']) !== '' ? trim($data['norev']) : null;
        $no_pisigp = trim($data['no_pisigp']) !== '' ? trim($data['no_pisigp']) : null;
       
        $c_model = trim($data['c_model']) !== '' ? trim($data['c_model']) : null;
        $c_refno = trim($data['c_refno']) !== '' ? trim($data['c_refno']) : null;
        $c_material = trim($data['c_material']) !== '' ? trim($data['c_material']) : null;
        $c_weight = trim($data['c_weight']) !== '' ? trim($data['c_weight']) : null;
        $c_partno = trim($data['c_partno']) !== '' ? trim($data['c_partno']) : null;
        $c_part_name = trim($data['c_partname']) !== '' ? trim($data['c_partname']) : null;
        $c_supp_dept = trim($data['c_supp_dept']) !== '' ? trim($data['c_supp_dept']) : null;
        $c_stat_doc = trim($data['c_stat_doc']) !== '' ? trim($data['c_stat_doc']) : null;
        $c_partrouting = trim($data['c_partrouting']) !== '' ? trim($data['c_partrouting']) : null;
        $c_skecthdrawing = trim($data['c_skecthdrawing']) !== '' ? trim($data['c_skecthdrawing']) : null;
        $c_sketchmethod = trim($data['c_sketchmethod']) !== '' ? trim($data['c_sketchmethod']) : null;

        $linehidden = trim($data['linehidden']) !== '' ? trim($data['linehidden']) : '0';
        $linehidden1 = trim($data['linehidden1']) !== '' ? trim($data['linehidden1']) : '0';
        $linehidden2 = trim($data['linehidden2']) !== '' ? trim($data['linehidden2']) : '0';
        $linehidden3 = trim($data['linehidden3']) !== '' ? trim($data['linehidden3']) : '0';
        $linehidden4 = trim($data['linehidden4']) !== '' ? trim($data['linehidden4']) : '0';
        $linehidden5 = trim($data['linehidden5']) !== '' ? trim($data['linehidden5']) : '0';
        $linehidden6 = trim($data['linehidden6']) !== '' ? trim($data['linehidden6']) : '0';
        $linehidden7 = trim($data['linehidden7']) !== '' ? trim($data['linehidden7']) : '0';
        


        $pistandard = DB::table('pistandards')
                      ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                      ->first(); 

           $filename = $pistandard->approve_staff;
            if ($request->hasFile('approve_staff')) {
              $uploaded_cover = $request->file('approve_staff');
              $extension = $uploaded_cover->getClientOriginalExtension();
              $filename = md5(time()) . '.' . $extension;
              if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis\\staffigp";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\staffigp";
              }
              $img = Image::make($uploaded_cover->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
              } else {
                $uploaded_cover->move($destinationPath, $filename);
              }
            }
            $entity = new Pistandard();
          

        DB::table('pistandards')
            ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
            ->where(DB::raw("norev"), '=', $norev)
            ->Update([
                      'approve_staff'=>$request->approve_staff = $filename,
                      'igpstaff_nm'=>$request->igpstaff_nm,
                      'c_model'=>$request->c_model,
                      'c_refno'=>$request->c_refno,
                      'c_material'=>$request->c_material,
                      'c_generaltol'=>json_encode($request->c_generaltol),
                      'c_weight'=>$request->c_weight,
                      'c_partno'=>$request->c_partno,
                      'c_partname'=>$request->c_part_name,
                      'c_supp_dept'=>$request->c_supp_dept,
                      'c_stat_doc'=>$request->c_stat_doc,
                      'c_partrouting'=>$request->c_partrouting,
                      'c_skecthdrawing'=>$request->c_skecthdrawing,
                      'c_sketchmethod'=>$request->c_sketchmethod,
                      ]); 

               /////A. CHEMICAL COMPOSITION
            for ($i = 1; $i <= $linehidden; $i++) {
                 $cno = trim($data['cno_'.$i]) !== '' ? trim($data['cno_'.$i]) : '';
                 $a_item = trim($data['a_item_'.$i]) !== '' ? trim($data['a_item_'.$i]) : '';
                 $a_nominal = trim($data['a_nominal_'.$i]) !== '' ? trim($data['a_nominal_'.$i]) : '';
                 $a_tolerance = trim($data['a_tolerance_'.$i]) !== '' ? trim($data['a_tolerance_'.$i]) : '';
                 $a_instrument = trim($data['a_instrument_'.$i]) !== '' ? trim($data['a_instrument_'.$i]) : '';
                 $a_rank = trim($data['a_rank_'.$i]) !== '' ? trim($data['a_rank_'.$i]) : '';
                 $a_proses = trim($data['a_proses_'.$i]) !== '' ? trim($data['a_proses_'.$i]) : '';
                 $a_delivery = trim($data['a_delivery_'.$i]) !== '' ? trim($data['a_delivery_'.$i]) : '';
                 $a_remarks = trim($data['a_remarks_'.$i]) !== '' ? trim($data['a_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                         $cekModelLine = $entity->cekModelLine($no_pisigp,$cno);
                         if($cekModelLine->count() > 0) {
                            DB::table("pisccompositions")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $cno)
                              ->update([ 'a_item' =>$a_item,
                                         'a_nominal' =>$a_nominal,
                                         'a_tolerance' => $a_tolerance,
                                         'a_instrument' => $a_instrument,
                                         'a_rank' => $a_rank,
                                         'a_proses' => $a_proses,
                                         'a_delivery' => $a_delivery,
                                         'a_remarks' => $a_remarks,
                                         ]);
                          } 
                          else{
                            
                        }
                     }
            }

             /////B.MECHANICAL PROPERTIES
            for ($i = 1; $i <= $linehidden1; $i++) {
                $mno = trim($data['mno_'.$i]) !== '' ? trim($data['mno_'.$i]) : '';
                $b_item = trim($data['b_item_'.$i]) !== '' ? trim($data['b_item_'.$i]) : '';
                $b_nominal = trim($data['b_nominal_'.$i]) !== '' ? trim($data['b_nominal_'.$i]) : '';
                $b_tolerance = trim($data['b_tolerance_'.$i]) !== '' ? trim($data['b_tolerance_'.$i]) : '';
                $b_instrument = trim($data['b_instrument_'.$i]) !== '' ? trim($data['b_instrument_'.$i]) : '';
                $b_rank = trim($data['b_rank_'.$i]) !== '' ? trim($data['b_rank_'.$i]) : '';
                $b_proses = trim($data['b_proses_'.$i]) !== '' ? trim($data['b_proses_'.$i]) : '';
                $b_delivery = trim($data['b_delivery_'.$i]) !== '' ? trim($data['b_delivery_'.$i]) : '';
                $b_remarks = trim($data['b_remarks_'.$i]) !== '' ? trim($data['b_remarks_'.$i]) : '';
                 if ($no_pisigp !== ''){
                     $cekModelLine1 = $entity->cekModelLine1($no_pisigp,$mno);
                     if($cekModelLine1->count() > 0) {
                        DB::table("pismproperties")
                          ->where("no_pisigp", $no_pisigp)
                          ->where("no", $mno)
                          ->update(['b_item' =>$b_item,
                                   'b_nominal' =>$b_nominal,
                                   'b_tolerance' => $b_tolerance,
                                   'b_instrument' => $b_instrument,
                                   'b_rank' => $b_rank,
                                   'b_proses' => $b_proses,
                                   'b_delivery' => $b_delivery,
                                   'b_remarks' => $b_remarks,
                                     ]);
                      } 
                    else{
                        
                    }
                 }
            }

             ////C. WELDING PERFORMANCE (IF ANY)
            for ($i = 1; $i <= $linehidden2; $i++) {
                 $wno = trim($data['wno_'.$i]) !== '' ? trim($data['wno_'.$i]) : '';
                 $c_item = trim($data['c_item_'.$i]) !== '' ? trim($data['c_item_'.$i]) : '';
                 $c_nominal = trim($data['c_nominal_'.$i]) !== '' ? trim($data['c_nominal_'.$i]) : '';
                 $c_tolerance = trim($data['c_tolerance_'.$i]) !== '' ? trim($data['c_tolerance_'.$i]) : '';
                 $c_instrument = trim($data['c_instrument_'.$i]) !== '' ? trim($data['c_instrument_'.$i]) : '';
                 $c_rank = trim($data['c_rank_'.$i]) !== '' ? trim($data['c_rank_'.$i]) : '';
                 $c_proses = trim($data['c_proses_'.$i]) !== '' ? trim($data['c_proses_'.$i]) : '';
                 $c_delivery = trim($data['c_delivery_'.$i]) !== '' ? trim($data['c_delivery_'.$i]) : '';
                 $c_remarks = trim($data['c_remarks_'.$i]) !== '' ? trim($data['c_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                           $cekModelLine2 = $entity->cekModelLine2($no_pisigp,$wno);
                         if($cekModelLine2->count() > 0) {
                            DB::table("piswperformances")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['c_item' =>$c_item,
                                       'c_nominal' =>$c_nominal,
                                       'c_tolerance' => $c_tolerance,
                                       'c_instrument' => $c_instrument,
                                       'c_rank' => $c_rank,
                                       'c_proses' => $c_proses,
                                       'c_delivery' => $c_delivery,
                                       'c_remarks' => $c_remarks,
                                         ]);
                          } 
                        else{
                            
                        }
                     }
            }

             ////D. SURFACE TREATMENT (IF ANY)
            for ($i = 1; $i <= $linehidden3; $i++) {
                 $sno = trim($data['sno_'.$i]) !== '' ? trim($data['sno_'.$i]) : '';
                 $d_item = trim($data['d_item_'.$i]) !== '' ? trim($data['d_item_'.$i]) : '';
                 $d_nominal = trim($data['d_nominal_'.$i]) !== '' ? trim($data['d_nominal_'.$i]) : '';
                 $d_tolerance = trim($data['d_tolerance_'.$i]) !== '' ? trim($data['d_tolerance_'.$i]) : '';
                 $d_instrument = trim($data['d_instrument_'.$i]) !== '' ? trim($data['d_instrument_'.$i]) : '';
                 $d_rank = trim($data['d_rank_'.$i]) !== '' ? trim($data['d_rank_'.$i]) : '';
                 $d_proses = trim($data['d_proses_'.$i]) !== '' ? trim($data['d_proses_'.$i]) : '';
                 $d_delivery = trim($data['d_delivery_'.$i]) !== '' ? trim($data['d_delivery_'.$i]) : '';
                 $d_remarks = trim($data['d_remarks_'.$i]) !== '' ? trim($data['d_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                        $cekModelLine3 = $entity->cekModelLine3($no_pisigp,$sno);
                         if($cekModelLine3->count() > 0) {
                            DB::table("pisstreatements")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['d_item' =>$d_item,
                                       'd_nominal' =>$d_nominal,
                                       'd_tolerance' => $d_tolerance,
                                       'd_instrument' => $d_instrument,
                                       'd_rank' => $d_rank,
                                       'd_proses' => $d_proses,
                                       'd_delivery' => $d_delivery,
                                       'd_remarks' => $d_remarks,
                                         ]);
                          } 
                        else{
                            
                        }
                     }
            }

             ////E. HEAT TREATMENT (IF ANY)
            for ($i = 1; $i <= $linehidden4; $i++) {
                 $hno = trim($data['hno_'.$i]) !== '' ? trim($data['hno_'.$i]) : '';
                 $e_item = trim($data['e_item_'.$i]) !== '' ? trim($data['e_item_'.$i]) : '';
                 $e_nominal = trim($data['e_nominal_'.$i]) !== '' ? trim($data['e_nominal_'.$i]) : '';
                 $e_tolerance = trim($data['e_tolerance_'.$i]) !== '' ? trim($data['e_tolerance_'.$i]) : '';
                 $e_instrument = trim($data['e_instrument_'.$i]) !== '' ? trim($data['e_instrument_'.$i]) : '';
                 $e_rank = trim($data['e_rank_'.$i]) !== '' ? trim($data['e_rank_'.$i]) : '';
                 $e_proses = trim($data['e_proses_'.$i]) !== '' ? trim($data['e_proses_'.$i]) : '';
                 $e_delivery = trim($data['e_delivery_'.$i]) !== '' ? trim($data['e_delivery_'.$i]) : '';
                 $e_remarks = trim($data['e_remarks_'.$i]) !== '' ? trim($data['e_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                          $cekModelLine4 = $entity->cekModelLine4($no_pisigp,$hno);
                          if($cekModelLine4->count() > 0) {
                            DB::table("pishtreatements")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['e_item' =>$e_item,
                                       'e_nominal' =>$e_nominal,
                                       'e_tolerance' => $e_tolerance,
                                       'e_instrument' => $e_instrument,
                                       'e_rank' => $e_rank,
                                       'e_proses' => $e_proses,
                                       'e_delivery' => $e_delivery,
                                       'e_remarks' => $e_remarks,
                                         ]);
                          } 
                        else{
                            
                        }
                     }
            }

             ////II. APPEARENCE
            for ($i = 1; $i <= $linehidden5; $i++) {
                 $apno = trim($data['apno_'.$i]) !== '' ? trim($data['apno_'.$i]) : '';
                 $f_item = trim($data['f_item_'.$i]) !== '' ? trim($data['f_item_'.$i]) : '';
                 $f_nominal = trim($data['f_nominal_'.$i]) !== '' ? trim($data['f_nominal_'.$i]) : '';
                 $f_tolerance = trim($data['f_tolerance_'.$i]) !== '' ? trim($data['f_tolerance_'.$i]) : '';
                 $f_instrument = trim($data['f_instrument_'.$i]) !== '' ? trim($data['f_instrument_'.$i]) : '';
                 $f_rank = trim($data['f_rank_'.$i]) !== '' ? trim($data['f_rank_'.$i]) : '';
                 $f_proses = trim($data['f_proses_'.$i]) !== '' ? trim($data['f_proses_'.$i]) : '';
                 $f_delivery = trim($data['f_delivery_'.$i]) !== '' ? trim($data['f_delivery_'.$i]) : '';
                 $f_remarks = trim($data['f_remarks_'.$i]) !== '' ? trim($data['f_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                        $cekModelLine5 = $entity->cekModelLine5($no_pisigp,$apno);
                        if($cekModelLine5->count() > 0) {
                            DB::table("pisappearences")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['f_item' =>$f_item,
                                       'f_nominal' =>$f_nominal,
                                       'f_tolerance' => $f_tolerance,
                                       'f_instrument' => $f_instrument,
                                       'f_rank' => $f_rank,
                                       'f_proses' => $f_proses,
                                       'f_delivery' => $f_delivery,
                                       'f_remarks' => $f_remarks,
                                         ]);
                        } 
                        else{
                            
                        }
                     }
            }

             ////III. DIMENSION
            for ($i = 1; $i <= $linehidden6; $i++) {
                 $dno = trim($data['dno_'.$i]) !== '' ? trim($data['dno_'.$i]) : '';
                 $g_item = trim($data['g_item_'.$i]) !== '' ? trim($data['g_item_'.$i]) : '';
                 $g_nominal = trim($data['g_nominal_'.$i]) !== '' ? trim($data['g_nominal_'.$i]) : '';
                 $g_tolerance = trim($data['g_tolerance_'.$i]) !== '' ? trim($data['g_tolerance_'.$i]) : '';
                 $g_instrument = trim($data['g_instrument_'.$i]) !== '' ? trim($data['g_instrument_'.$i]) : '';
                 $g_rank = trim($data['g_rank_'.$i]) !== '' ? trim($data['g_rank_'.$i]) : '';
                 $g_proses = trim($data['g_proses_'.$i]) !== '' ? trim($data['g_proses_'.$i]) : '';
                 $g_delivery = trim($data['g_delivery_'.$i]) !== '' ? trim($data['g_delivery_'.$i]) : '';
                 $g_remarks = trim($data['g_remarks_'.$i]) !== '' ? trim($data['g_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                        $cekModelLine6 = $entity->cekModelLine6($no_pisigp,$dno);
                         if($cekModelLine6->count() > 0) {
                            DB::table("pisdimentions")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['g_item' =>$g_item,
                                       'g_nominal' =>$g_nominal,
                                       'g_tolerance' => $g_tolerance,
                                       'g_instrument' => $g_instrument,
                                       'g_rank' => $g_rank,
                                       'g_proses' => $g_proses,
                                       'g_delivery' => $g_delivery,
                                       'g_remarks' => $g_remarks,
                                         ]);
                          } 
                        else{
                            
                        }
                     }
            }

             ////IV. SOC FREE
            for ($i = 1; $i <= $linehidden7; $i++) {
                  $scno = trim($data['scno_'.$i]) !== '' ? trim($data['scno_'.$i]) : '';
                   $h_item = trim($data['h_item_'.$i]) !== '' ? trim($data['h_item_'.$i]) : '';
                   $h_instrument = trim($data['h_instrument_'.$i]) !== '' ? trim($data['h_instrument_'.$i]) : '';
                   $h_rank = trim($data['h_rank_'.$i]) !== '' ? trim($data['h_rank_'.$i]) : '';
                   $h_proses = trim($data['h_proses_'.$i]) !== '' ? trim($data['h_proses_'.$i]) : '';
                   $h_delivery = trim($data['h_delivery_'.$i]) !== '' ? trim($data['h_delivery_'.$i]) : '';
                   $h_remarks = trim($data['h_remarks_'.$i]) !== '' ? trim($data['h_remarks_'.$i]) : '';
                    if ($no_pisigp !== ''){
                        $cekModelLine7 = $entity->cekModelLine7($no_pisigp,$scno);
                         if($cekModelLine7->count() > 0) {
                            DB::table("pissocfs")
                              ->where("no_pisigp", $no_pisigp)
                              ->where("no", $wno)
                              ->update(['h_item' =>$h_item,
                                        'h_instrument' => $h_instrument,
                                        'h_rank' => $h_rank,
                                        'h_proses' => $h_proses,
                                        'h_delivery' => $h_delivery,
                                        'h_remarks' => $h_remarks,
                                         ]);
                          } 
                        else{
                            
                        }
                     }
            }


            

        return redirect()->route('pisstaff.aprovalstaf');

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

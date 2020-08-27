<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pistandard;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use Session;
use exception;
use Carbon\Carbon;
use DB;
use App\User;
use Alert;
use PDF;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;

class PistandardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @retun \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         if ($request->ajax()) {
            $pistandards = DB::table("pistandards")
                        ->whereIn('status',[0,1,2,3,4]) 
                        ->select(DB::raw("no_pisigp, no_pis, model, part_no, part_name, nama_supplier, status,submit, max(norev) norev"))
                        ->groupBy(DB::raw("no_pisigp, no_pis, model, part_no, part_name, nama_supplier, status, submit")) ;
              return Datatables::of($pistandards)

              ->editColumn('status', function($pistandard){
                if($pistandard->status == 0){
                  return '<b class="btn-xs btn-warning btn-icon-pg" action="disable"> Draft</b>';
                }
                elseif($pistandard->status == 1){
                  return '<b class="btn-xs btn-info btn-icon-pg"  action="disable"> Belum Approv </b>';
                }
                elseif($pistandard->status == 2){
                  return '<b class="btn-xs btn-success btn-icon-pg"  action="disable"> Disetujui  </b>';
                }
                elseif($pistandard->status == 3){
                  return '<b class="btn-xs btn-danger btn-icon-pg" action="disable"> Ditolak</b>';
                }
                elseif($pistandard->status == 4){
                  return '<b class="btn-xs btn-danger btn-icon-pg" action="disable"> Need Revision</b>';
                }
              })
            ->editColumn('no_pis', function($pistandard) {
                        return '<a href="'.route('pistandards.show', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Detail No Pis '. $pistandard->no_pis .'">'.$pistandard->no_pis.'</a>';
                })
            ->addColumn('action', function($pistandard){
               if ($pistandard->status == 0) {
                 return ([
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print or preview " class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="'.route('pistandards.edit', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Click edit data " class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>'
                    ]);
                } elseif ($pistandard->status == 3) {
                   return ([
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print or preview " class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="'.route('pistandards.getrevisi', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Click untuk edit data " class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>'
                    ]);
                } elseif ($pistandard->status == 4) {
                  return ([
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print or preview" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="'.route('pistandards.getrevisi', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Click untuk revisi data " class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>'
                    ]);

                } else{

                    return ([
                    '<a href="'.route('pistandards.printpis', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Print or preview" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-print"></span></a>'.
                    '<a href="#" data-toggle="tooltip" data-placement="top" title="Click edit data " class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>']);

                   
                }
            })
            ->editColumn('rev_doc', function($pistandard){

                  return "Rev.".$pistandard->norev;
            }) 
            ->make(true); 
        } 
        return view('pis.supplier.index')->with(compact('pistandard'));
    }

   public function dafrev(Request $request, Builder $htmlBuilder)
    {
        //
        if ($request->ajax()) {
            $pistandards = DB::table("pistandards")
            ->whereIn('status',[5]) 
            ->select(DB::raw("no_pisigp, no_pis, model, part_no, part_name, nama_supplier, status, norev"))
            ->get();
            return Datatables::of($pistandards)
            ->editColumn('status', function($pistandard){
                if($pistandard->status == 0){
                    return '<b class="btn-xs btn-info btn-icon-pg" action="disable"> Belum Submit</b>';

                }elseif($pistandard->status == 1){
                    return '<b class="btn-xs btn-info btn-icon-pg"  action="disable"> Belum Approv </b>';

                }elseif($pistandard->status == 2){
                    return '<b class="btn-xs btn-success btn-icon-pg"  action="disable"> Disetujui </b>';

                }elseif($pistandard->status == 3){
                    return '<b class="btn-xs btn-danger btn-icon-pg" action="disable"> Ditolak</b>';
                }
            })
             ->editColumn('status', function($pistandard){
                if($pistandard->status == 5){
                  return '<b class="btn-xs btn-warning btn-icon-pg" action="disable">Telah Revisi</b>';
                }
              })
            ->editColumn('no_pis', function($pistandard) {
                return '<a href="'.route('pistandards.show', [base64_encode($pistandard->no_pisigp),base64_encode($pistandard->norev)]).'" data-toggle="tooltip" data-placement="top" title="Detail No Pis '. $pistandard->no_pis .'">'.$pistandard->no_pis.'</a>';
            })

           
            ->editColumn('rev_doc', function($pistandard){
               return "Rev.".$pistandard->norev;
           })->make(true);
            
        } 
        return view('pis.supplier.dafrev')->with(compact('$pistandard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
     return view('pis.supplier.create');
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
            $jml_line1 = trim($data['jml_line1']) !== '' ? trim($data['jml_line1']) : '0';
            $jml_linee = trim($data['jml_linee']) !== '' ? trim($data['jml_linee']) : '0';
            $jml_line3 = trim($data['jml_line3']) !== '' ? trim($data['jml_line3']) : '0';
            $jml_line4 = trim($data['jml_line4']) !== '' ? trim($data['jml_line4']) : '0';
            $jml_line5 = trim($data['jml_line5']) !== '' ? trim($data['jml_line5']) : '0';
            $jml_rows = trim($data['jml_rows']) !== '' ? trim($data['jml_rows']) : '0';
            $jml_input1 = trim($data['jml_input1']) !== '' ? trim($data['jml_input1']) : '0';
            $inputhidden = trim($data['inputhidden']) !== '' ? trim($data['inputhidden']) : '0';
            // $barishidden = trim($data['barishidden']) !== '' ? trim($data['barishidden']) : '0';

            $no_pis = trim($data['no_pis']) !== '' ? trim($data['no_pis']) : null;
            $model = trim($data['model']) !== '' ? trim($data['model']) : null;
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;  
            $part_name = trim($data['part_name']) !== '' ? trim($data['part_name']) : null;
            $nama_supplier = trim($data['nama_supplier']) !== '' ? trim($data['nama_supplier']) : null;
            $reff_no = trim($data['reff_no']) !== '' ? trim($data['reff_no']) : null;
            $date_issue = trim($data['date_issue']) !== '' ? trim($data['date_issue']) : null;
            $material = trim($data['material']) !== '' ? trim($data['material']) : null;
            // $generaltol= trim($data['generaltol_']) !== '' ? trim($data['generaltol_']) : null;  
            $weight = trim($data['weight']) !== '' ? trim($data['weight']) : null;
            $supp_dept = trim($data['supp_dept']) !== '' ? trim($data['supp_dept']) : null;
            $email = trim($data['email']) !== '' ? trim($data['email']) : null;
            $status_doc = trim($data['status_doc']) !== '' ? trim($data['status_doc']) : null;


            $staff_name = trim($data['staff_name']) !== '' ? trim($data['staff_name']) : null;
            $supervisor_name = trim($data['supervisor_name']) !== '' ? trim($data['supervisor_name']) : null;
            $manager_name = trim($data['manager_name']) !== '' ? trim($data['manager_name']) : null;
            $kd_supp = trim($data['kd_supp']) !== '' ? trim($data['kd_supp']) : null;
            $thn = Carbon::now()->format('y');

            // no_doc otomatis
            $nourutakhir=DB::table("pistandards")
                        ->orderBy('date_issue', 'desc')
                        ->value('no_pisigp');

            $nourut=(int) substr($nourutakhir,7,10);
            $nourut++;
            $new_no_doc['no_pisigp']='PIS'. sprintf('%05s',$nourut);

            // input Tanggal
            $date = Carbon::now()->format('d-m-Y');    
            $time = Carbon::now()->format('H:i:s'); 
            $jamTgl = $date." ".$time;
            $jamTgl=date("Y-m-d H:i:s",strtotime($jamTgl)); 
            $data['date_issue'] = $jamTgl; 

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

            //upload ttd logo supplier
          $filename1 = 'logo_supplier';
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

            //upload ttd staff supplier
            $filename2 = 'staff_spy';
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
            $filename3 = 'supervisor_spy';
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
             $filename4 = 'manager_spy';
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

            // SKETCHDRWAING1
            $filename5 = 'sketchdrawing';
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
            $filename6 = 'sketchmmethode';
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
            $filename7 = 'sketchappearance';
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

             // part_routing
            $filename8 = 'part_routing';
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
            
             $data['email'] = 'email';
             
             

        switch ($request->input('action')){
            case 'save': 
                 //action save here 
                 DB::table("pistandards")
                   ->insert([
                          'no_pisigp'=>$new_no_doc['no_pisigp'],
                          'no_pis'=>$request->no_pis,
                          'model'=>$request->model,
                          'part_no'=>$request->part_no,
                          'part_name'=>$request->part_name,
                          'nama_supplier'=>$request->nama_supplier,
                          'reff_no'=>$request->reff_no,
                          'material'=>$request->material,
                          'general_tol'=>json_encode($request->generaltol),
                          'weight'=>$request->weight,
                          'supp_dept'=>$request->supp_dept,
                          'status'=>1,
                          'date_issue'=>$data['date_issue'] ,
                          'tgl_submit'=> $data['tgl_submit'],
                          'logo_supplier'=>$request->logo_supplier = $filename1,
                          'staff_spy'=>$request->staff_spy = $filename2,
                          'supervisor_spy'=>$request->supervisor_spy = $filename3,
                          'manager_spy'=>$request->manager_spy = $filename4,
                          'sketchdrawing'=>$request->sketchdrawing = $filename5,
                          'sketchmmethode'=>$request->sketchmmethode = $filename6,
                          'sketchappearance'=>$request->sketchappearance = $filename7,
                          'norev'=> 0,
                          'submit'=> 1,
                          'email'=>$request->email,
                          'status_doc'=>$request->status_doc,
                          'staff_name'=>$request->staff_name,
                          'supervisor_name'=>$request->supervisor_name,
                          'manager_name'=>$request->manager_name,
                          'kode_supp'=>$request->kd_supp,
                          'part_routing'=>$request->part_routing= $filename8,
                          

                         ]);                 
                   
                   $to = [];
                   // doni.gustama@gkd-astra.co.id
                   array_push($to, "fadlya179@gmail.com");

                   $pis=$request->no_pis;
                   $tgl= $data['tgl_submit'];
                   $supplier= $request->nama_supplier;
                   Mail::send('pis.supplier.emailsubmit', compact('pis','tgl','supplier'), function ($m) use ($to, $no_pis) {
                    $m->to($to)
                      ->subject('PIS: '.$no_pis);
                  });     
             

                  Alert::success("Berhasil Submit","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");

            break;
            case 'save_draft': 
                  //action for save-draft here
                  DB::table("pistandards")
                     ->insert([
                          'no_pisigp'=>$new_no_doc['no_pisigp'],
                          'no_pis'=>$request->no_pis,
                          'model'=>$request->model,
                          'part_no'=>$request->part_no,
                          'part_name'=>$request->part_name,
                          'nama_supplier'=>$request->nama_supplier,
                          'reff_no'=>$request->reff_no,
                          'material'=>$request->material,
                          'general_tol'=>json_encode($request->generaltol),
                          'weight'=>$request->weight,
                          'supp_dept'=>$request->supp_dept,
                          'date_issue'=>$data['date_issue'] ,
                          'tgl_draft'=>$data['tgl_draft'],
                          'logo_supplier'=>$request->logo_supplier = $filename1,
                          'staff_spy'=>$request->staff_spy = $filename2,
                          'supervisor_spy'=>$request->supervisor_spy = $filename3,
                          'manager_spy'=>$request->manager_spy = $filename4,
                          'sketchdrawing'=>$request->sketchdrawing = $filename5,
                          'sketchmmethode'=>$request->sketchmmethode = $filename6,
                          'sketchappearance'=>$request->sketchappearance = $filename7,
                          'norev'=> 0,
                          'submit'=> 1,
                          'email'=>$request->email,
                          'status_doc'=>$request->status_doc,
                          'staff_name'=>$request->staff_name,
                          'supervisor_name'=>$request->supervisor_name,
                          'manager_name'=>$request->manager_name,
                          'kode_supp'=>$request->kd_supp,
                          'part_routing'=>$request->part_routing= $filename8,

                        ]); 
   
                    Alert::success("Data Disimpan Sebagai Draft","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");  
            break;
        }

                   /////CHEMICAL COMPOSITION
             for ($i = 1; $i <= $jml_line1; $i++) {
                   $cno = trim($data['cno_'.$i]) !== '' ? trim($data['cno_'.$i]) : '';
                   $citem = trim($data['citem_'.$i]) !== '' ? trim($data['citem_'.$i]) : '';
                   $cnom = trim($data['cnom_'.$i]) !== '' ? trim($data['cnom_'.$i]) : '';
                   $ctol = trim($data['ctol_'.$i]) !== '' ? trim($data['ctol_'.$i]) : '';
                   $cins = trim($data['cins_'.$i]) !== '' ? trim($data['cins_'.$i]) : '';
                   $crank = trim($data['crank_'.$i]) !== '' ? trim($data['crank_'.$i]) : '';
                   $cpro = trim($data['cpro_'.$i]) !== '' ? trim($data['cpro_'.$i]) : '';
                   $cdel = trim($data['cdel_'.$i]) !== '' ? trim($data['cdel_'.$i]) : '';
                   $crem = trim($data['crem_'.$i]) !== '' ? trim($data['crem_'.$i]) : '';
                    // no_doc otomatis
                   
                   if($citem !== "" || $cnom !== "" || $ctol !== "" || $cins !== "" || $crank !== "" || $cpro !== "" || $cdel !== "" || $crem !== ""){
                    DB::table("pisccompositions")
                   ->insert([
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
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
                       'norev'=> 0,
                         
                       ]);   
                   }
                }

                  ////////////MECHANICAL PROPERTIES
                for ($i = 1; $i <= $jml_linee; $i++) {
                   $mno = trim($data['mno_'.$i]) !== '' ? trim($data['mno_'.$i]) : '';
                   $mitem = trim($data['mitem_'.$i]) !== '' ? trim($data['mitem_'.$i]) : '';
                   $mnom = trim($data['mnom_'.$i]) !== '' ? trim($data['mnom_'.$i]) : '';
                   $mtol = trim($data['mtol_'.$i]) !== '' ? trim($data['mtol_'.$i]) : '';
                   $mins = trim($data['mins_'.$i]) !== '' ? trim($data['mins_'.$i]) : '';
                   $mrank = trim($data['mrank_'.$i]) !== '' ? trim($data['mrank_'.$i]) : '';
                   $mpro = trim($data['mpro_'.$i]) !== '' ? trim($data['mpro_'.$i]) : '';
                   $mdel = trim($data['mdel_'.$i]) !== '' ? trim($data['mdel_'.$i]) : '';
                   $mrem = trim($data['mrem_'.$i]) !== '' ? trim($data['mrem_'.$i]) : '';

                   if ($mitem !== "" || $mnom !== "" || $mtol !== "" || $mins !== "" || $mrank !== "" || $mpro !== "" || $mdel !== "" || $mrem !== "") {
                     DB::table("pismproperties")
                   ->insert([
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$mno,
                       'item' =>$mitem,
                       'nominal' =>$mnom,
                       'tolerance' => $mtol,
                       'instrument' => $mins,
                       'rank' => $mrank,
                       'proses' => $mpro,
                       'delivery' => $mdel,
                       'remarks' => $mrem,
                       'norev'=> 0,
                       ]);
                   }
                  
                }

                ////WELDING PERFORMANCE (IF ANY)
                for ($i = 1; $i <= $jml_line3; $i++) {
                   $wno = trim($data['wno_'.$i]) !== '' ? trim($data['wno_'.$i]) : '';
                   $witem = trim($data['witem_'.$i]) !== '' ? trim($data['witem_'.$i]) : '';
                   $wnom = trim($data['wnom_'.$i]) !== '' ? trim($data['wnom_'.$i]) : '';
                   $wtol = trim($data['wtol_'.$i]) !== '' ? trim($data['wtol_'.$i]) : '';
                   $wins = trim($data['wins_'.$i]) !== '' ? trim($data['wins_'.$i]) : '';
                   $wrank = trim($data['wrank_'.$i]) !== '' ? trim($data['wrank_'.$i]) : '';
                   $wpro = trim($data['wpro_'.$i]) !== '' ? trim($data['wpro_'.$i]) : '';
                   $wdel = trim($data['wdel_'.$i]) !== '' ? trim($data['wdel_'.$i]) : '';
                   $wrem = trim($data['wrem_'.$i]) !== '' ? trim($data['wrem_'.$i]) : '';

                   if ($witem !== "" || $wnom !== "" || $mtol !== "" || $mins !== "" || $mrank !== "" || $mpro !== "" || $mdel !== "" || $mrem !== "") {
                      DB::table("piswperformances")
                         ->insert([ 
                            'no_pisigp'=>$new_no_doc['no_pisigp'],
                           'no_pis'=>$request->no_pis,
                           'no' =>$wno,
                           'item' =>$witem,
                           'nominal' =>$wnom,
                           'tolerance' => $wtol,
                           'instrument' => $wins,
                           'rank' => $wrank,
                           'proses' => $wpro,
                           'delivery' => $wdel,
                           'remarks' => $wrem,
                           'norev'=> 0,
                           ]);   
                      }    
                  
                  }

                  //SURFACE TREATMENT (IF ANY)
                for ($i = 1; $i <= $jml_line4; $i++) {
                   $sno = trim($data['sno_'.$i]) !== '' ? trim($data['sno_'.$i]) : '';
                   $sitem = trim($data['sitem_'.$i]) !== '' ? trim($data['sitem_'.$i]) : '';
                   $snominal = trim($data['snominal_'.$i]) !== '' ? trim($data['snominal_'.$i]) : '';
                   $stolerance = trim($data['stolerance_'.$i]) !== '' ? trim($data['stolerance_'.$i]) : '';
                   $sinstrument = trim($data['sinstrument_'.$i]) !== '' ? trim($data['sinstrument_'.$i]) : '';
                   $srank = trim($data['srank_'.$i]) !== '' ? trim($data['srank_'.$i]) : '';
                   $sproses = trim($data['sproses_'.$i]) !== '' ? trim($data['sproses_'.$i]) : '';
                   $sdelivery = trim($data['sdelivery_'.$i]) !== '' ? trim($data['sdelivery_'.$i]) : '';
                   $sremarks = trim($data['sremarks_'.$i]) !== '' ? trim($data['sremarks_'.$i]) : '';

                   if ($sitem !== "" || $snominal !== "" || $stolerance !== "" || $sinstrument !== "" || $srank !== "" || $sproses !== "" || $sdelivery !== "" || $sremarks !== "") {
                    DB::table("pisstreatements")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$sno,
                       'item' =>$sitem,
                       'nominal' =>$snominal,
                       'tolerance' => $stolerance,
                       'instrument' => $sinstrument,
                       'rank' => $srank,
                       'proses' => $sproses,
                       'delivery' => $sdelivery,
                       'remarks' => $sremarks,
                       'norev'=> 0,
                       ]);   
                   }
                   
                }

                 //HEAT TREATMENT (IF ANY)
                for ($i = 1; $i <= $jml_line5; $i++) {
                   $hno = trim($data['hno_'.$i]) !== '' ? trim($data['hno_'.$i]) : '';
                   $hitem = trim($data['hitem_'.$i]) !== '' ? trim($data['hitem_'.$i]) : '';
                   $hnominal = trim($data['hnominal_'.$i]) !== '' ? trim($data['hnominal_'.$i]) : '';
                   $htolerance = trim($data['htolerance_'.$i]) !== '' ? trim($data['htolerance_'.$i]) : '';
                   $hinstrument = trim($data['hinstrument_'.$i]) !== '' ? trim($data['hinstrument_'.$i]) : '';
                   $hrank = trim($data['hrank_'.$i]) !== '' ? trim($data['hrank_'.$i]) : '';
                   $hproses = trim($data['hproses_'.$i]) !== '' ? trim($data['hproses_'.$i]) : '';
                   $hdelivery = trim($data['hdelivery_'.$i]) !== '' ? trim($data['hdelivery_'.$i]) : '';
                   $hremarks = trim($data['hremarks_'.$i]) !== '' ? trim($data['hremarks_'.$i]) : '';

                   if ($hitem !== "" || $hnominal !== "" || $htolerance !== "" || $hinstrument !== "" || $hrank !== "" || $hproses !== "" || $hdelivery !== "" || $hremarks !== "") {
                     DB::table("pishtreatements")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$hno,
                       'item' =>$hitem,
                       'nominal' =>$hnominal,
                       'tolerance' => $htolerance,
                       'instrument' => $hinstrument,
                       'rank' => $hrank,
                       'proses' => $hproses,
                       'delivery' => $hdelivery,
                       'remarks' => $hremarks,
                       'norev'=> 0,
                       ]);   
                   }
                   
                }

                 // APPEARENCE
                for ($i = 1; $i <= $jml_rows; $i++) {
                   $apno = trim($data['apno_'.$i]) !== '' ? trim($data['apno_'.$i]) : '';
                   $apitem = trim($data['apitem_'.$i]) !== '' ? trim($data['apitem_'.$i]) : '';
                   $apnominal = trim($data['apnominal_'.$i]) !== '' ? trim($data['apnominal_'.$i]) : '';
                   $aptolerance = trim($data['aptolerance_'.$i]) !== '' ? trim($data['aptolerance_'.$i]) : '';
                   $apinstrument = trim($data['apinstrument_'.$i]) !== '' ? trim($data['apinstrument_'.$i]) : '';
                   $aprank = trim($data['aprank_'.$i]) !== '' ? trim($data['aprank_'.$i]) : '';
                   $approses = trim($data['approses_'.$i]) !== '' ? trim($data['approses_'.$i]) : '';
                   $apdelivery = trim($data['apdelivery_'.$i]) !== '' ? trim($data['apdelivery_'.$i]) : '';
                   $apremarks = trim($data['apremarks_'.$i]) !== '' ? trim($data['apremarks_'.$i]) : '';

                   if ($apitem !== "" || $apnominal !== "" || $aptolerance !== "" || $apinstrument !== "" || $aprank !== "" || $approses !== "" || $apdelivery !== "" || $apremarks !== "") {
                      DB::table("pisappearences")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$apno,
                       'item' =>$apitem,
                       'nominal' =>$apnominal,
                       'tolerance' => $aptolerance,
                       'instrument' => $apinstrument,
                       'rank' => $aprank,
                       'proses' => $approses,
                       'delivery' => $apdelivery,
                       'remarks' => $apremarks,
                       'norev'=> 0,
                       ]);   
                   }
                  
                }

                 ///DIMENSION
                for ($i = 1; $i <= $jml_input1; $i++) {
                   $dno = trim($data['dno_'.$i]) !== '' ? trim($data['dno_'.$i]) : '';
                   $ditem = trim($data['ditem_'.$i]) !== '' ? trim($data['ditem_'.$i]) : '';
                   $dnominal = trim($data['dnominal_'.$i]) !== '' ? trim($data['dnominal_'.$i]) : '';
                   $dtolerance = trim($data['dtolerance_'.$i]) !== '' ? trim($data['dtolerance_'.$i]) : '';
                   $dinstrument = trim($data['dinstrument_'.$i]) !== '' ? trim($data['dinstrument_'.$i]) : '';
                   $drank = trim($data['drank_'.$i]) !== '' ? trim($data['drank_'.$i]) : '';
                   $dproses = trim($data['dproses_'.$i]) !== '' ? trim($data['dproses_'.$i]) : '';
                   $ddelivery = trim($data['ddelivery_'.$i]) !== '' ? trim($data['ddelivery_'.$i]) : '';
                   $dremarks = trim($data['dremarks_'.$i]) !== '' ? trim($data['dremarks_'.$i]) : '';

                   if ($ditem !== "" || $dnominal !== "" || $dtolerance !== "" || $dinstrument !== "" || $drank !== "" || $dproses !== "" || $ddelivery !== "" || $dremarks !== "") {
                      DB::table("pisdimentions")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$dno,
                       'item' =>$ditem,
                       'nominal' =>$dnominal,
                       'tolerance' => $dtolerance,
                       'instrument' => $dinstrument,
                       'rank' => $drank,
                       'proses' => $dproses,
                       'delivery' => $ddelivery,
                       'remarks' => $dremarks,
                       'norev'=> 0,
                       ]);   
                   }
                  
                }

                  //SOC FREE
                for ($i = 1; $i <= $inputhidden; $i++) {
                   $scno = trim($data['scno_'.$i]) !== '' ? trim($data['scno_'.$i]) : '';
                   $scitem = trim($data['scitem_'.$i]) !== '' ? trim($data['scitem_'.$i]) : '';
                  
                   $scinstrument = trim($data['scinstrument_'.$i]) !== '' ? trim($data['scinstrument_'.$i]) : '';
                   $scrank = trim($data['scrank_'.$i]) !== '' ? trim($data['scrank_'.$i]) : '';
                   $scproses = trim($data['scproses_'.$i]) !== '' ? trim($data['scproses_'.$i]) : '';
                   $scdelivery = trim($data['scdelivery_'.$i]) !== '' ? trim($data['scdelivery_'.$i]) : '';
                   $scremarks = trim($data['scremarks_'.$i]) !== '' ? trim($data['scremarks_'.$i]) : '';

                   if ($scitem !== "" || $scinstrument !== "" || $scrank !== "" || $scproses !== "" || $scdelivery !== "" || $scremarks !== "") {
                      DB::table("pissocfs")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$scno,
                       'item' =>$scitem,
                       'instrument' => $scinstrument,
                       'rank' => $scrank,
                       'proses' => $scproses,
                       'delivery' => $scdelivery,
                       'remarks' => $scremarks,
                       'norev'=> 0,
                       ]);   
                   }
                  
                }

                  ///PART ROUTING
                // for ($i = 1; $i <= $barishidden; $i++) {
                //    $plevel = trim($data['plevel_'.$i]) !== '' ? trim($data['plevel_'.$i]) : '';
                //    $ppart_no = trim($data['ppart_no_'.$i]) !== '' ? trim($data['ppart_no_'.$i]) : '';
                //    $ppart_name = trim($data['ppart_name_'.$i]) !== '' ? trim($data['ppart_name_'.$i]) : '';
                //    $pproses = trim($data['pproses_'.$i]) !== '' ? trim($data['pproses_'.$i]) : '';
                //    $psupplier = trim($data['psupplier_'.$i]) !== '' ? trim($data['psupplier_'.$i]) : '';
                  
                //    if ($plevel !== "" || $ppart_no !== "" || $ppart_name !== "" || $pproses !== "" || $psupplier !== "" ) {
                //       DB::table("pisroutes")
                //    ->insert([ 
                //        'no_pisigp'=>$new_no_doc['no_pisigp'],
                //        'no_pis'=>$request->no_pis,
                //        'level' =>$plevel,
                //        'part_no' =>$ppart_no,
                //        'part_name' => $ppart_name,
                //        'proses' => $pproses,
                //        'supplier' => $psupplier,
                //        'norev'=> 0,
                //        ]);   
                //    }
                  
                // }

     return redirect()->route('pistandards.index');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function printpis($no_pisigp,$norev)
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
                    ->where(DB::raw("norev"), '=', $norev)
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
 
            //  echo json_encode($part_routing) ;
            // die();

      $error_level = error_reporting();
      error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
    
      $pdf = PDF::loadView('pis.supplier.printpis', ['part_routing'=>$part_routing,'approve_dept'=>$approve_dept,'approve_sect'=>$approve_sect,'approve_staff'=>$approve_staff,'sketchdrawing'=>$sketchdrawing,'sketchmmethode'=>$sketchmmethode,'sketchappearance'=>$sketchappearance,'manager_spy'=>$manager_spy,'supervisor_spy'=>$supervisor_spy,'staff_spy'=>$staff_spy,'logo_supplier'=>$logo_supplier,'pistandards' => $pistandards,'composition'=> $composition,'properties'=> $properties,'performances'=> $performances,'treatements'=> $treatements,'htreatements'=> $htreatements,'appearences'=> $appearences,'dimentions'=> $dimentions,'socfs'=> $socfs,'routs'=> $routs,'revisi'=> $revisi,'entity'=> $entity])->setPaper('a4', 'portrait');
      // use PDF;

      return $pdf->stream(''. $pistandards->no_pis .'.pdf');
    }

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
// echo json_encode($pistandards);
// die();
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

             // echo $performances ;
            // die();
 
            //  echo json_encode($pistandards) ;
            // die();

     return view('pis.supplier.show')->with(compact(['approve_dept','approve_sect','approve_staff','sketchdrawing','sketchmmethode','sketchappearance','manager_spy','supervisor_spy','staff_spy','logo_supplier','pistandards','composition','properties','performances','treatements','htreatements','appearences','dimentions','socfs','routs','revisi', 'entity','no_pisigp','logo_supplier','staff_spy','supervisor_spy','manager_spy','part_routing']));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function edit($no_pisigp,$norev)
    {
        //
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
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

          $logo_supplier = "";
            if (!empty($pistandard->logo_supplier)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."logospy".DIRECTORY_SEPARATOR.$pistandard->logo_supplier;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\logospy\\".$pistandard->logo_supplier;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $logo_supplier = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $staff_spy = "";
            if (!empty($pistandard->staff_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."staff_spy".DIRECTORY_SEPARATOR.$pistandard->staff_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\staff_spy\\".$pistandard->staff_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $staff_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }


             $supervisor_spy = "";
            if (!empty($pistandard->supervisor_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."supervisor_spy".DIRECTORY_SEPARATOR.$pistandard->supervisor_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\supervisor_spy\\".$pistandard->supervisor_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $supervisor_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             $manager_spy = "";
            if (!empty($pistandard->manager_spy)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."manager_spy".DIRECTORY_SEPARATOR.$pistandard->manager_spy;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\manager_spy\\".$pistandard->manager_spy;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $manager_spy = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            //sketcdrawing1
            $sketchdrawing = "";
            if (!empty($pistandard->sketchdrawing)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar1".DIRECTORY_SEPARATOR.$pistandard->sketchdrawing;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar1\\".$pistandard->sketchdrawing;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchdrawing = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             //sketchmmethode
            $sketchmmethode = "";
            if (!empty($pistandard->sketchmmethode)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar2".DIRECTORY_SEPARATOR.$pistandard->sketchmmethode;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar2\\".$pistandard->sketchmmethode;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchmmethode = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }


            //sketchappearance
            $sketchappearance = "";
            if (!empty($pistandard->sketchappearance)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."gambar3".DIRECTORY_SEPARATOR.$pistandard->sketchappearance;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\gambar3\\".$pistandard->sketchappearance;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $sketchappearance = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

             $part_routing = "";
            if (!empty($pistandard->part_routing)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."part_routing".DIRECTORY_SEPARATOR.$pistandard->part_routing;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\part_routing\\".$pistandard->part_routing;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $part_routing = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
 
            $entity = new Pistandard();

            //  $pisemail = DB::table('pistandards')
            //         ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
            //         ->where(DB::raw("norev"), '=', $norev)
            //         ->select(DB::raw("email"))
            //         ->first(); 
 

        
            //  echo json_encode($pisemail) ;
            // die();


            // echo $logo_supplier;
            // die();


            // echo json_encode($pistandard) ;
            // die();

            
            

     return view('pis.supplier.edit')->with(compact(['part_routing','sketchdrawing','sketchmmethode','sketchappearance','manager_spy','supervisor_spy','staff_spy','logo_supplier','pistandard','composition','properties','performances','treatements','htreatements','appearences','dimentions','socfs','routs','revisi', 'entity']));
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $data = $request->all();
            $no_pisigp = $data['no_pisigp'];   
             $norev = $data['norev']; 
              
            $jml_line1 = trim($data['jml_line1']) !== '' ? trim($data['jml_line1']) : '0';
            $jml_linee = trim($data['jml_linee']) !== '' ? trim($data['jml_linee']) : '0';
            $jml_line3 = trim($data['jml_line3']) !== '' ? trim($data['jml_line3']) : '0';
            $jml_line4 = trim($data['jml_line4']) !== '' ? trim($data['jml_line4']) : '0';
            $jml_line5 = trim($data['jml_line5']) !== '' ? trim($data['jml_line5']) : '0';
            $jml_rows = trim($data['jml_rows']) !== '' ? trim($data['jml_rows']) : '0';
            $jml_input1 = trim($data['jml_input1']) !== '' ? trim($data['jml_input1']) : '0';
            $inputhidden = trim($data['inputhidden']) !== '' ? trim($data['inputhidden']) : '0';
            // $barishidden = trim($data['barishidden']) !== '' ? trim($data['barishidden']) : '0';
            // $jml_revisi = trim($data['jml_revisi']) !== '' ? trim($data['jml_revisi']) : '0';

            $no_pis = trim($data['no_pis']) !== '' ? trim($data['no_pis']) : null;
          
             
                         

            $thn = Carbon::now()->format('y');

            // input Tanggal
            $date = Carbon::now()->format('d-m-Y');    
            $time = Carbon::now()->format('H:i:s'); 
            $jamTgl = $date." ".$time;
            $jamTgl=date("Y-m-d H:i:s",strtotime($jamTgl)); 
            $data['date_issue'] = $jamTgl; 

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

            $entity = new Pistandard;
           $pistandard = DB::table('pistandards')
                      ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                      ->first(); 

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

      


        switch ($request->input('action')){
            case 'save': 
                 //action save here
                 DB::table("pistandards")
                   ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->where(DB::raw("norev"), '=', $norev)
                   ->update([
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
                          'status_doc'=>$request->status_doc,
                          'tgl_submit'=> $data['tgl_submit'],
                          'logo_supplier'=>$request->logo_supplier = $filename1,
                          'staff_spy'=>$request->staff_spy = $filename2,
                          'supervisor_spy'=>$request->supervisor_spy = $filename3,
                          'manager_spy'=>$request->manager_spy = $filename4,
                          'sketchdrawing'=>$request->sketchdrawing = $filename5,
                          'sketchmmethode'=>$request->sketchmmethode = $filename6,
                          'sketchappearance'=>$request->sketchappearance = $filename7,
                          'part_routing'=>$request->part_routing = $filename8,
                          'staff_name'=>$request->staff_name,
                          'supervisor_name'=>$request->supervisor_name,
                          'manager_name'=>$request->manager_name,
                          

                          
                         ]);            
                 
                  //  $to = [];
                  //  array_push($to, "fadlya179@gmail.com");
                  //  $pis=$request->no_pis;
                  //  $tgl= $data['tgl_submit'];
                  //  $supplier= $request->nama_supplier;
                  //  Mail::send('pis.supplier.emailsubmit', compact('pis','tgl','supplier'), function ($m) use ($to, $no_pis) {
                  //   $m->to($to)
                  //   ->subject('PIS: '.$no_pis);
                  // });     
             
                Alert::success("Berhasil Submit","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");
            break;
            case 'save_draft': 
                  //action for save-draft here
                  DB::table("pistandards")
                     ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                     ->where(DB::raw("norev"), '=', $norev)
                     ->update([
                          'no_pis'=>$request->no_pis,
                          'model'=>$request->model,
                          'part_no'=>$request->part_no,
                          'part_name'=>$request->part_name,
                          'nama_supplier'=>$request->nama_supplier,
                          'reff_no'=>$request->reff_no,
                          'material'=>$request->material,
                          'general_tol'=>json_encode($request->general_tol),
                          'weight'=>$request->weight,
                          'supp_dept'=>$request->supp_dept,
                          'status_doc'=>$request->status_doc,
                          'tgl_draft'=>$data['tgl_draft'],
                          'logo_supplier'=>$request->logo_supplier = $filename1,
                          'staff_spy'=>$request->staff_spy = $filename2,
                          'supervisor_spy'=>$request->supervisor_spy = $filename3,
                          'manager_spy'=>$request->manager_spy = $filename4,
                          'sketchdrawing'=>$request->sketchdrawing = $filename5,
                          'sketchmmethode'=>$request->sketchmmethode = $filename6,
                          'sketchappearance'=>$request->sketchappearance = $filename7,
                          'staff_name'=>$request->staff_name,
                          'supervisor_name'=>$request->supervisor_name,
                          'manager_name'=>$request->manager_name,
                          'part_routing'=>$request->part_routing = $filename8,
                          
                        ]); 
                    
                    Alert::success("Data Disimpan Sebagai Draft","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");  
            break;
        }




                /////CHEMICAL COMPOSITION
        for ($i = 1; $i <= $jml_line1; $i++) {
           $cno = trim($data['cno_'.$i]) !== '' ? trim($data['cno_'.$i]) : '';
           $citem = trim($data['citem_'.$i]) !== '' ? trim($data['citem_'.$i]) : '';
           $cnom = trim($data['cnom_'.$i]) !== '' ? trim($data['cnom_'.$i]) : '';
           $ctol = trim($data['ctol_'.$i]) !== '' ? trim($data['ctol_'.$i]) : '';
           $cins = trim($data['cins_'.$i]) !== '' ? trim($data['cins_'.$i]) : '';
           $crank = trim($data['crank_'.$i]) !== '' ? trim($data['crank_'.$i]) : '';
           $cpro = trim($data['cpro_'.$i]) !== '' ? trim($data['cpro_'.$i]) : '';
           $cdel = trim($data['cdel_'.$i]) !== '' ? trim($data['cdel_'.$i]) : '';
           $crem = trim($data['crem_'.$i]) !== '' ? trim($data['crem_'.$i]) : '';
            if ($no_pisigp !== '' || $no !== ''){
                 $cekModelLine = $entity->cekModelLine($no_pisigp,$cno);
                 if($cekModelLine->count() > 0) {
                    DB::table("pisccompositions")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $cno)
                      ->update([
                                 'item' =>$citem,
                                 'nominal' =>$cnom,
                                 'tolerance' => $ctol,
                                 'instrument' => $cins,
                                 'rank' => $crank,
                                 'proses' => $cpro,
                                 'delivery' => $cdel,
                                 'remarks' => $crem,
                                 ]);
                  } 
                else{
                    DB::table("pisccompositions")
                      ->insert([ 'no_pisigp'=>$no_pisigp,
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
                                  'norev'=>$norev,
                                ]);   
                }
             }
        }

         /////B.MECHANICAL PROPERTIES
        for ($i = 1; $i <= $jml_linee; $i++) {
           $mno = trim($data['mno_'.$i]) !== '' ? trim($data['mno_'.$i]) : '';
           $mitem = trim($data['mitem_'.$i]) !== '' ? trim($data['mitem_'.$i]) : '';
           $mnom = trim($data['mnom_'.$i]) !== '' ? trim($data['mnom_'.$i]) : '';
           $mtol = trim($data['mtol_'.$i]) !== '' ? trim($data['mtol_'.$i]) : '';
           $mins = trim($data['mins_'.$i]) !== '' ? trim($data['mins_'.$i]) : '';
           $mrank = trim($data['mrank_'.$i]) !== '' ? trim($data['mrank_'.$i]) : '';
           $mpro = trim($data['mpro_'.$i]) !== '' ? trim($data['mpro_'.$i]) : '';
           $mdel = trim($data['mdel_'.$i]) !== '' ? trim($data['mdel_'.$i]) : '';
           $mrem = trim($data['mrem_'.$i]) !== '' ? trim($data['mrem_'.$i]) : '';
            if ($no_pisigp !== '' || $no !== ''){
                 $cekModelLine1 = $entity->cekModelLine1($no_pisigp,$mno);
                 if($cekModelLine1->count() > 0) {
                    DB::table("pismproperties")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $mno)
                      ->update(['item' =>$mitem,
                                'nominal' =>$mnom,
                                'tolerance' => $mtol,
                                'instrument' => $mins,
                                'rank' => $mrank,
                                'proses' => $mpro,
                                'delivery' => $mdel,
                                'remarks' => $mrem,
                                 ]);
                  } 
                else{
                    DB::table("pismproperties")
                   ->insert([
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$mno,
                       'item' =>$mitem,
                       'nominal' =>$mnom,
                       'tolerance' => $mtol,
                       'instrument' => $mins,
                       'rank' => $mrank,
                       'proses' => $mpro,
                       'delivery' => $mdel,
                       'remarks' => $mrem,
                       'norev'=>$norev,
                       ]);   
                }
             }
        }

        ////C. WELDING PERFORMANCE (IF ANY)
         for ($i = 1; $i <= $jml_line3; $i++) {
            $wno = trim($data['wno_'.$i]) !== '' ? trim($data['wno_'.$i]) : '';
            $witem = trim($data['witem_'.$i]) !== '' ? trim($data['witem_'.$i]) : '';
            $wnom = trim($data['wnom_'.$i]) !== '' ? trim($data['wnom_'.$i]) : '';
            $wtol = trim($data['wtol_'.$i]) !== '' ? trim($data['wtol_'.$i]) : '';
            $wins = trim($data['wins_'.$i]) !== '' ? trim($data['wins_'.$i]) : '';
            $wrank = trim($data['wrank_'.$i]) !== '' ? trim($data['wrank_'.$i]) : '';
            $wpro = trim($data['wpro_'.$i]) !== '' ? trim($data['wpro_'.$i]) : '';
            $wdel = trim($data['wdel_'.$i]) !== '' ? trim($data['wdel_'.$i]) : '';
            $wrem = trim($data['wrem_'.$i]) !== '' ? trim($data['wrem_'.$i]) : '';
            if ($no_pisigp !== '' || $no !== ''){
                 $cekModelLine2 = $entity->cekModelLine2($no_pisigp,$wno);
                 if($cekModelLine2->count() > 0) {
                    DB::table("piswperformances")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $wno)
                      ->update(['item' =>$witem,
                                'nominal' =>$wnom,
                                'tolerance' => $wtol,
                                'instrument' => $wins,
                                'rank' => $wrank,
                                'proses' => $wpro,
                                'delivery' => $wdel,
                                'remarks' => $wrem,
                                 ]);
                  } 
                else{
                    DB::table("piswperformances")
                   ->insert([
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$wno,
                       'item' =>$witem,
                       'nominal' =>$wnom,
                       'tolerance' => $wtol,
                       'instrument' => $wins,
                       'rank' => $wrank,
                       'proses' => $wpro,
                       'delivery' => $wdel,
                       'remarks' => $wrem,
                       'norev'=>$norev,
                       ]);   
                }
             }
          }

          ////D. SURFACE TREATMENT
         for ($i = 1; $i <= $jml_line4; $i++) {
           $sno = trim($data['sno_'.$i]) !== '' ? trim($data['sno_'.$i]) : '';
           $sitem = trim($data['sitem_'.$i]) !== '' ? trim($data['sitem_'.$i]) : '';
           $snominal = trim($data['snominal_'.$i]) !== '' ? trim($data['snominal_'.$i]) : '';
           $stolerance = trim($data['stolerance_'.$i]) !== '' ? trim($data['stolerance_'.$i]) : '';
           $sinstrument = trim($data['sinstrument_'.$i]) !== '' ? trim($data['sinstrument_'.$i]) : '';
           $srank = trim($data['srank_'.$i]) !== '' ? trim($data['srank_'.$i]) : '';
           $sproses = trim($data['sproses_'.$i]) !== '' ? trim($data['sproses_'.$i]) : '';
           $sdelivery = trim($data['sdelivery_'.$i]) !== '' ? trim($data['sdelivery_'.$i]) : '';
           $sremarks = trim($data['sremarks_'.$i]) !== '' ? trim($data['sremarks_'.$i]) : '';

            if ($no_pisigp !== '' || $no !== ''){
                 $cekModelLine3 = $entity->cekModelLine3($no_pisigp,$sno);
                 if($cekModelLine3->count() > 0) {
                    DB::table("pisstreatements")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $sno)
                      ->update(['item' =>$sitem,
                                'nominal' =>$snominal,
                                'tolerance' => $stolerance,
                                'instrument' => $sinstrument,
                                'rank' => $srank,
                                'proses' => $sproses,
                                'delivery' => $sdelivery,
                                'remarks' => $sremarks,
                              ]);
                  } 
                else{
                   DB::table("pisstreatements")
                   ->insert([ 
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$sno,
                       'item' =>$sitem,
                       'nominal' =>$snominal,
                       'tolerance' => $stolerance,
                       'instrument' => $sinstrument,
                       'rank' => $srank,
                       'proses' => $sproses,
                       'delivery' => $sdelivery,
                       'remarks' => $sremarks,
                       'norev'=>$norev,
                       ]); 
                }
             }
          }

          ////E. HEAT TREATMENT
        for ($i = 1; $i <= $jml_line5; $i++) {
           $hno = trim($data['hno_'.$i]) !== '' ? trim($data['hno_'.$i]) : '';
           $hitem = trim($data['hitem_'.$i]) !== '' ? trim($data['hitem_'.$i]) : '';
           $hnominal = trim($data['hnominal_'.$i]) !== '' ? trim($data['hnominal_'.$i]) : '';
           $htolerance = trim($data['htolerance_'.$i]) !== '' ? trim($data['htolerance_'.$i]) : '';
           $hinstrument = trim($data['hinstrument_'.$i]) !== '' ? trim($data['hinstrument_'.$i]) : '';
           $hrank = trim($data['hrank_'.$i]) !== '' ? trim($data['hrank_'.$i]) : '';
           $hproses = trim($data['hproses_'.$i]) !== '' ? trim($data['hproses_'.$i]) : '';
           $hdelivery = trim($data['hdelivery_'.$i]) !== '' ? trim($data['hdelivery_'.$i]) : '';
           $hremarks = trim($data['hremarks_'.$i]) !== '' ? trim($data['hremarks_'.$i]) : '';

            if ($no_pisigp !== '' || $no !== ''){
                 $cekModelLine4 = $entity->cekModelLine4($no_pisigp,$hno);
                 if($cekModelLine4->count() > 0) {
                    DB::table("pishtreatements")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $hno)
                      ->update(['item' =>$sitem,
                                'nominal' =>$snominal,
                                'tolerance' => $stolerance,
                                'instrument' => $sinstrument,
                                'rank' => $srank,
                                'proses' => $sproses,
                                'delivery' => $sdelivery,
                                'remarks' => $sremarks,
                              ]);
                  } 
                else{
                   DB::table("pishtreatements")
                   ->insert([ 
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$hno,
                       'item' =>$hitem,
                       'nominal' =>$hnominal,
                       'tolerance' => $htolerance,
                       'instrument' => $hinstrument,
                       'rank' => $hrank,
                       'proses' => $hproses,
                       'delivery' => $hdelivery,
                       'remarks' => $hremarks,
                       'norev'=>$norev,
                       ]); 
                }
             }
          }

          ////II. APPEARENCE
         for ($i = 1; $i <= $jml_rows; $i++) {
           $apno = trim($data['apno_'.$i]) !== '' ? trim($data['apno_'.$i]) : '';
           $apitem = trim($data['apitem_'.$i]) !== '' ? trim($data['apitem_'.$i]) : '';
           $apnominal = trim($data['apnominal_'.$i]) !== '' ? trim($data['apnominal_'.$i]) : '';
           $aptolerance = trim($data['aptolerance_'.$i]) !== '' ? trim($data['aptolerance_'.$i]) : '';
           $apinstrument = trim($data['apinstrument_'.$i]) !== '' ? trim($data['apinstrument_'.$i]) : '';
           $aprank = trim($data['aprank_'.$i]) !== '' ? trim($data['aprank_'.$i]) : '';
           $approses = trim($data['approses_'.$i]) !== '' ? trim($data['approses_'.$i]) : '';
           $apdelivery = trim($data['apdelivery_'.$i]) !== '' ? trim($data['apdelivery_'.$i]) : '';
           $apremarks = trim($data['apremarks_'.$i]) !== '' ? trim($data['apremarks_'.$i]) : '';

              if ($no_pisigp !== ''){
                 $cekModelLine5 = $entity->cekModelLine5($no_pisigp,$apno);
                 if($cekModelLine5->count() > 0) {
                    DB::table("pisappearences")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $apno)
                      ->update(['item' =>$apitem,
                                'nominal' =>$apnominal,
                                'tolerance' => $aptolerance,
                                'instrument' => $apinstrument,
                                'rank' => $aprank,
                                'proses' => $approses,
                                'delivery' => $apdelivery,
                                'remarks' => $apremarks,
                              ]);
                  } 
                  else{
                    DB::table("pisappearences")
                   ->insert([ 
                       'no_pisigp'=>$no_pisigp ,
                       'no_pis'=>$request->no_pis,
                       'no' =>$apno,
                       'item' =>$apitem,
                       'nominal' =>$apnominal,
                       'tolerance' => $aptolerance,
                       'instrument' => $apinstrument,
                       'rank' => $aprank,
                       'proses' => $approses,
                       'delivery' => $apdelivery,
                       'remarks' => $apremarks,
                       'norev'=>$norev,
                       ]);   
                }
             }
          }

          ////III. DIMENSION
         for ($i = 1; $i <= $jml_input1; $i++) {
           $dno = trim($data['dno_'.$i]) !== '' ? trim($data['dno_'.$i]) : '';
           $ditem = trim($data['ditem_'.$i]) !== '' ? trim($data['ditem_'.$i]) : '';
           $dnominal = trim($data['dnominal_'.$i]) !== '' ? trim($data['dnominal_'.$i]) : '';
           $dtolerance = trim($data['dtolerance_'.$i]) !== '' ? trim($data['dtolerance_'.$i]) : '';
           $dinstrument = trim($data['dinstrument_'.$i]) !== '' ? trim($data['dinstrument_'.$i]) : '';
           $drank = trim($data['drank_'.$i]) !== '' ? trim($data['drank_'.$i]) : '';
           $dproses = trim($data['dproses_'.$i]) !== '' ? trim($data['dproses_'.$i]) : '';
           $ddelivery = trim($data['ddelivery_'.$i]) !== '' ? trim($data['ddelivery_'.$i]) : '';
           $dremarks = trim($data['dremarks_'.$i]) !== '' ? trim($data['dremarks_'.$i]) : '';

            if ($no_pisigp !== ''){
                 $cekModelLine6 = $entity->cekModelLine6($no_pisigp,$dno);
                 if($cekModelLine6->count() > 0) {
                    DB::table("pisdimentions")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $dno)
                      ->update(['item' =>$ditem,
                                'nominal' =>$dnominal,
                                'tolerance' => $dtolerance,
                                'instrument' => $dinstrument,
                                'rank' => $drank,
                                'proses' => $dproses,
                                'delivery' => $ddelivery,
                                'remarks' => $dremarks,
                              ]);
                  } 
                else{
                    DB::table("pisdimentions")
                   ->insert([ 
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$dno,
                       'item' =>$ditem,
                       'nominal' =>$dnominal,
                       'tolerance' => $dtolerance,
                       'instrument' => $dinstrument,
                       'rank' => $drank,
                       'proses' => $dproses,
                       'delivery' => $ddelivery,
                       'remarks' => $dremarks,
                       'norev'=>$norev,
                       ]);   
                }
             }
          }



           ////IV. SOC FREE
         for ($i = 1; $i <= $inputhidden; $i++) {
            $scno = trim($data['scno_'.$i]) !== '' ? trim($data['scno_'.$i]) : '';
            $scitem = trim($data['scitem_'.$i]) !== '' ? trim($data['scitem_'.$i]) : '';
            
            $scinstrument = trim($data['scinstrument_'.$i]) !== '' ? trim($data['scinstrument_'.$i]) : '';
            $scrank = trim($data['scrank_'.$i]) !== '' ? trim($data['scrank_'.$i]) : '';
            $scproses = trim($data['scproses_'.$i]) !== '' ? trim($data['scproses_'.$i]) : '';
            $scdeivery = trim($data['scdeivery_'.$i]) !== '' ? trim($data['scdeivery_'.$i]) : '';
            $scremarks = trim($data['scremarks_'.$i]) !== '' ? trim($data['scremarks_'.$i]) : '';

            if ($no_pisigp !== ''){
                 $cekModelLine7 = $entity->cekModelLine7($no_pisigp,$scno);
                 if($cekModelLine7->count() > 0) {
                    DB::table("pissocfs")
                      ->where("no_pisigp", $no_pisigp)
                      ->where("no", $scno)
                      ->update(['item' =>$scitem,
                                
                                'instrument' => $scinstrument,
                                'rank' => $scrank,
                                'proses' => $scproses,
                                'delivery' => $scdeivery,
                                'remarks' => $scremarks,
                              ]);
                  } 
                else{
                    DB::table("pissocfs")
                   ->insert([ 
                       'no_pisigp'=>$no_pisigp,
                       'no_pis'=>$request->no_pis,
                       'no' =>$scno,
                       'item' =>$scitem,
                       
                       'instrument' => $scinstrument,
                       'rank' => $scrank,
                       'proses' => $scproses,
                       'delivery' => $scdeivery,
                       'remarks' => $scremarks,
                       'norev'=>$norev,
                       ]);   
                }
             }
          }
        


         //    ////V. PART ROUTING
         // for ($i = 1; $i <= $barishidden; $i++) {
         //           $plevel = trim($data['plevel_'.$i]) !== '' ? trim($data['plevel_'.$i]) : '';
         //           $ppart_no = trim($data['ppart_no_'.$i]) !== '' ? trim($data['ppart_no_'.$i]) : '';
         //           $ppart_name = trim($data['ppart_name_'.$i]) !== '' ? trim($data['ppart_name_'.$i]) : '';
         //           $pproses = trim($data['pproses_'.$i]) !== '' ? trim($data['pproses_'.$i]) : '';
         //           $psupplier = trim($data['psupplier_'.$i]) !== '' ? trim($data['psupplier_'.$i]) : '';

         //    if ($no_pisigp !== ''){
         //         $cekModelLine8 = $entity->cekModelLine8($no_pisigp,$plevel);
         //         if($cekModelLine8->count() > 0) {
         //            DB::table("pisroutes")
         //              ->where("no_pisigp", $no_pisigp)
         //              ->where("level", $plevel)
         //              ->update(['level' =>$plevel,
         //                        'part_no' =>$ppart_no,
         //                        'part_name' => $ppart_name,
         //                        'proses' => $pproses,
         //                        'supplier' => $psupplier,
         //                      ]);
         //          } 
         //        else{
         //            DB::table("pisroutes")
         //           ->insert([ 
         //               'no_pisigp'=>$no_pisigp,
         //               'no_pis'=>$request->no_pis,
         //               'level' =>$plevel,
         //               'part_no' =>$ppart_no,
         //               'part_name' => $ppart_name,
         //               'proses' => $pproses,
         //               'supplier' => $psupplier,
         //               'norev'=>$norev,
         //               ]);   
         //        }
         //     }
         //  }

        
          // REVISION COLUMN
           // for ($i = 1; $i <= $jml_revisi; $i++) {
           //           $rev_no = trim($data['rev_no_'.$i]) !== '' ? trim($data['rev_no_'.$i]) : '';
           //           $date = trim($data['date_'.$i]) !== '' ? trim($data['date_'.$i]) : '';
           //           $rev_record = trim($data['rev_record_'.$i]) !== '' ? trim($data['rev_record_'.$i]) : '';
           //           $ecrno = trim($data['ecrno_'.$i]) !== '' ? trim($data['ecrno_'.$i]) : '';

           //    if ($no_pisigp !== ''){
           //         $cekModelLine9 = $entity->cekModelLine9($no_pisigp,$rev_no);
           //         if($cekModelLine9->count() > 0) {
           //            DB::table("pisrevisions")
           //              ->where("no_pisigp", $no_pisigp)
           //              ->where("rev_no", $rev_no)
           //              ->update([ 'tanggal' => $data['tanggal'],
           //                        'rev_doc' => $rev_record,
           //                        'ecrno' => $ecrno,
           //                      ]);
           //          } 
           //        else{
           //            DB::table("pisrevisions")
           //           ->insert([ 
           //               'no_pisigp'=>$no_pisigp,
           //               'no_pis'=>$request->no_pis,
           //               'rev_no' =>$rev_no,
           //               'tanggal' => $data['tanggal'],
           //               'rev_doc' => $rev_record,
           //               'ecrno' => $ecrno,
           //               'norev'=>$request->norev,
           //               ]);   
           //        }
           //     }
           //  }    
      
          // echo json_encode($pistandard) ;
          //   die();
        return redirect()->route('pistandards.index');    
    }

    public function getrevisi($no_pisigp,$norev)
    {
        //
         $no_pisigp = base64_decode($no_pisigp); 
         $norev = base64_decode($norev); 

         $pistandard = DB::table('pistandards')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->where(DB::raw("norev"), '=', $norev)
                    ->first();
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
                     ->where(DB::raw("norev"), '=', $norev)
                    ->first();

        $logo_supplier = "";
            if (!empty($pistandard->logo_supplier)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."logospy".DIRECTORY_SEPARATOR.$pistandard->logo_supplier;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\logospy\\".$pistandard->logo_supplier;
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
            if (!empty($pistandard->part_routing)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."pis".DIRECTORY_SEPARATOR."part_routing".DIRECTORY_SEPARATOR.$pistandard->part_routing;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\pis\\part_routing\\".$pistandard->part_routing;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $part_routing = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $entity = new Pistandard();
            
            // echo json_encode($logo_supplier) ;
            // die();

     return view('pis.supplier.revisi')->with(compact(['pistandards ','part_routing','approve_dept','approve_sect','approve_staff','sketchdrawing','sketchmmethode','sketchappearance','manager_spy','supervisor_spy','staff_spy','logo_supplier','pistandard','composition','properties','performances','treatements','htreatements','appearences','dimentions','socfs','routs','revisi', 'entity']));
    } 


    public function postrevisi(Request $request)
    {
        //
         $data = $request->all();
         $no_pisigp = $data['no_pisigp'];    
         $norev = $data['norev'];  
         $jml_line1 = trim($data['jml_line1']) !== '' ? trim($data['jml_line1']) : '0';
         $jml_linee = trim($data['jml_linee']) !== '' ? trim($data['jml_linee']) : '0';
         $jml_line3 = trim($data['jml_line3']) !== '' ? trim($data['jml_line3']) : '0';
         $jml_line4 = trim($data['jml_line4']) !== '' ? trim($data['jml_line4']) : '0';
         $jml_line5 = trim($data['jml_line5']) !== '' ? trim($data['jml_line5']) : '0';
         $jml_rows = trim($data['jml_rows']) !== '' ? trim($data['jml_rows']) : '0';
         $jml_input1 = trim($data['jml_input1']) !== '' ? trim($data['jml_input1']) : '0';
         $inputhidden = trim($data['inputhidden']) !== '' ? trim($data['inputhidden']) : '0';
         // $p = trim($data['barishidden']) !== '' ? trim($data['barishidden']) : '0';
         // $jml_revisi = trim($data['jml_revisi']) !== '' ? trim($data['jml_revisi']) : '0';

         $no_pis = trim($data['no_pis']) !== '' ? trim($data['no_pis']) : null;
         $model = trim($data['model']) !== '' ? trim($data['model']) : null;
         $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;  
         $part_name = trim($data['part_name']) !== '' ? trim($data['part_name']) : null;
         $nama_supplier = trim($data['nama_supplier']) !== '' ? trim($data['nama_supplier']) : null;
         $reff_no = trim($data['reff_no']) !== '' ? trim($data['reff_no']) : null;
         $date_issue = trim($data['date_issue']) !== '' ? trim($data['date_issue']) : null;
         $material = trim($data['material']) !== '' ? trim($data['material']) : null;
         $weight = trim($data['weight']) !== '' ? trim($data['weight']) : null;
         $supp_dept = trim($data['supp_dept']) !== '' ? trim($data['supp_dept']) : null;
         $staff_name = trim($data['staff_name']) !== '' ? trim($data['staff_name']) : null;
         $supervisor_name = trim($data['supervisor_name']) !== '' ? trim($data['supervisor_name']) : null;
         $manager_name = trim($data['manager_name']) !== '' ? trim($data['manager_name']) : null;
         $status_doc = trim($data['status_doc']) !== '' ? trim($data['status_doc']) : null;
                          


         $thn = Carbon::now()->format('y');

               // input Tanggal
         $date = Carbon::now()->format('d-m-Y');    
         $time = Carbon::now()->format('H:i:s'); 
         $jamTgl = $date." ".$time;
         $jamTgl=date("Y-m-d H:i:s",strtotime($jamTgl)); 
         $data['date_issue'] = $jamTgl; 

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
    
         $entity = new Pistandard;
         $pistandard = DB::table('pistandards')
         ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
         ->where(DB::raw("norev"), '=', $norev)
         ->first(); 
    
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

            // no_rev otomatis
             $nourutakhir=DB::table("pistandards")
                          ->where("no_pisigp")
                          ->max("norev");
             $nourut=$nourutakhir;
             $nourut++;
             $new_no_doc['norev']= $nourut;
             
            // echo $new_no_doc['norev'];

               // no_doc otomatis
            $nourutakhir=DB::table("pistandards")
                        ->orderBy('date_issue', 'desc')
                        ->value('no_pisigp');

            $nourut=(int) substr($nourutakhir,7,10);
            $nourut++;
            $new_no_doc['no_pisigp']='PIS'. sprintf('%05s',$nourut);

            $approve_staff='approve_staff';
            $supervisor_spy='supervisor_spy';
            $supervisor_spy='manager_spy';

             $pistandard = DB::table('pistandards')
                    ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->where(DB::raw("norev"), '=', $norev)
                    ->first();
              $dateissue=$pistandard->date_issue;

              DB::table("pistandards")
              ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
              ->where(DB::raw("norev"), '=', $norev)
              ->update([
                'status'=>5,]);   


        switch ($request->input('aksi')){
            case 'saverevisi': 
                 //action save  REVISI here

                DB::table("pistandards")
                  ->insert([ 
                          'no_pisigp'=>$request->no_pisigp,
                          'no_pis'=>$request->no_pis,
                          'model'=>$request->model,
                          'part_no'=>$request->part_no,
                          'part_name'=>$request->part_name,
                          'nama_supplier'=>$request->nama_supplier,
                          'reff_no'=>$request->reff_no,
                          'material'=>$request->material,
                          'general_tol'=>json_encode($request->generaltol),
                          'weight'=>$request->weight,
                          'supp_dept'=>$request->supp_dept,
                          'status'=>1,
                           'date_issue'=>$dateissue,
                          'tgl_submit'=> $data['tgl_submit'],
                          'logo_supplier'=>$request->logo_supplier = $filename1,
                          'staff_spy'=>$request->staff_spy = $filename2,
                          'supervisor_spy'=>$request->supervisor_spy = $filename3,
                          'manager_spy'=>$request->manager_spy = $filename4,
                          'sketchdrawing'=>$request->sketchdrawing = $filename5,
                          'sketchmmethode'=>$request->sketchmmethode = $filename6,
                          'sketchappearance'=>$request->sketchappearance = $filename7,
                          'norev'=> $new_no_doc['norev'],
                          'submit'=> 1,
                          'email'=>$request->email,
                          'status_doc'=>$request->status_doc,
                          'staff_name'=>$request->staff_name,
                          'supervisor_name'=>$request->supervisor_name,
                          'manager_name'=>$request->manager_name,
                          'kode_supp'=>$request->kd_supp,
                          'part_routing'=>$request->part_routing= $filename8,
                           ]);        
           
                $to = [];
                   
                   array_push($to, "fadlya179@gmail.com");

                   $pis=$request->no_pis;
                   $tgl= $data['tgl_submit'];
                   $supplier= $request->nama_supplier;
                   Mail::send('pis.supplier.emailsubmit', compact('pis','tgl','supplier'), function ($m) use ($to, $no_pis) {
                    $m->to($to)

                    ->subject('PIS: '.$no_pis);
                  });     
                
                Alert::success("Berhasil Submit","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");
            break;
            case 'save_draftrevisi': 
                  //action for save-draft REVISI here
                DB::table("pistandards")
                   ->where(DB::raw("no_pisigp"), '=', $no_pisigp)
                    ->where(DB::raw("norev"), '=', $norev)
                   ->update(['status'=>5,]);  

                  DB::table("pistandards")
                     ->insert([

                              'no_pisigp'=>$request->no_pisigp,
                              'no_pis'=>$request->no_pis,
                              'model'=>$request->model,
                              'part_no'=>$request->part_no,
                              'part_name'=>$request->part_name,
                              'nama_supplier'=>$request->nama_supplier,
                              'reff_no'=>$request->reff_no,
                              'material'=>$request->material,
                              'general_tol'=>json_encode($request->generaltol),
                              'weight'=>$request->weight,
                              'supp_dept'=>$request->supp_dept,
                              'date_issue'=>$dateissue,
                              'tgl_draft'=>$data['tgl_draft'],
                              'logo_supplier'=>$request->logo_supplier = $filename1,
                              'staff_spy'=>$request->staff_spy = $filename2,
                              'supervisor_spy'=>$request->supervisor_spy = $filename3,
                              'manager_spy'=>$request->manager_spy = $filename4,
                              'sketchdrawing'=>$request->sketchdrawing = $filename5,
                              'sketchmmethode'=>$request->sketchmmethode = $filename6,
                              'sketchappearance'=>$request->sketchappearance = $filename7,
                              'norev'=> $new_no_doc['norev'],
                              'submit'=> 1,
                              'email'=>$request->email,
                              'status_doc'=>$request->status_doc,
                              'staff_name'=>$request->staff_name,
                              'supervisor_name'=>$request->supervisor_name,
                              'manager_name'=>$request->manager_name,
                              'kode_supp'=>$request->kd_supp,
                              'part_routing'=>$request->part_routing= $filename8,

                             ]);  
                                  
                    Alert::success("Data Disimpan Sebagai Draft","Nomor $request->no_pis")
                      ->autoclose(2000000)
                      ->persistent("Close");  
            break;
        }
       
                   /////CHEMICAL COMPOSITION
             for ($i = 1; $i <= $jml_line1; $i++) {
                   $cno = trim($data['cno_'.$i]) !== '' ? trim($data['cno_'.$i]) : '';
                   $citem = trim($data['citem_'.$i]) !== '' ? trim($data['citem_'.$i]) : '';
                   $cnom = trim($data['cnom_'.$i]) !== '' ? trim($data['cnom_'.$i]) : '';
                   $ctol = trim($data['ctol_'.$i]) !== '' ? trim($data['ctol_'.$i]) : '';
                   $cins = trim($data['cins_'.$i]) !== '' ? trim($data['cins_'.$i]) : '';
                   $crank = trim($data['crank_'.$i]) !== '' ? trim($data['crank_'.$i]) : '';
                   $cpro = trim($data['cpro_'.$i]) !== '' ? trim($data['cpro_'.$i]) : '';
                   $cdel = trim($data['cdel_'.$i]) !== '' ? trim($data['cdel_'.$i]) : '';
                   $crem = trim($data['crem_'.$i]) !== '' ? trim($data['crem_'.$i]) : '';
                    // no_doc otomatis
                   
                   if($citem !== "" || $cnom !== "" || $ctol !== "" || $cins !== "" || $crank !== "" || $cpro !== "" || $cdel !== "" || $crem !== ""){
                    DB::table("pisccompositions")
                   ->insert([
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
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
                         
                       ]);   
                   }
                }

                  ////////////MECHANICAL PROPERTIES
                for ($i = 1; $i <= $jml_linee; $i++) {
                   $mno = trim($data['mno_'.$i]) !== '' ? trim($data['mno_'.$i]) : '';
                   $mitem = trim($data['mitem_'.$i]) !== '' ? trim($data['mitem_'.$i]) : '';
                   $mnom = trim($data['mnom_'.$i]) !== '' ? trim($data['mnom_'.$i]) : '';
                   $mtol = trim($data['mtol_'.$i]) !== '' ? trim($data['mtol_'.$i]) : '';
                   $mins = trim($data['mins_'.$i]) !== '' ? trim($data['mins_'.$i]) : '';
                   $mrank = trim($data['mrank_'.$i]) !== '' ? trim($data['mrank_'.$i]) : '';
                   $mpro = trim($data['mpro_'.$i]) !== '' ? trim($data['mpro_'.$i]) : '';
                   $mdel = trim($data['mdel_'.$i]) !== '' ? trim($data['mdel_'.$i]) : '';
                   $mrem = trim($data['mrem_'.$i]) !== '' ? trim($data['mrem_'.$i]) : '';

                   if ($mitem !== "" || $mnom !== "" || $mtol !== "" || $mins !== "" || $mrank !== "" || $mpro !== "" || $mdel !== "" || $mrem !== "") {
                     DB::table("pismproperties")
                   ->insert([
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$mno,
                       'item' =>$mitem,
                       'nominal' =>$mnom,
                       'tolerance' => $mtol,
                       'instrument' => $mins,
                       'rank' => $mrank,
                       'proses' => $mpro,
                       'delivery' => $mdel,
                       'remarks' => $mrem,
                       'norev'=> $new_no_doc['norev'],
                       ]);
                   }
                  
                }

                ////WELDING PERFORMANCE (IF ANY)
                for ($i = 1; $i <= $jml_line3; $i++) {
                   $wno = trim($data['wno_'.$i]) !== '' ? trim($data['wno_'.$i]) : '';
                   $witem = trim($data['witem_'.$i]) !== '' ? trim($data['witem_'.$i]) : '';
                   $wnom = trim($data['wnom_'.$i]) !== '' ? trim($data['wnom_'.$i]) : '';
                   $wtol = trim($data['wtol_'.$i]) !== '' ? trim($data['wtol_'.$i]) : '';
                   $wins = trim($data['wins_'.$i]) !== '' ? trim($data['wins_'.$i]) : '';
                   $wrank = trim($data['wrank_'.$i]) !== '' ? trim($data['wrank_'.$i]) : '';
                   $wpro = trim($data['wpro_'.$i]) !== '' ? trim($data['wpro_'.$i]) : '';
                   $wdel = trim($data['wdel_'.$i]) !== '' ? trim($data['wdel_'.$i]) : '';
                   $wrem = trim($data['wrem_'.$i]) !== '' ? trim($data['wrem_'.$i]) : '';

                   if ($witem !== "" || $wnom !== "" || $mtol !== "" || $mins !== "" || $mrank !== "" || $mpro !== "" || $mdel !== "" || $mrem !== "") {
                      DB::table("piswperformances")
                         ->insert([ 
                            'no_pisigp'=>$new_no_doc['no_pisigp'],
                           'no_pis'=>$request->no_pis,
                           'no' =>$wno,
                           'item' =>$witem,
                           'nominal' =>$wnom,
                           'tolerance' => $wtol,
                           'instrument' => $wins,
                           'rank' => $wrank,
                           'proses' => $wpro,
                           'delivery' => $wdel,
                           'remarks' => $wrem,
                           'norev'=> $new_no_doc['norev'],
                           ]);   
                      }    
                  
                  }

                  //SURFACE TREATMENT (IF ANY)
                for ($i = 1; $i <= $jml_line4; $i++) {
                   $sno = trim($data['sno_'.$i]) !== '' ? trim($data['sno_'.$i]) : '';
                   $sitem = trim($data['sitem_'.$i]) !== '' ? trim($data['sitem_'.$i]) : '';
                   $snominal = trim($data['snominal_'.$i]) !== '' ? trim($data['snominal_'.$i]) : '';
                   $stolerance = trim($data['stolerance_'.$i]) !== '' ? trim($data['stolerance_'.$i]) : '';
                   $sinstrument = trim($data['sinstrument_'.$i]) !== '' ? trim($data['sinstrument_'.$i]) : '';
                   $srank = trim($data['srank_'.$i]) !== '' ? trim($data['srank_'.$i]) : '';
                   $sproses = trim($data['sproses_'.$i]) !== '' ? trim($data['sproses_'.$i]) : '';
                   $sdelivery = trim($data['sdelivery_'.$i]) !== '' ? trim($data['sdelivery_'.$i]) : '';
                   $sremarks = trim($data['sremarks_'.$i]) !== '' ? trim($data['sremarks_'.$i]) : '';

                   if ($sitem !== "" || $snominal !== "" || $stolerance !== "" || $sinstrument !== "" || $srank !== "" || $sproses !== "" || $sdelivery !== "" || $sremarks !== "") {
                    DB::table("pisstreatements")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$sno,
                       'item' =>$sitem,
                       'nominal' =>$snominal,
                       'tolerance' => $stolerance,
                       'instrument' => $sinstrument,
                       'rank' => $srank,
                       'proses' => $sproses,
                       'delivery' => $sdelivery,
                       'remarks' => $sremarks,
                        'norev'=> $new_no_doc['norev'],
                       ]);   
                   }
                   
                }

                 //HEAT TREATMENT (IF ANY)
                for ($i = 1; $i <= $jml_line5; $i++) {
                   $hno = trim($data['hno_'.$i]) !== '' ? trim($data['hno_'.$i]) : '';
                   $hitem = trim($data['hitem_'.$i]) !== '' ? trim($data['hitem_'.$i]) : '';
                   $hnominal = trim($data['hnominal_'.$i]) !== '' ? trim($data['hnominal_'.$i]) : '';
                   $htolerance = trim($data['htolerance_'.$i]) !== '' ? trim($data['htolerance_'.$i]) : '';
                   $hinstrument = trim($data['hinstrument_'.$i]) !== '' ? trim($data['hinstrument_'.$i]) : '';
                   $hrank = trim($data['hrank_'.$i]) !== '' ? trim($data['hrank_'.$i]) : '';
                   $hproses = trim($data['hproses_'.$i]) !== '' ? trim($data['hproses_'.$i]) : '';
                   $hdelivery = trim($data['hdelivery_'.$i]) !== '' ? trim($data['hdelivery_'.$i]) : '';
                   $hremarks = trim($data['hremarks_'.$i]) !== '' ? trim($data['hremarks_'.$i]) : '';

                   if ($hitem !== "" || $hnominal !== "" || $htolerance !== "" || $hinstrument !== "" || $hrank !== "" || $hproses !== "" || $hdelivery !== "" || $hremarks !== "") {
                     DB::table("pishtreatements")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$hno,
                       'item' =>$hitem,
                       'nominal' =>$hnominal,
                       'tolerance' => $htolerance,
                       'instrument' => $hinstrument,
                       'rank' => $hrank,
                       'proses' => $hproses,
                       'delivery' => $hdelivery,
                       'remarks' => $hremarks,
                       'norev'=>$new_no_doc['norev'],
                       ]);   
                   }
                   
                }

                 // APPEARENCE
                for ($i = 1; $i <= $jml_rows; $i++) {
                   $apno = trim($data['apno_'.$i]) !== '' ? trim($data['apno_'.$i]) : '';
                   $apitem = trim($data['apitem_'.$i]) !== '' ? trim($data['apitem_'.$i]) : '';
                   $apnominal = trim($data['apnominal_'.$i]) !== '' ? trim($data['apnominal_'.$i]) : '';
                   $aptolerance = trim($data['aptolerance_'.$i]) !== '' ? trim($data['aptolerance_'.$i]) : '';
                   $apinstrument = trim($data['apinstrument_'.$i]) !== '' ? trim($data['apinstrument_'.$i]) : '';
                   $aprank = trim($data['aprank_'.$i]) !== '' ? trim($data['aprank_'.$i]) : '';
                   $approses = trim($data['approses_'.$i]) !== '' ? trim($data['approses_'.$i]) : '';
                   $apdelivery = trim($data['apdelivery_'.$i]) !== '' ? trim($data['apdelivery_'.$i]) : '';
                   $apremarks = trim($data['apremarks_'.$i]) !== '' ? trim($data['apremarks_'.$i]) : '';

                   if ($apitem !== "" || $apnominal !== "" || $aptolerance !== "" || $apinstrument !== "" || $aprank !== "" || $approses !== "" || $apdelivery !== "" || $apremarks !== "") {
                      DB::table("pisappearences")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$apno,
                       'item' =>$apitem,
                       'nominal' =>$apnominal,
                       'tolerance' => $aptolerance,
                       'instrument' => $apinstrument,
                       'rank' => $aprank,
                       'proses' => $approses,
                       'delivery' => $apdelivery,
                       'remarks' => $apremarks,
                        'norev'=> $new_no_doc['norev'],
                       ]);   
                   }
                  
                }

                 ///DIMENSION
                for ($i = 1; $i <= $jml_input1; $i++) {
                   $dno = trim($data['dno_'.$i]) !== '' ? trim($data['dno_'.$i]) : '';
                   $ditem = trim($data['ditem_'.$i]) !== '' ? trim($data['ditem_'.$i]) : '';
                   $dnominal = trim($data['dnominal_'.$i]) !== '' ? trim($data['dnominal_'.$i]) : '';
                   $dtolerance = trim($data['dtolerance_'.$i]) !== '' ? trim($data['dtolerance_'.$i]) : '';
                   $dinstrument = trim($data['dinstrument_'.$i]) !== '' ? trim($data['dinstrument_'.$i]) : '';
                   $drank = trim($data['drank_'.$i]) !== '' ? trim($data['drank_'.$i]) : '';
                   $dproses = trim($data['dproses_'.$i]) !== '' ? trim($data['dproses_'.$i]) : '';
                   $ddelivery = trim($data['ddelivery_'.$i]) !== '' ? trim($data['ddelivery_'.$i]) : '';
                   $dremarks = trim($data['dremarks_'.$i]) !== '' ? trim($data['dremarks_'.$i]) : '';

                   if ($ditem !== "" || $dnominal !== "" || $dtolerance !== "" || $dinstrument !== "" || $drank !== "" || $dproses !== "" || $ddelivery !== "" || $dremarks !== "") {
                      DB::table("pisdimentions")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$dno,
                       'item' =>$ditem,
                       'nominal' =>$dnominal,
                       'tolerance' => $dtolerance,
                       'instrument' => $dinstrument,
                       'rank' => $drank,
                       'proses' => $dproses,
                       'delivery' => $ddelivery,
                       'remarks' => $dremarks,
                       'norev'=> $new_no_doc['norev'],
                       ]);   
                   }
                  
                }

                  //SOC FREE
                for ($i = 1; $i <= $inputhidden; $i++) {
                   $scno = trim($data['scno_'.$i]) !== '' ? trim($data['scno_'.$i]) : '';
                   $scitem = trim($data['scitem_'.$i]) !== '' ? trim($data['scitem_'.$i]) : '';
                  
                   $scinstrument = trim($data['scinstrument_'.$i]) !== '' ? trim($data['scinstrument_'.$i]) : '';
                   $scrank = trim($data['scrank_'.$i]) !== '' ? trim($data['scrank_'.$i]) : '';
                   $scproses = trim($data['scproses_'.$i]) !== '' ? trim($data['scproses_'.$i]) : '';
                   $scdelivery = trim($data['scdelivery_'.$i]) !== '' ? trim($data['scdelivery_'.$i]) : '';
                   $scremarks = trim($data['scremarks_'.$i]) !== '' ? trim($data['scremarks_'.$i]) : '';

                   if ($scitem !== "" || $scinstrument !== "" || $scrank !== "" || $scproses !== "" || $scdelivery !== "" || $scremarks !== "") {
                      DB::table("pissocfs")
                   ->insert([ 
                       'no_pisigp'=>$new_no_doc['no_pisigp'],
                       'no_pis'=>$request->no_pis,
                       'no' =>$scno,
                       'item' =>$scitem,
                      
                       'instrument' => $scinstrument,
                       'rank' => $scrank,
                       'proses' => $scproses,
                       'delivery' => $scdelivery,
                       'remarks' => $scremarks,
                       'norev'=> $new_no_doc['norev'],
                       ]);   
                   }
                  
                }

                  ///PART ROUTING
                // for ($i = 1; $i <= $barishidden; $i++) {
                //    $plevel = trim($data['plevel_'.$i]) !== '' ? trim($data['plevel_'.$i]) : '';
                //    $ppart_no = trim($data['ppart_no_'.$i]) !== '' ? trim($data['ppart_no_'.$i]) : '';
                //    $ppart_name = trim($data['ppart_name_'.$i]) !== '' ? trim($data['ppart_name_'.$i]) : '';
                //    $pproses = trim($data['pproses_'.$i]) !== '' ? trim($data['pproses_'.$i]) : '';
                //    $psupplier = trim($data['psupplier_'.$i]) !== '' ? trim($data['psupplier_'.$i]) : '';
                  
                //    if ($plevel !== "" || $ppart_no !== "" || $ppart_name !== "" || $pproses !== "" || $psupplier !== "" ) {
                //       DB::table("pisroutes")
                //    ->insert([ 
                //        'no_pisigp'=>$new_no_doc['no_pisigp'],
                //        'no_pis'=>$request->no_pis,
                //        'level' =>$plevel,
                //        'part_no' =>$ppart_no,
                //        'part_name' => $ppart_name,
                //        'proses' => $pproses,
                //        'supplier' => $psupplier,
                //         'norev'=> $new_no_doc['norev'],
                //        ]);   
                //    }
                  
                // }

        
          // REVISION COLUMN REVISI
         // for ($i = 1; $i <= $jml_revisi; $i++) {
         //           $rev_no = trim($data['rev_no_'.$i]) !== '' ? trim($data['rev_no_'.$i]) : '';
         //           $date = trim($data['date_'.$i]) !== '' ? trim($data['date_'.$i]) : '';
         //           $rev_record = trim($data['rev_record_'.$i]) !== '' ? trim($data['rev_record_'.$i]) : '';
         //           $ecrno = trim($data['ecrno_'.$i]) !== '' ? trim($data['ecrno_'.$i]) : '';

         //    if ($plevel !== "" || $ppart_no !== "" || $ppart_name !== "" || $pproses !== "" || $psupplier !== "" ) {
         //              DB::table("pisrevisions")
         //           ->insert([ 
         //               'no_pisigp'=>$new_no_doc['no_pisigp'],
         //               'no_pis'=>$request->no_pis,
         //               'rev_no' =>$rev_no,
         //               'tanggal' => $data['tanggal'],
         //               'rev_doc' => $rev_record,
         //               'ecrno' => $ecrno,
         //               'norev'=> $new_no_doc['norev'],
         //               ]);   
         //           }
         //  }      
      
          // echo json_encode($pistandard) ;
          //   die();
        return redirect()->route('pistandards.index');    
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

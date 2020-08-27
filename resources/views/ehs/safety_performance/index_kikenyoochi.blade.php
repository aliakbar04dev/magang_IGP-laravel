@extends('layouts.app')
@section('content')

<style>
  

 
/* various containers */
.container {
    width: 200px;
    margin: 0 auto;
}
.canvas-container {
    min-height: 300px;
    max-height: 600px;
    position: relative;
}
.widget {
    position: relative;
    margin-bottom: 80px;
    background: #fff;
    padding: 7px;
    border-color: #f7f8ff;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;

}



.ship:before { background-color: #637b85; }
.rework:before { background-color: #2c9c69; }
.admin:before { background-color: #dbba34; }
.prod:before { background-color: #c62f29; }



.widget p {
    margin-top: 0;
    text-align: center;
     font-size: 1.5em;
}
.widget h4 {
    margin: 1px 1 1px 1px;
    padding: 0px;
    width: 100%;
    text-align: center;
    color: #f7f8ff;
    line-height: 2em;
    background: #777;
}
.widget.line p span {
    color: #dbba34;
}
.widget.line p strong {
    color: #637b85;
    font-weight: 400;
}


@media only screen and (min-width:300px){
    .container {
        width: 300px;
        margin: 0 auto;
    }
}
 
@media only screen and (min-width:600px){
    .container {
        width: 600px;
        margin: 0 auto;
    }
    .third {
        float: left;
        width: 46%;
        margin-left: 1%;
        margin-right: 1%;
    }
    .third:first-child {
        margin-left: 0;
    }
    .third:last-child {
        display: block;
        width: 46%;
        margin-left: 1%;
        margin-right: 1%;

    }
    .second{
        width: 80%;
         margin: 0 auto;
        display: inline-block;  
        text-align: center;
        vertical-align: middle;

    }
     .first{
      float: center;
        width: 45%;
        margin-left: 3%;
        margin-right: 3%;
    }
}
 
@media only screen and (min-width:960px){
    .container {
        width: 960px;
    }
    .third {
        float: center;
        width: 45%;      
    }
    .third:first-child {
    }
    .third:last-child {
        width: 45%;
        margin-right: 5%;
    }
     .second{
      float: center;
        width: 70%;
        margin-left: 5%;
        margin-right: 5%;
    }
    .first{
      float: center;
        width: 45%;
        margin-left: 3%;
        margin-right: 3%;
    }
}
@media only screen and (min-width:1140px){
    .container {
        width: 1120px;
    }
}
@media only screen and (min-width:1360px){
    .container {
        width: 1300px;
    }
}
</style>

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Environment Performance
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Environment Performance</li>
      </ol>
    </section>

    <!-- Main content -->
   
 <section class="content">

 <div class="container clearfix">
    <div class="row third">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring Level Instalasi Air Limbah</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                     <div class="canvas-container">
                         <h5 align="center"><b>Level Instalasi Air Limbah {{\Carbon\Carbon::now()->format('d F Y')}}</b></h5><img src="{{ asset('images/red.png') }}" alt="X"> Emergency
                        <img src="{{ asset('images/yellow.png') }}" alt="X"> Warning
                        <img src="{{ asset('images/green.png') }}" alt="X"> Normal
                        <canvas id="levelair" class="canvas-container" ></canvas>
                   </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


          <div class="row third">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring Pemakaian Bahan Kimia </h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                     <h5 align="center"><b>Pemakaian Bahan Kimia {{\Carbon\Carbon::now()->format('d F Y')}}  </b></h5>
                   <img src="{{ asset('images/red.png') }}" alt="X"> Emergency
                    <img src="{{ asset('images/green.png') }}" alt="X"> Normal   
                      <canvas id="pbkimia" class="canvas-container" ></canvas>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          </div>

          
           <div class="row"  >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik Festronik Limbah B3 {{\Carbon\Carbon::now()->format('F Y')}}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <center>
                      <div class="col align-self-center" style="width:80%">
                      <canvas class="canvas-container" id="grafik_festronik" ></canvas>
                     </div>
                  </center>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


           <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring Pengangkutan Limbah B3 IGP Group Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <center>
                   <div class="col align-self-center" style="width:80%">
                      <canvas id="angkut" class="canvas-container" ></canvas>
                  </div>
                  </center>


                  <div class="col align-self-center" id="divhide">
                   <h2 align="center">Monitoring Festronik {{\Carbon\Carbon::now()->format('F Y')}}</h2>
                  <div class="chart-legend">
                      <canvas id="festronik" class="canvas-container" ></canvas>
                  </div>
                  </div>
                    <hr>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->






           <div class="row" style="display:none;">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring Equipment & Facility</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <center>
                  <div class="col align-self-center" style="width:80%">
                  <div class="chart-legend">
                      <canvas id="equipment" class="canvas-container" ></canvas>
                  </div>
                  </div>
                </center>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


           


           <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">SWAPANTAU {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <h2 align="center">Monitoring WWT {{\Carbon\Carbon::now()->format('F Y')}}</h2>
                  <center>
                  <div class="col align-self-center" style="width:80%">
                     <canvas id="wwtph" class="canvas-container" ></canvas> 
                  </div>
                  </center>

                  <center>
                  <div class="col align-self-center" style="width:80%">
                      <canvas id="wwtdebit" class="canvas-container" ></canvas>
                  </div>
                  </center>
                  <hr>
                   <h2 align="center">Monitoring STP {{\Carbon\Carbon::now()->format('F Y')}}</h2>

                  <center>
                  <div class="col align-self-center" style="width:80%">
                      <canvas id="stpph" class="canvas-container" ></canvas>
                  </div>
                  </center>

                  <center>
                  <div class="col align-self-center" style="width:80%">
                      <canvas id="stpdebit" class="canvas-container" ></canvas>
                  </div>
                  </center>
                 
           
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->




    </section> 

</div>
  
@endsection


@section('scripts')
<script src="{{asset('js/Chart.min.js')}}"></script>
<script>
    var bulan = ['Jan','Feb','Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des'];
    var labeltgl = <?php echo $labeltgl; ?>;

    var pembk1 = <?php echo $pembk1; ?>;
    var pembk2 = <?php echo $pembk2; ?>;
    var pembk3 = <?php echo $pembk3; ?>;
    var pembk4 = <?php echo $pembk4; ?>;
    var pembk5 = <?php echo $pembk5; ?>;
    var pembk6 = <?php echo $pembk6; ?>;
    var pembk7 = <?php echo $pembk7; ?>;
    var label_pk = <?php echo $label_pk; ?>;


    var label_lal = <?php echo $label_lal; ?>;
    var lal_wwt = <?php echo $lal_wwt; ?>;
    var lal_stp = <?php echo $lal_stp; ?>;
    var lal_bs = <?php echo $lal_bs; ?>;
    var lal_et = <?php echo $lal_et; ?>;

    var transporter_ng = <?php echo $transporter_ng; ?>;
    var transporter_ok = <?php echo $transporter_ok; ?>;
    var penghasil_ok = <?php echo $penghasil_ok; ?>;
    var penerima_ok = <?php echo $penerima_ok; ?>;

    var wwtp_ng = <?php echo $wwtp_ng; ?>;
    var wwtp_ok = <?php echo $wwtp_ok; ?>;
    var stp_ng = <?php echo $stp_ng; ?>;
    var stp_ok = <?php echo $stp_ok; ?>;

    var sipal = <?php echo $sipal; ?>;
    var kembekas = <?php echo $kembekas; ?>;
    var kainmajun = <?php echo $kainmajun; ?>;
    var plumasbekas = <?php echo $plumasbekas; ?>;
    var spainting = <?php echo $spainting; ?>;
    var soil = <?php echo $soil; ?>;
    var akibekas = <?php echo $akibekas; ?>;
    var emulsiminyak = <?php echo $emulsiminyak; ?>;
    var bkkadaluarsa = <?php echo $bkkadaluarsa; ?>;
    var lklinis = <?php echo $lklinis; ?>;
    var fbekas = <?php echo $fbekas; ?>;
    var elektronik = <?php echo $elektronik; ?>;
    var spengolahan = <?php echo $spengolahan; ?>;
    var lbdegreasing = <?php echo $lbdegreasing; ?>;
    var kbtinta = <?php echo $kbtinta; ?>;
    var rmanufaktur = <?php echo $rmanufaktur; ?>;
    var avglimbahthnlalu = <?php echo $avglimbahthnlalu; ?>;


    var phwwt = <?php echo $phwwt; ?>;
    var debitwwt = <?php echo $debitwwt; ?>;
    var phstp = <?php echo $phstp; ?>;
    var debitstp = <?php echo $debitstp; ?>;

    //GRAFIK FESTRONIK
     var sipal_tr = <?php echo $sipal_tr; ?>;
     var sipal_pk = <?php echo $sipal_pk; ?>;
     var sipal_pn = <?php echo $sipal_pn; ?>;


    var dateE = <?php echo $dateE; ?>;

    var target =  avglimbahthnlalu - (avglimbahthnlalu*3/100);
    var tgl = [];
    var maxph = [];
    var minph = [];
    var stddebitwwt = [];
    var stddebitstp = [];
    var avglalu = [];
    var avgtarget = [];

    
    for (i = 1; i <= dateE; i++) {
    avglalu.push(avglimbahthnlalu.toString());
    avgtarget.push(target.toString());
    tgl.push(i);
    maxph.push('9');
    minph.push('6');
    stddebitwwt.push('86');
    stddebitstp.push('80');

   // super_array.push(sub_array.concat());
    }
  

    //WWT PH
    var WWTPHChartData = {
        labels: tgl ,
        datasets: [{
            borderColor: "rgba(151,187,205,5)",
            data: phwwt,
            label : 'pH',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: maxph,
            label: 'Baku Mutu',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: minph,
            label: 'Baku Mutu',
        }]
    };

  //WWT DEBIT
    var WWTDebitChartData = {
        labels: tgl ,
        datasets: [{
            borderColor: "rgba(151,187,205,5)",
            data: debitwwt,
            label : 'Debit (M3)',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: stddebitwwt,
            label: 'Standar',
        }]
    };

  //STP PH
 var STPPHChartData = {
        labels: tgl ,
        datasets: [{
            borderColor: "rgba(151,187,205,5)",
            data: phstp,
            label : 'pH',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: maxph,
            label: 'Baku Mutu',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: minph,
            label: 'Baku Mutu',
        }]
    };

  //STPDEBIT

    var STPDebitChartData = {
        labels: tgl ,
        datasets: [{
            borderColor: "rgba(151,187,205,5)",
            data: debitstp,
            label : 'Debit (M3)',
             }, {
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: '#FF0000',
            data: stddebitstp,
            label: 'Standar',
        }]
    };


    //Equipment Facility
    var EquipmentChartData = {
        labels: ['WWTP', 'STP'],
        datasets: [{
            backgroundColor: 'rgba(241, 196, 15,1.0)',
            data: [wwtp_ng.toString(),  stp_ng.toString()],
            label: 'NG',
        }, {
           backgroundColor: 'rgba(151,187,205,5)',
            data: [wwtp_ok.toString(),  stp_ok.toString()],
            label: 'OK',
        }]
    };

    //Festronik
    var FestronikChartData = {
        labels: ['Transporter', 'Penghasil', 'Penerima'],
        datasets: [{
            backgroundColor: 'rgba(241, 196, 15,1.0)',
            data: [transporter_ng.toString(), transporter_ok.toString(), penghasil_ok.toString()],
            label: 'NG',
        }, {
           backgroundColor: 'rgba(151,187,205,5)',
            data: [transporter_ok.toString(), penghasil_ok.toString(), penerima_ok.toString()],
            label: 'OK',
        }]
    };


   //LAL WTP

    if (lal_wwt >= 68) {
      var warna = '#FF0000';
      var labelwarna = 'Emergency'; 
    } else if (lal_wwt < 68 && lal_wwt >= 44 ){
      var warna = '#FFFF00';
      var labelwarna = 'Warning'; 
    }
    else if (lal_wwt < 43 && lal_wwt >= 0 ){
      var warna = '#006400'; 
      var labelwarna = 'Normal';
    }

     if (lal_stp >= 39) {
      var warna2= '#FF0000'; 
      var labelwarna2 = 'Emergency'; 
    } else if (lal_stp < 39 && lal_stp >= 35 ){
      var warna2 = 'rgba(253,215,3,5)';
      var labelwarna2 = 'Warning';  
    }
    else if (lal_stp < 35 && lal_stp >= 0 ){
      var warna2 = '#006400'; 
      var labelwarna2 = 'Normal';  
    }

    if (lal_bs >= 11) {
      var warna3= '#FF0000'; 
      var labelwarna3 = 'Emergency'; 
    } else if (lal_bs < 11 && lal_bs >= 8 ){
      var warna3 = '#FFFF00'; 
      var labelwarna3 = 'Warning'; 
    }
    else if (lal_bs < 8 && lal_bs >= 0 ){
      var warna3 = '#006400'; 
      var labelwarna3 = 'Normal';
    }

    if (lal_et >= 4) {
      var warna4= '#FF0000'; 
      var labelwarna4 = 'Emergency'; 
    } else if (lal_et < 4 && lal_et >= 3 ){
      var warna4 = '#FFFF00'; 
      var labelwarna4 = 'Warning'; 
    }
    else if (lal_et < 3 && lal_et >= 0 ){
      var warna4 = '#006400'; 
      var labelwarna4 = 'Normal';
    }

    var asd = [];
    asd.push(lal_wwt.toString());
    asd.push(lal_stp.toString());
    asd.push(lal_bs.toString());
    asd.push(lal_et.toString());
    var asde = [];
    asde.push(warna);
    asde.push(warna2);
    asde.push(warna3);
    asde.push(warna4);
    var asdf = [];
    asdf.push(labelwarna);
    asdf.push(labelwarna2);
    asdf.push(labelwarna3);
    asdf.push(labelwarna4);


    var LalWtpChartData = {
        title : 'Level Instalasi Air Limbah',
        labels: label_lal,
        datasets: [{
            backgroundColor: asde,
            data: asd
        }]
    };


//Pemakaian Bahan Kimia
if (pembk1 > 100) {
      var w1= '#FF0000'; 
    } else{
      var w1 = '#006400'; 
    }
if (pembk2 > 350) {
      var w2= '#FF0000'; 
    } else{
      var w2 = '#006400'; 
    }
if (pembk3 > 50) {
      var w3= '#FF0000'; 
     } else{
      var w3 = '#006400'; 
     }
if (pembk4 > 0.20) {
      var w4= '#FF0000'; 
     } else{
      var w4 = '#006400'; 
     }
if (pembk5 > 8) {
      var w5= '#FF0000'; 
     } else{
      var w5 = '#006400'; 
     }
if (pembk6 > 2) {
      var w6= '#FF0000'; 
     } else{
      var w6 = '#006400'; 
     }
if (pembk7 > 2) {
      var w7= '#FF0000'; 
     } else{
      var w7 = '#006400'; 
     }
   var PembkChartData = {
        title : 'Pemakaian Bahan Kimia',
        labels: ['Ca(OH)2', 'AL2O3', 'H2SO4', 'Polimer', 'Clevpro 103', 'Bacteria Booster', 'Metal Remove'],
        datasets: [{
            backgroundColor: [w1, w2, w3, w4, w5, w6, w7 ],
            data:  [pembk1.toString(), pembk2.toString(), pembk3.toString(), pembk4.toString(), pembk5.toString(), pembk6.toString(), pembk7.toString() ],
        }]
    };
   

  //REKAPITULASI PENGANGKUTAN LIMBAH
 

  var tahunlalu = <?php $tahunrata=\Carbon\Carbon::now()->subYear(1)->format('Y'); echo $tahunrata?>;
  var contoh = {
      labels:bulan, 
      datasets: [{
         label: ['Rata-Rata '+ tahunlalu.toString()],
         data: avglalu,
         backgroundColor: "rgba(0,0,0,0)",
         borderColor:'#17a095',
         type: 'line',
         yAxesID : "y-axis-0"
      }, {
         label: 'Sludge IPAL',
         data: sipal,
         backgroundColor: '#ffa500',
         yAxesID : "y-axis-0"
      }, {
         label: 'Kemasan Bekas B3',
         data: kembekas,
         backgroundColor: '#994499',
         yAxesID : "y-axis-0"
     }, {
         label: 'Kain Majun',
         data: kainmajun,
         backgroundColor: '#316395',
         yAxesID : "y-axis-0"
    }, {
         label: 'Minyak Pelumas Bekas',
         data: plumasbekas,
         backgroundColor: '#b82e2e',
         yAxesID : "y-axis-0"
      }, {
         label: 'Sludge Painting',
         data: spainting,
         backgroundColor: '#66aa00',
         yAxesID : "y-axis-0"
    }, {
         label: 'Sludge Oil',
         data: soil,
         backgroundColor: '#dd4477',
         yAxesID : "y-axis-0"
    }, {
         label: 'Aki Bekas',
         data: akibekas,
         backgroundColor: '#0099c6',
         yAxesID : "y-axis-0"
    }, {
         label: 'Emulsi Minyak',
         data: emulsiminyak,
         backgroundColor: '#990099',
         yAxesID : "y-axis-0"
     }, {
         label: 'Bahan Kimia Kadaluarsa',
         data: bkkadaluarsa,
         backgroundColor: '#109618',
         yAxesID : "y-axis-0"
      }, {
         label: 'Limbah Klinis',
         data: lklinis,
         backgroundColor: '#dc3912',
         yAxesID : "y-axis-0"
      }, {
         label: 'Filter Bekas',
         data: fbekas,
         backgroundColor: '#3366cc',
         yAxesID : "y-axis-0"
      }, {
         label: 'Limbah Elektronik',
         data: elektronik,
         backgroundColor: '#000080',
         yAxesID : "y-axis-0"
      }, {
         label: 'Sludge Proses Pengolahan',
         data: spengolahan,
         backgroundColor: '#787878',
         yAxesID : "y-axis-0"
      }, {
         label: 'Larutan Bekas Degreasing',
         data: lbdegreasing,
         backgroundColor: '#2ecc71',
         yAxesID : "y-axis-0"
      }, {
         label: 'Kemasan Bekas Tinta',
         data: kbtinta,
         backgroundColor: '#34495e',
         yAxesID : "y-axis-0"
      }, {
         label: 'Risidu Proses Manufaktur',
         data: rmanufaktur,
         backgroundColor: '#16a085',
         yAxesID : "y-axis-0"
      }]
  };

   //GRAFIK FESTRONIK
     var sipal_tr = <?php echo $sipal_tr; ?>;
     var sipal_pk = <?php echo $sipal_pk; ?>;
     var sipal_pn = <?php echo $sipal_pn; ?>;

     var kembekas_tr = <?php echo $kembekas_tr; ?>;
     var kembekas_pk = <?php echo $kembekas_pk; ?>;
     var kembekas_pn = <?php echo $kembekas_pn; ?>;

     var kainmajun_tr = <?php echo $kainmajun_tr; ?>;
     var kainmajun_pk = <?php echo $kainmajun_pk; ?>;
     var kainmajun_pn = <?php echo $kainmajun_pn; ?>;

     var plumasbekas_tr = <?php echo $plumasbekas_tr; ?>;
     var plumasbekas_pk = <?php echo $plumasbekas_pk; ?>;
     var plumasbekas_pn = <?php echo $plumasbekas_pn; ?>;

     var spainting_tr = <?php echo $spainting_tr; ?>;
     var spainting_pk = <?php echo $spainting_pk; ?>;
     var spainting_pn = <?php echo $spainting_pn; ?>;

     var soil_tr = <?php echo $soil_tr; ?>;
     var soil_pk = <?php echo $soil_pk; ?>;
     var soil_pn = <?php echo $soil_pn; ?>;

     var akibekas_tr = <?php echo $akibekas_tr; ?>;
     var akibekas_pk = <?php echo $akibekas_pk; ?>;
     var akibekas_pn = <?php echo $akibekas_pn; ?>;

     var emulsiminyak_tr = <?php echo $emulsiminyak_tr; ?>;
     var emulsiminyak_pk = <?php echo $emulsiminyak_pk; ?>;
     var emulsiminyak_pn = <?php echo $emulsiminyak_pn; ?>;

     var bkkadaluarsa_tr = <?php echo $bkkadaluarsa_tr; ?>;
     var bkkadaluarsa_pk = <?php echo $bkkadaluarsa_pk; ?>;
     var bkkadaluarsa_pn = <?php echo $bkkadaluarsa_pn; ?>;

     var lklinis_tr = <?php echo $lklinis_tr; ?>;
     var lklinis_pk = <?php echo $lklinis_pk; ?>;
     var lklinis_pn = <?php echo $lklinis_pn; ?>;

     var fbekas_tr = <?php echo $fbekas_tr; ?>;
     var fbekas_pk = <?php echo $fbekas_pk; ?>;
     var fbekas_pn = <?php echo $fbekas_pn; ?>;

     var elektronik_tr = <?php echo $elektronik_tr; ?>;
     var elektronik_pk = <?php echo $elektronik_pk; ?>;
     var elektronik_pn = <?php echo $elektronik_pn; ?>;

     var spengolahan_tr = <?php echo $spengolahan_tr; ?>;
     var spengolahan_pk = <?php echo $spengolahan_pk; ?>;
     var spengolahan_pn = <?php echo $spengolahan_pn; ?>;

     var lbdegreasing_tr = <?php echo $lbdegreasing_tr; ?>;
     var lbdegreasing_pk = <?php echo $lbdegreasing_pk; ?>;
     var lbdegreasing_pn = <?php echo $lbdegreasing_pn; ?>;

     var kbtinta_tr = <?php echo $kbtinta_tr; ?>;
     var kbtinta_pk = <?php echo $kbtinta_pk; ?>;
     var kbtinta_pn = <?php echo $kbtinta_pn; ?>;

     var rmanufaktur_tr = <?php echo $rmanufaktur_tr; ?>;
     var rmanufaktur_pk = <?php echo $rmanufaktur_pk; ?>;
     var rmanufaktur_pn = <?php echo $rmanufaktur_pn; ?>;

     var label_limbah = <?php echo $label_limbah; ?>;
     
      var grafik_festronik2 = {
      labels: label_limbah, 
      datasets: [{
         label: 'Dibuat',
         data: [
            sipal_tr.toString(), 
            kembekas_tr.toString(), 
            kainmajun_tr.toString(), 
            plumasbekas_tr.toString(),
            spainting_tr.toString(), 
            soil_tr.toString(), 
            akibekas_tr.toString(), 
            emulsiminyak_tr.toString(),
            bkkadaluarsa_tr.toString(), 
            lklinis_tr.toString(), 
            fbekas_tr.toString(), 
            elektronik_tr.toString(),
            spengolahan_tr.toString(), 
            lbdegreasing_tr.toString(), 
            kbtinta_tr.toString(), 
            rmanufaktur_tr.toString()
            ],
          backgroundColor: '#ffa500',
         yAxesID : "y-axis-1"
      }, {
         label: 'Approval Pengirim',
         data: [
            sipal_pk.toString(), 
            kembekas_pk.toString(), 
            kainmajun_pk.toString(), 
            plumasbekas_pk.toString(),
            spainting_pk.toString(), 
            soil_pk.toString(), 
            akibekas_pk.toString(), 
            emulsiminyak_pk.toString(),
            bkkadaluarsa_pk.toString(), 
            lklinis_pk.toString(), 
            fbekas_pk.toString(), 
            elektronik_pk.toString(),
            spengolahan_pk.toString(), 
            lbdegreasing_pk.toString(), 
            kbtinta_pk.toString(), 
            rmanufaktur_pk.toString()
            ],
         backgroundColor:'#17a095',
         yAxesID : "y-axis-1"
      }, {
         label: 'Aproval Penerima',
         data: [
            sipal_pn.toString(), 
            kembekas_pn.toString(), 
            kainmajun_pn.toString(), 
            plumasbekas_pn.toString(),
            spainting_pn.toString(), 
            soil_pn.toString(), 
            akibekas_pn.toString(), 
            emulsiminyak_pn.toString(),
            bkkadaluarsa_pn.toString(), 
            lklinis_pn.toString(), 
            fbekas_pn.toString(), 
            elektronik_pn.toString(),
            spengolahan_pn.toString(), 
            lbdegreasing_pn.toString(), 
            kbtinta_pn.toString(), 
            rmanufaktur_pn.toString()
            ],
         backgroundColor: '#18a055',
         yAxesID : "y-axis-1"
      }]
  };


  

 

    window.onload = function() {
        var levelair = document.getElementById("levelair").getContext("2d");
        var pbkimia = document.getElementById("pbkimia").getContext("2d");
        var festronik = document.getElementById("festronik").getContext("2d");
        var equipment = document.getElementById("equipment").getContext("2d");
        var wwtph = document.getElementById("wwtph").getContext("2d");
        var wwtdebit = document.getElementById("wwtdebit").getContext("2d");
        var grafik_festronik = document.getElementById("grafik_festronik").getContext("2d");


  window.myBar = new Chart(grafik_festronik, {
   type: 'bar',
   data:  grafik_festronik2,
   options: {
      responsive: true,
      legend: {
         position: 'bottom' 
        },
       title : {
                display:true,
                text:'Festronik Limbah B3'
        }, 
      scales: {

         xAxes: [{
            stacked: true, 
            scaleLabel: {
                          display: true,
                          labelString: "Jenis Limbah",
                          fontColor: "black"
                        }
         }],
         yAxes: [
           {
              id:"y-axis-1", 
              scaleLabel: {
                display: false,
                labelString: "Ton",
                fontColor: "black"
              },
              stacked: true
            }
          ]
      }
   }
});


   window.myBar = new Chart(angkut, {
   type: 'bar',
   data:  contoh,
   options: {
      responsive: true,
      legend: {
         position: 'bottom' 
        },
       title : {
                display:true,
                text:'Pembuangan Limbah B3'
        }, 
      scales: {

         xAxes: [{
            stacked: true, 
            scaleLabel: {
                          display: true,
                          labelString: "Bulan",
                          fontColor: "black"
                        }
         }],
         yAxes: [
           {
              id:"y-axis-0", 
              scaleLabel: {
                display: true,
                labelString: "Ton",
                fontColor: "black"
              },
              stacked: true
            }
          ]
      }
   }
});


 window.myBar = new Chart(equipment, {
            type: 'bar',
            data: EquipmentChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                title : {
                display:true,
                text:'Equipment & Facility'
                  },       
                scales: {
                  yAxes:[{
                    barPercentage :5,
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },      
            }       
        });







       

        window.myBar = new Chart(festronik, {
            type: 'bar',
            data: FestronikChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                title : {
                display:true,
                text:'Festronik'
                  },       
                scales: {
                  yAxes:[{
                    barPercentage :5,
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },      
            }       
        });

         window.myBar = new Chart(wwtph, {
            type: 'line',
            data: WWTPHChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true, 
                  legend: {
                   position: 'bottom' 
                  },
                 title : {
                   display:true,
                   text:'pH'
                }, 
                    scales: {
                   xAxes:[{
                        scaleLabel: {
                          display: true,
                          labelString: "Tanggal",
                          fontColor: "black"
                        }
                     }],
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },              
            }       
        });


        window.myBar = new Chart(wwtdebit, {
            type: 'line',
            data: WWTDebitChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true, 
                  legend: {
                   position: 'bottom' 
                  },
                 title : {
                    display:true,
                    text:'Debit'
                  }, 
                    scales: {
                  xAxes:[{
                        scaleLabel: {
                          display: true,
                          labelString: "Tanggal",
                          fontColor: "black"
                        }
                  }],
                  yAxes:[{
                
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },              
            }       
        });



         window.myBar = new Chart(stpph, {
            type: 'line',
            data: STPPHChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true, 
                  legend: {
                   position: 'bottom' 
                  },
                 title : {
                          display:true,
                          text:'pH'
                  }, 
                    scales: {
                  xAxes:[{
                        scaleLabel: {
                          display: true,
                          labelString: "Tanggal",
                          fontColor: "black"
                        }
                  }],
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },              
            }       
        });


        window.myBar = new Chart(stpdebit, {
            type: 'line',
            data: STPDebitChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                  legend: {
                   position: 'bottom'
                  },
                 title : {
                          display:true,
                          text:'Debit'
                  },  
                    scales: {
                       xAxes:[{
                        scaleLabel: {
                          display: true,
                          labelString: "Tanggal",
                          fontColor: "black"
                        }
                  }],
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },              
            }       
        });



        window.myBar = new Chart(levelair, {
            type: 'bar',
            data: LalWtpChartData,
            options: {
              legend: {
                    display:false,
                   },
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                title : {
                display:false,
                text:'Level Instalasi Air Limbah'
                  },       
                scales: {
                  yAxes:[{
                    scaleLabel: {
                          display: true,
                          labelString: "M3",
                          fontColor: "black"
                        },
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },      
            }       
        });


        window.myBar = new Chart(pbkimia, {
            type: 'bar',
            data: PembkChartData,
            options: {
              legend: {
                    display:false,
                   },
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                title : {
                display:false,
                text:'Pemakaian Bahan Kimia'
                  },       
                scales: {
                  yAxes:[{
                    scaleLabel: {
                          display: true,
                          labelString: "Kg",
                          fontColor: "black"
                        },
                    barPercentage :5,
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },      
            }       
        });

      
    };

</script>

<script type="text/javascript">
  $(document).ready(function(){
  $("#divhide").hide();
});
</script>



@endsection
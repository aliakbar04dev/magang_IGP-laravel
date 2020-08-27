@extends('layouts.app')
<style>
  
html, body {
    height: 100%;
}
body {
    font-family: 'Source Sans Pro', sans-serif;
    color: #666;
}

table, th, td {
  border: 1px solid black;
}
/* button */
.button {
    cursor: pointer;
    text-decoration: none;
    font-size: 0.6em;
    font-weight: 400;
    text-transform: uppercase;
    display: inline-block;
    padding: 4px 6px;
    margin: 0 10px;
    position: relative;
    background: #ccc;
    color: #fff;
    box-shadow: 0 0 2px rgba(0,0,0,0.1);
    background: rgb(190,190,190); /* Old browsers */
    background: -moz-linear-gradient(top, rgba(190,190,190,1) 0%, rgba(170,170,170,1) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(190,190,190,1)), color-stop(100%,rgba(170,170,170,1))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, rgba(190,190,190,1) 0%,rgba(170,170,170,1) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, rgba(190,190,190,1) 0%,rgba(170,170,170,1) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, rgba(190,190,190,1) 0%,rgba(170,170,170,1) 100%); /* IE10+ */
    background: linear-gradient(to bottom, rgba(190,190,190,1) 0%,rgba(170,170,170,1) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bebebe', endColorstr='#aaaaaa',GradientType=0 ); /* IE6-9 */
}
.button:hover {
    background: #637b85;
}
/* Header styles */
header {
    text-align: center;
    background: #637b85;
    color: #fff;
    margin-bottom: 40px;
}
header span {
    font-weight: 200;
}
header .button {
    font-size: 0.2em;
    top: -6px;
}
 
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
    background: #fdf9f9;
    padding: 7px;
    border-width: 2px;
    border-color: #f7f8ff;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}


.chart-legend ul {
    list-style: none;
    width: 100%;
    margin: 30px auto 0;
}
.chart-legend li {
    text-indent: 16px;
    line-height: 24px;
    position: relative;
    font-weight: 200;
    display: block;
    float: left;
    width: 50%;
    font-size: 0.8em;
}
.chart-legend  li:before {
    display: block;
    width: 10px;
    height: 16px;
    position: absolute;
    left: 0;
    top: 3px;
    content: "";
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
        width: 580px;
        margin: 0 auto;
    }
    .third {
        float: left;
        width: 47.5%;
        margin-left: 5%;
        border-style: outset;
    }
    .third:first-child {
        margin-left: 0;
    }
    .third:last-child {
        display: block;
        width: 100%;
        margin-left: 0;
    }
    .second{
      float: left;
        width: 50%;
        margin-left: 5%;
    }
}
 
@media only screen and (min-width:960px){
    .container {
        width: 940px;
    }
    .third {
        border-style: outset;
        float: left;
        width: 30%;
        margin-left: 2.5%;
        margin-right: 2.5%;
    }
    .third:first-child {
        margin-left: 0;
    }
    .third:last-child {
        margin-right: 0;
        margin-left: 2.5%;
        width: 30%;
    }
     .second{
      float: left;
        width: 50%;
        margin-left: 0%;
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
@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Dashboard</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
   
 <section class="content">

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Accident Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" > 
                   <thead style="background-color:lightblue;">
                     <th style="width:25%;">DAILY</th>
                     <th style="width:25%;">IGP</th>
                     <th style="width:25%;">GKD</th>
                     <th style="width:25%;">AGI</th>
                   </thead>
                   <tbody>
                   <tr>
                     <th>Jakarta</th>
                     <td>{{$acigpj->first()->rankigpj}}</td>
                     <td>{{$acgkdj->first()->rankgkdj}}</td>
                     <td>{{$acagij->first()->rankagij}}</td>
                   </tr>
                    <tr>
                     <th>Karawang</th>
                     <td>{{$acigpk->first()->rankigpk}}</td>
                     <td>{{$acgkdk->first()->rankgkdk}}</td>
                     <td>{{$acagik->first()->rankagik}}</td>
                   </tr>
                   </tbody>
                 </table>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      

<div class="container clearfix">
                
<div class="third widget doughnut">
  
   <div class="chart-legend">
        <h4>Accident <BR>IGP Plant Jakarta</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_igpj" height="500" width="600"></canvas>
    </div>
</div>
   <div class="third widget line">
    <div class="chart-legend">
        <h4>Accident <BR>GKD Plant Jakarta</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_gkdj" height="500" width="600"></canvas>
    </div>
</div>
<div class="third widget">
    <div class="chart-legend">
        <h4>Accident <BR>AGI Plant Jakarta</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_agij" height="500" width="600"></canvas>
    </div>
</div>
</div>
<div class="container clearfix">
<div class="third widget doughnut">
 <div class="chart-legend">
        <h4>Accident <BR>IGP Plant Karawang</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_igpk" height="500" width="600"></canvas>
    </div>
</div>
   <div class="third widget line">
    <div class="chart-legend">
        <h4>Accident <BR>GKD Plant Karawang</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_gkdk" height="500" width="600"></canvas>
    </div>
</div>
<div class="third widget">
    <div class="chart-legend">
        <h4>Accident <BR>AGI Plant Karawang</h4>
        <p>Tahun {{\Carbon\Carbon::now()->format('Y')}}</p>
       <!--  <p><a href="" class="button">Track another word</a></p> -->
    </div>
    <div class="canvas-container">
        <canvas id="accident_agik" height="500" width="600"></canvas>
    </div>
</div>
</div>
<div class="push"></div>


 <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monitoring Pengolahan Limbah Cair</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                <div class="second widget">
    <div class="chart-legend">
             
                      <canvas id="levelair" style="height: 50px;width: 100px;" ></canvas>
             </div>
             </div>

                   <div class="second">
                <div class="chart-legend">
                      <canvas id="levelair2" style="height: 50px;width: 100px;" ></canvas>
                 <!--      <canvas id="speedChart" height="50" width="60" ></canvas> -->
                      
                  </div>
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

    </section>

</div>

@endsection


@section('scripts')
  <script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>

<script>


    var bulan = ['Jan','Feb','Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des'];
    var ranka_igpj = <?php echo $ranka_igpj; ?>;
    var rankb_igpj = <?php echo $rankb_igpj; ?>;
    var rankc_igpj = <?php echo $rankc_igpj; ?>;
    var ranka_gkdj = <?php echo $ranka_gkdj; ?>;
    var rankb_gkdj = <?php echo $rankb_gkdj; ?>;
    var rankc_gkdj = <?php echo $rankc_gkdj; ?>;
    var ranka_agij = <?php echo $ranka_agij; ?>;
    var rankb_agij = <?php echo $rankb_agij; ?>;
    var rankc_agij = <?php echo $rankc_agij; ?>;
    var ranka_igpk = <?php echo $ranka_igpk; ?>;
    var rankb_igpk = <?php echo $rankb_igpk; ?>;
    var rankc_igpk = <?php echo $rankc_igpk; ?>;
    var ranka_gkdk = <?php echo $ranka_gkdk; ?>;
    var rankb_gkdk = <?php echo $rankb_gkdk; ?>;
    var rankc_gkdk = <?php echo $rankc_gkdk; ?>;
    var ranka_agik = <?php echo $ranka_agik; ?>;
    var rankb_agik = <?php echo $rankb_agik; ?>;
    var rankc_agik = <?php echo $rankc_agik; ?>;

     var label_lal = <?php echo $label_lal; ?>;
    var lal_wwt = <?php echo $lal_wwt; ?>;
    var lal_stp = <?php echo $lal_stp; ?>;
    var lal_bs = <?php echo $lal_bs; ?>;
    var lal_et = <?php echo $lal_et; ?>;

    var dateE = <?php echo $dateE; ?>;

    


   //LAL WTP

    if (lal_wwt >= 68) {
      var warna = 'rgba(220,20,60,5)'; 
    } else if (lal_wwt < 68 && lal_wwt >= 44 ){
      var warna = 'rgba(253,215,3,5)'; 
    }
    else if (lal_wwt < 43 && lal_wwt >= 0 ){
      var warna = 'rgba(27,128,1,5)'; 
    }

     if (lal_stp >= 39) {
      var warna2= 'rgba(220,20,60,5)'; 
    } else if (lal_stp < 39 && lal_stp >= 35 ){
      var warna2 = 'rgba(253,215,3,5)'; 
    }
    else if (lal_stp < 35 && lal_stp >= 0 ){
      var warna2 = 'rgba(27,128,1,5)'; 
    }

    if (lal_bs >= 11) {
      var warna3= 'rgba(220,20,60,5)'; 
    } else if (lal_bs < 11 && lal_bs >= 8 ){
      var warna3 = 'rgba(253,215,3,5)'; 
    }
    else if (lal_bs < 8 && lal_bs >= 0 ){
      var warna3 = 'rgba(27,128,1,5)'; 
    }

    if (lal_et >= 4) {
      var warna4= 'rgba(220,20,60,5)'; 
    } else if (lal_et < 4 && lal_et >= 3 ){
      var warna4 = 'rgba(253,215,3,5)'; 
    }
    else if (lal_et < 3 && lal_et >= 0 ){
      var warna4 = 'rgba(27,128,1,5)'; 
    }





    var LalWtpChartData = {
        title : 'Level Instalasi Air Limbah',
        labels: label_lal,
        datasets: [{
            backgroundColor: [
            warna,
            warna2,
            warna3,
            warna4
            ],
            data: [lal_wwt, lal_stp, lal_bs, lal_et ],
        }]
    };

    //IGPJ
    var IGPJChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_igpj,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_igpj,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_igpj,
            label: 'Rank C',
        }]
    };

    //GKDJ
    var GKDJChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_gkdj,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_gkdj,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_gkdj,
            label: 'Rank C',
        }]
    };

    //AGIJ
    var AGIJChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_agij,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_agij,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_agij,
            label: 'Rank C',
        }]
    };

    //IGPK
    var IGPKChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_igpk,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_igpk,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_igpk,
            label: 'Rank C',
        }]
    };

    //GKDK
    var GKDKChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_gkdk,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_gkdk,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_gkdk,
            label: 'Rank C',
        }]
    };

    //AGIK
    var AGIKChartData = {
        labels: bulan,
        datasets: [{
            backgroundColor: "rgba(220,20,60,5)",
            data: ranka_agik,
             label: 'Rank A',
        }, {
            backgroundColor: "rgba(151,187,205,5)",
            data: rankb_agik,
            label: 'Rank B',
        },{
            backgroundColor: "rgba(218,165,32,5)",
            data: rankc_agik,
            label: 'Rank C',
        }]
    };


 

    window.onload = function() {
        var accident_igpj = document.getElementById("accident_igpj").getContext("2d");
        var accident_gkdj = document.getElementById("accident_gkdj").getContext("2d");
        var accident_agij = document.getElementById("accident_agij").getContext("2d");
        var accident_igpk = document.getElementById("accident_igpk").getContext("2d");
        var accident_gkdk = document.getElementById("accident_gkdk").getContext("2d");
        var accident_agik = document.getElementById("accident_agik").getContext("2d");
        var levelair = document.getElementById("levelair").getContext("2d");


        
        window.myBar = new Chart(levelair, {
            type: 'bar',
            data: LalWtpChartData,
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
                text:'Level Instalasi Air Limbah'
                  },       
                scales: {
                  yAxes:[{
                    barPercentage :5,
                    ticks : {
                      max :100,
                      min : 0,
                      stepSize :10,
                      beginAtZero : true
                    }
                  }]
                },      
            }       
        });

        window.myBar = new Chart(accident_igpj, {
            type: 'bar',
            data: IGPJChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true, 
                    scales: {
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },              
            }       
        });

        window.myBar = new Chart(accident_gkdj, {
            type: 'bar',
            data: GKDJChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true, 
                scales: {
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },               
            }       
        });

        window.myBar = new Chart(accident_agij, {
            type: 'bar',
            data: AGIJChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                  scales: {
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },     
            }       
        });

         window.myBar = new Chart(accident_igpk, {
            type: 'bar',
            data: IGPKChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                scales: {
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },             
            }       
        });

        window.myBar = new Chart(accident_gkdk, {
            type: 'bar',
            data: GKDKChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,    
                  scales: {
                  yAxes:[{
                    ticks : {
                      beginAtZero : true
                    }
                  }]
                },            
            }       
        });

        window.myBar = new Chart(accident_agik, {
            type: 'bar',
            data: AGIKChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 0.3,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,  
                    scales: {
                  yAxes:[{
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

 


</script>

@endsection
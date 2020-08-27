@extends('layouts.app')
@section('content')
<style type="text/css">
.canvas-container {
    min-height: 300px;
    max-height: 600px;
    position: relative;
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
 .second{
      float: center;
        width: 80%;
        margin-left: 5%;
        margin-right: 5%;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Safety Performance
        <small></small>
      </h1>
      <ol class="breadcrumb">
          <li>
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li class="active">
            <i class="glyphicon glyphicon-info-sign"></i> Safety Performance 
          </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
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
                     <td> <p> <a  data-toggle="collapse" data-target="#showigpj" >
                    <span class="servicedrop1 fa fa-eye"></span>  {{$acigpj->first()->rankigpj}} </a>
                    </p> </td>
                     <td> <p> <a  data-toggle="collapse" data-target="#showgkdj" >
                    <span class="servicedrop2 fa fa-eye"></span>  {{$acgkdj->first()->rankgkdj}}</td>
                     <td> <p> <a  data-toggle="collapse" data-target="#showagij" >
                    <span class="servicedrop3 fa fa-eye"></span>  {{$acagij->first()->rankagij}}</td>
                   </tr>
                    <tr>
                     <th>Karawang</th>
                     <td> <p> <a  data-toggle="collapse" data-target="#showigpk" >
                    <span class="servicedrop4 fa fa-eye"></span>  {{$acigpk->first()->rankigpk}}</td>
                     <td> <p> <a  data-toggle="collapse" data-target="#showgkdk" >
                    <span class="servicedrop5 fa fa-eye"></span> {{$acgkdk->first()->rankgkdk}}</td>
                     <td> <p> <a  data-toggle="collapse" data-target="#showagik" >
                    <span class="servicedrop6 fa fa-eye"></span>  {{$acagik->first()->rankagik}}</td>
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

          <div class="row collapse" id="showigpj" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Accident IGP Plant Jakarta Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                         <div class="chart-legend">
                         <canvas id="accident_igpj" class="canvas-container" ></canvas>
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




<div class="row collapse" id="showigpk" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3  class="box-title">Accident IGP Plant Karawang Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                         <div class="chart-legend">
                         <canvas id="accident_igpk" class="canvas-container" ></canvas>
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


          <div class="row collapse" id="showgkdj" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Accident GKD Plant Jakarta Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                         <div class="chart-legend">
                         <canvas id="accident_gkdj" class="canvas-container"></canvas>
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


          <div class="row collapse" id="showgkdk" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Accident GKD Plant Karawang Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                         <div class="chart-legend">
                         <canvas id="accident_gkdk" class="canvas-container"></canvas>
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


<div class="row collapse" id="showagij" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Accident AGI Plant Jakarta Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                     <div class="chart-legend">
                         <canvas id="accident_agij" class="canvas-container"></canvas>
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

<div class="row collapse" id="showagik" >
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Accident AGI Plant Karawang Tahun {{\Carbon\Carbon::now()->format('Y')}}</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="second">
                         <div class="chart-legend">
                         <canvas id="accident_agik" class="canvas-container"></canvas>
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
<script src="{{asset('js/Chart.min.js')}}"></script>
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

$('#showigpj').on('shown.bs.collapse', function() {
    $(".servicedrop1").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showigpj').on('hidden.bs.collapse', function() {
    $(".servicedrop1").addClass('fa-eye').removeClass('fa-eye-slash');
  });

$('#showgkdj').on('shown.bs.collapse', function() {
    $(".servicedrop2").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showgkdj').on('hidden.bs.collapse', function() {
    $(".servicedrop2").addClass('fa-eye').removeClass('fa-eye-slash');
  });

$('#showagij').on('shown.bs.collapse', function() {
    $(".servicedrop3").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showagij').on('hidden.bs.collapse', function() {
    $(".servicedrop3").addClass('fa-eye').removeClass('fa-eye-slash');
  });


$('#showigpk').on('shown.bs.collapse', function() {
    $(".servicedrop4").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showigpk').on('hidden.bs.collapse', function() {
    $(".servicedrop4").addClass('fa-eye').removeClass('fa-eye-slash');
  });

$('#showgkdk').on('shown.bs.collapse', function() {
    $(".servicedrop5").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showgkdk').on('hidden.bs.collapse', function() {
    $(".servicedrop5").addClass('fa-eye').removeClass('fa-eye-slash');
  });

$('#showagik').on('shown.bs.collapse', function() {
    $(".servicedrop6").addClass('fa-eye-slash').removeClass('fa-eye');
  });

$('#showagik').on('hidden.bs.collapse', function() {
    $(".servicedrop6").addClass('fa-eye').removeClass('fa-eye-slash');
  });

</script>

@endsection
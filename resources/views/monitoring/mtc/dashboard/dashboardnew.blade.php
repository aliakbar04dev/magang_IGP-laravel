@extends('monitoring.mtc.layouts.app3')
<style type="text/css">
@media only screen and (min-width: 600px ) {
    #footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 2.5rem;            /* Footer height */
}

body{
  height:500px;
}


#tblMaster{
    min-height:293px; 
    margin-left:0px;
    margin-right:0px;
    margin-bottom:0px;
    margin-top:-20px;
   }

   #tblChart{
    height:350px !important;
   }

  .chartGambar{
    height:320px !important;
   
  }
  .atasdashboard{
    width: 100%; 
    height:100px; 
    padding:0px; 
    margin-left:-50px;
  }
  /* .tampilbawah{
    margin-bottom:20%;
  } */

  .garisinfo{
    margin-left:10px;
  }

  .menu{
    font-size: 30px;
    color:white;
  }

  

  .imagelogo{
    margin-top:-10px;
    margin-left:30px;
    height:100px; 
    width:100px;
  }



  .huruf{
    font-size: 25px;
    margin-left: 20px;
  }
}

@media only screen and (max-width: 599px) {

  #footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 2.5rem;            /* Footer height */
}

body{
    height: 250px !important;
   }

   #tblChart{
    height:350px;
   }

   .chartGambar{
    height:350px !important;
   
  }

.menu{
  font-size: 14px;
  color:white;
}

.imagelogo{
    margin-top:15px;
    margin-left:30px;
    height:50px; 
    width:50px;
  }


  .huruf{
    font-size: 14px;
    margin-top:10px;
    margin-left: 20px;
  }

}
@media only screen and (min-width: 1081px) {
   body{
    height: 710px !important;
   }

   #tblMaster{
    min-height:293px; 
    margin-left:0px;
    margin-right:0px;
    margin-bottom:0px;
    margin-top:60px;
   }

   #tblChart{
    height:350px !important;
   }

  .chartGambar{
    height:320px !important;
   
  }

  }

  .atasdashboard{
    width: 100%; 
    height:100px; 
    padding:0px; 
    margin-left:-10px;
  }

  .box{
    position: relative;
  text-align: center;
  background:none;
        /* Make the width of box same as image */
}

  body {
    background-image: url("{{ asset('images/warehouse_bg.jpg') }}");
    /* background-color: #00001e !important; */
    position:relative;
  }
  
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}



  

  
</style>
@section('content')
  <div class="container4" >
    <div class="row" id="box-body" name="box-body" >
          <div class="box-body tampilbawah" >
                <div class="row">
                    <div class="col-xl-12">
                        <img src="{{ asset('images/logosmart.png') }}" class="imagelogo" align="left">
                        <br>
                            <div class="alert alert-danger alert-dismissible" style="height:40px; padding:0px 10px; background-color:#ff7701 !important;">
                                    <p class="huruf" >SMART MAINTENANCE</p>
                            </div>
                    </div>
                </div>
            <center style="margin-bottom: 20px;">
              <table id="tblMaster" width="100%">
                <tr >
                  <td style="width: 13%;text-align: center;">
                      <img src="{{ asset('images/preventive2.png') }}" style="width: 100%; border-bottom: 0 none;
                      filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="preventive">
                  </td>
                  <td style="width: 13%;text-align: center">
                    <img src="{{ asset('images/power.png') }}" style="width: 100%; margin-bottom:20px; border-bottom: 0 none;
                     filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="power">
                    <img src="{{ asset('images/daily.png') }}" style="width: 100%; border-bottom: 0 none;
                    filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="daily">
                  </td>
                  <td style="width: 13%;text-align: center">
                      <img src="{{ asset('images/oil.png') }}" style="width: 100%; border-bottom: 0 none;
                      filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="oil">
                  </td>
                  <td style="width: 13%;text-align: center">
                      <img src="{{ asset('images/forklift.png') }}" style="width: 100%; margin-bottom:20px; border-bottom: 0 none;
                      filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="forklift">
                      <img src="{{ asset('images/problem.png') }}" style="width: 100%; border-bottom: 0 none;
                      filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="problist">
                  </td>
                  <td style="width: 13%;text-align: center">
                      <img src="{{ asset('images/maintenan.png') }}" style="width: 100%; border-bottom: 0 none;
                      filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="maintenan">
                  </td>
                    <td style="width: 13%;text-align: center">
                        <img src="{{ asset('images/critical.png') }}" style="width: 100%; margin-bottom:20px; border-bottom: 0 none;
                        filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="critical">
                        <img src="{{ asset('images/search.png') }}" style="width: 100%; border-bottom: 0 none;
                        filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="search">
                      </td>
                      <td style="width: 13%;text-align: center">
                          <img src="{{ asset('images/sparepart.png') }}" style="width: 100%; border-bottom: 0 none;
                          filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));" id="sparepart">
                      </td>
                </tr>
              </table>
            </center>
            
          </div>
          {{-- <div class="navbar-fixed-bottom" style="height: 30%"> --}}
              
          {{-- </div> --}}
          <!-- ./box-body -->
          
        <!-- /.box -->
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <footer id="footer">
      <div class="row" >
          <div class="col-md-12" style="height:40px; ">
                  <div class="alert alert-danger alert-dismissible" style="height:40px; padding:0px 10px; background-color:red !important;">
                          <p class="huruf">INFORMATION MACHINE LINE STOP</p>
                  </div>
            
          </div>
        </div>
        @if($andon1s->count() == 0  && $andon2s->count() == 0 && $andon3s->count() == 0)
        <div style="background-color: #00F260; ">
          <center ><h1 style="color:white; padding-top:150px;">ALL LINE NORMAL PRODUCTION</h1></center>
        </div>
        @else
        <div style="background-color: white; margin-bottom:0px;">
          <div class="row" id="tblChart">
            <div class="col-md-12 col-sm-12" >
                      <div class="chart">
                          <center>
                              <button id="keterangan1" type="button" style="width:5px; height:5px; background-color:#FF3D67;" class="form-control  btn"
                              data-toggle="tooltip" data-placement="top" title="Close"></button>
                             Mesin &nbsp;&nbsp;
                             <button id="keterangan2" type="button" style="width:5px; height:5px; background-color:#FFC233;" class="form-control btn"
                               data-toggle="tooltip" data-placement="top" title="Close"></button> Supply  &nbsp;&nbsp;
                             <button id="keterangan3" type="button" style="width:5px; height:5px; background-color:#36A2EB;" class="form-control btn"
                               data-toggle="tooltip" data-placement="top" title="Close"></button> Quality &nbsp;&nbsp;
                               &nbsp;&nbsp;
                          </center>
                          <div class="chartGambar">
                              <canvas id="barChart1s" style="height: auto; min-height:320px;"></canvas>
                          </div>
                      </div>
              {{-- @if($andon1s->count() > 0)
                @foreach($andon1s as $key => $value) 
                    @if($value != null) 
                      @if($value->status_mc == "1" || $value->status_supply == "1" || $value->status_qc == "1" ) 
                        <div class="col-md-2 col-sm-2" align="center">
                            <div class="chart">
                            <canvas id="barChart1s{{$key}}" style="height:245px;" ></canvas>
                            </div>
                        </div>
                      @else 
                      <div class="col-md-2 col-sm-2" align="center" style="display:none;">
                          <div class="chart">
                              <canvas id="barChart1s{{$key}}" style="height:245px;" ></canvas>
                          </div>
                      </div>
                      @endif
                    @endif

                @endforeach
              @endif

              @if($andon2s->count() > 0)
                @foreach($andon2s as $key => $value) 
                    @if($value != null) 
                      @if($value->status_mc == "1" || $value->status_supply == "1" || $value->status_qc == "1" ) 
                        <div class="col-md-2 col-sm-2" align="center">
                            <div class="chart">
                            <canvas id="barChart2s{{$key}}" style="height:245px;" ></canvas>
                            </div>
                        </div>
                      @else 
                      <div class="col-md-2 col-sm-2" align="center" style="display:none;">
                          <div class="chart">
                              <canvas id="barChart2s{{$key}}" style="height:245px;" ></canvas>
                          </div>
                      </div>
                      @endif
                    @endif

                @endforeach
              @endif

              @if($andon3s->count() > 0)
                @foreach($andon3s as $key => $value) 
                    @if($value != null) 
                      @if($value->status_mc == "1" || $value->status_supply == "1" || $value->status_qc == "1" ) 
                        <div class="col-md-2 col-sm-2" align="center">
                            <div class="chart">
                            <canvas id="barChart3s{{$key}}" style="height:245px;" ></canvas>
                            </div>
                        </div>
                      @else 
                      <div class="col-md-2 col-sm-2" align="center" style="display:none;">
                          <div class="chart">
                              <canvas id="barChart3s{{$key}}" style="height:245px;" ></canvas>
                          </div>
                      </div>
                      @endif
                    @endif

                @endforeach
              @endif --}}
            </div>
          </div>

      </div>
      @endif
  </footer>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
<script type="text/javascript">

  document.title = "DASHBOARD SMART MTC";

  //auto refresh
  setTimeout(function() {
    location.reload();
  }, 60000); //1000 = 1 second

  $(document).ready(function(){

    
   
    

    var chartData1s = {
      labels: [
        @foreach($andonsjadi as $key => $value)
          @if(substr($key,0, 3) == 'red')
            @if(substr($key,0, 4) == 'red1')
            'IGP 1 - {{ join("",array_slice(str_split($key),4)) }}',
            @elseif(substr($key,0, 4) == 'red2')
            'IGP 2 - {{ join("",array_slice(str_split($key),4)) }}',
            @else
            'IGP 3 - {{ join("",array_slice(str_split($key),4)) }}',
            @endif
          @elseif(substr($key,0, 6) == 'yellow')
            @if(substr($key,0, 7) == 'yellow1')
            'IGP 1 - {{ join("",array_slice(str_split($key),7)) }}',
            @elseif(substr($key,0, 7) == 'yellow2')
            'IGP 2 - {{ join("",array_slice(str_split($key),7)) }}',
            @else
            'IGP 3 - {{ join("",array_slice(str_split($key),7)) }}',
            @endif
          @else()
            @if(substr($key,0, 5) == 'blue1')
            'IGP 1 - {{ join("",array_slice(str_split($key),5)) }}',
            @elseif(substr($key,0, 5) == 'blue2')
            'IGP 2 - {{ join("",array_slice(str_split($key),5)) }}',
            @else
            'IGP 3 - {{ join("",array_slice(str_split($key),5)) }}',
            @endif
          @endif()
            
        @endforeach
      ],
      fontSize:'36px',
      datasets: 
      [
       
        {
          type: 'bar',
          label:['Data'] ,
          backgroundColor:[
            @foreach($andonsjadi as $key => $value)
            @if(substr($key,0, 3) == 'red')
            window.chartColors.red,
            @elseif(substr($key,0, 6) == 'yellow')
            window.chartColors.yellow,
            @else()
            window.chartColors.blue,
            @endif()
            @endforeach
          ],
         
          
          data: [
            @foreach($andonsjadi as $key => $value)
            '{{ $value }}',
            @endforeach
          ],  
          borderColor: 'white',
          borderWidth: 2
        }, 
        
        
      ]
    };

   

    var ctx = document.getElementById('barChart1s').getContext('2d');
      window.myMixedChart = new Chart(ctx, {
        type: 'bar',
        data: chartData1s,
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true,
                // max: 100, 
                stepSize: 60,
                callback: function(value, index, values) {
                  // Remove the formatting to get integer data for summation
                  var intVal = function (i) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i : 0;
                  };
                  value = intVal(value);

                  var format = function formatNumber(num) {
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                  };

                  return format(value) + "'";
                }
              },
              gridLines: {
                display:true
              }
            }],
            xAxes: [{
              maxBarThickness: 120,
              ticks: {
                fontSize: 18
              },
              gridLines: {
                display:true
              }   
            }]
          },
          "hover": {
            "animationDuration": 0
          },
          "animation": {
            // "duration": 1,
            "onComplete": function() {
              var chartInstance = this.chart,
              ctx = chartInstance.ctx;

              ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
              ctx.fillStyle = 'black';
              ctx.textAlign = 'center';
              ctx.textBaseline = 'bottom';

              this.data.datasets.forEach(function(dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                meta.data.forEach(function(bar, index) {
                  var data = dataset.data[index];
                  // Remove the formatting to get integer data for summation
                  var intVal = function (i) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i : 0;
                  };
                  data = intVal(data);

                  var format = function formatNumber(num) {
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                  };

                  data = format(data);
                  ctx.fillText(data, bar._model.x, bar._model.y - 5);
                });
              });
            }
          },
          title: {
            display: true,
            position: 'top', 
            text: '',
            fontSize: 14,
          },
          legend: {
            
            position: 'bottom', 
            "display": false,
            labels: {
              // This more specific font property overrides the global property
              fontColor: 'black',
              boxWidth: 10,
              text:'halo'
              //fontSize: 12,
            }
          },
          
          tooltips: {
            mode: 'index',
            intersect: true, 
            callbacks: {
              title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0].index];
              },
              label: function(tooltipItem, data) {
                var label = tooltipItem.yLabel;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                  return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                  i : 0;
                };
                label = intVal(label);

                var format = function formatNumber(num) {
                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                };

                label = format(label);
                return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
              },
            },
          }
        }
      });

      
      
  })

  $("#preventive").on('click', function(){
    var urlRedirect = "{{ route('smartmtcs.preventive') }}";
    window.location = urlRedirect;
  });
  $("#problist").on('click', function(){
    var urlRedirect = "{{ route('smartmtcs.problist') }}";
    window.location = urlRedirect;
  });

  $("#power").on('click', function(){
    var urlRedirect = "{{ route('smartmtcs.powerutil') }}";
    window.location = urlRedirect;
  });
  $("#daily").on('click', function(){
    var urlRedirect = "{{ route('smartmtcs.dailyactivity') }}";
    window.location = urlRedirect;
  });
  $("#critical").on('click', function(){
    var urlRedirect = "{{ route('smartmtcs.indev','critical') }}";
    window.location = urlRedirect;
  });
  $("#sparepart").click(function(){
    var urlRedirect = "{{ route('smartmtcs.spm') }}?type=smartmtc";
    // window.location.href = urlRedirect;
    window.location = urlRedirect;
  });

  $("#maintenan").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var urlRedirect = "{{ route('smartmtcs.kpi', ['param','param2']) }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param2', "07217");
    urlRedirect = urlRedirect.replace('param', tahun);
    // window.location.href = urlRedirect;
    window.location = urlRedirect;
  });

  $("#oil").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var kd_site = "IGPJ";
    var urlRedirect = "{{ route('smartmtcs.resumepengisianoli', ['param','param2']) }}";
    urlRedirect = urlRedirect.replace('param2', window.btoa(tahun));
    urlRedirect = urlRedirect.replace('param', kd_site);
    // window.location.href = urlRedirect;
    window.location = urlRedirect;
  });

  $("#forklift").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
    var urlRedirect = "{{ route('smartmtcs.monitoringlch', ['param','param2']) }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param2', bulan);
    urlRedirect = urlRedirect.replace('param', tahun);
    // window.location.href = urlRedirect;
    window.location = urlRedirect;
  });

  $("#search").click(function(){
    // urlRedirect = "{{ route('tmtcwo1s.historycard') }}";
    // // window.location.href = urlRedirect;
    // window.location = urlRedirect;
    var urlRedirect = "{{ route('smartmtcs.indev','critical') }}";
    window.location = urlRedirect;
  });

  $("#btn-spm").click(function(){
    var urlRedirect = "{{ route('smartmtcs.spm') }}";
    // window.location.href = urlRedirect;
    window.open(urlRedirect, '_blank');
  });
</script>
@endsection
@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Progress Grafik
        <small>CR Progress Grafik</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - REPORT</li>
        <li class="active"><i class="fa fa-files-o"></i> CR Progress Grafik</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_filter">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">FILTER</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-2">
                  {!! Form::label('lbltahun', 'Tahun') !!}
                  <select id="filter_status_tahun" name="filter_status_tahun" aria-controls="filter_status" class="form-control select2">
                    @if(isset($tahun))
                      @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                        @if ($i == $tahun)
                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                        @else
                          <option value={{ $i }}>{{ $i }}</option>
                        @endif
                      @endfor
                    @else 
                      @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                        @if ($i == \Carbon\Carbon::now()->format('Y'))
                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                        @else
                          <option value={{ $i }}>{{ $i }}</option>
                        @endif
                      @endfor
                    @endif
                  </select>
                </div>
                <div class="col-sm-3">
                  {!! Form::label('lblbulan', 'Bulan') !!}
                  <select name="filter_status_bulan" aria-controls="filter_status" class="form-control select2">
                    @if(isset($bulan))
                      <option value="01" @if ("01" == $bulan) selected="selected" @endif>Januari</option>
                      <option value="02" @if ("02" == $bulan) selected="selected" @endif>Februari</option>
                      <option value="03" @if ("03" == $bulan) selected="selected" @endif>Maret</option>
                      <option value="04" @if ("04" == $bulan) selected="selected" @endif>April</option>
                      <option value="05" @if ("05" == $bulan) selected="selected" @endif>Mei</option>
                      <option value="06" @if ("06" == $bulan) selected="selected" @endif>Juni</option>
                      <option value="07" @if ("07" == $bulan) selected="selected" @endif>Juli</option>
                      <option value="08" @if ("08" == $bulan) selected="selected" @endif>Agustus</option>
                      <option value="09" @if ("09" == $bulan) selected="selected" @endif>September</option>
                      <option value="10" @if ("10" == $bulan) selected="selected" @endif>Oktober</option>
                      <option value="11" @if ("11" == $bulan) selected="selected" @endif>November</option>
                      <option value="12" @if ("12" == $bulan) selected="selected" @endif>Desember</option>
                    @else 
                      <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                      <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                      <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                      <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                      <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                      <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                      <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                      <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                      <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                      <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                      <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                      <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                    @endif
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername3', 'Action') !!}
                  <button id="btn-dashboard" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Dashboard">View Dashboard</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      @if (!empty($tahun) && !empty($bulan))
        <div class="row" id="field_grafik">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">ALL DIVISION YTD</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas" width="1100" height="400"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="field_grafik_detail">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik-detail">ALL DIVISION YTD</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="canvas-detail" width="1100" height="450"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
  @if (!empty($tahun) && !empty($bulan))
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
  @endif
  <script>
    //Initialize Select2 Elements
    $(".select2").select2();

    @if (!empty($tahun) && !empty($bulan))
      var nm_tahun = "{{ $nm_tahun }}";
      var nm_bulan = "{{ $nm_bulan }}";

      if(nm_tahun === "") {
        nm_tahun = "-";
      }
      if(nm_bulan === "") {
        nm_bulan = "-";
      }

      document.getElementById("box-grafik").innerHTML = "ALL DIVISION YTD Tahun: " + nm_tahun + " Bulan: " + nm_bulan;
      document.getElementById("box-grafik-detail").innerHTML = "ALL DIVISION YTD Tahun: " + nm_tahun + " Bulan: " + nm_bulan;

      // backgroundColor: [
      // 'rgba(255, 99, 132, 0.2)', //MERAH
      // 'rgba(54, 162, 235, 0.2)', //BIRU
      // 'rgba(255, 206, 86, 0.2)', //KUNING
      // 'rgba(75, 192, 192, 0.2)', //HIJAU
      // 'rgba(153, 102, 255, 0.2)', //UNGU
      // 'rgba(255, 159, 64, 0.2)' //OREN
      // ],
      // borderColor: [
      // 'rgba(255,99,132,1)',
      // 'rgba(54, 162, 235, 1)',
      // 'rgba(255, 206, 86, 1)',
      // 'rgba(75, 192, 192, 1)',
      // 'rgba(153, 102, 255, 1)',
      // 'rgba(255, 159, 64, 1)'
      // ],

      var chartData = {
        labels: ["ALL DIVISION"],
        datasets: 
        [
          {
            type: 'bar',
            label: 'Plan',
            backgroundColor: window.chartColors.red,
            data: {!! json_encode($plans) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }, 
          {
            type: 'bar',
            label: 'Actual',
            backgroundColor: window.chartColors.blue,
            data: {!! json_encode($acts) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }
        ]
      };

      var chartDataDetail = {
        labels: {!! json_encode($label_divs) !!}, 
        datasets: 
        [
          {
            type: 'bar',
            label: 'Plan',
            backgroundColor: window.chartColors.red,
            data: {!! json_encode($plan_details) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }, 
          {
            type: 'bar',
            label: 'Actual',
            backgroundColor: window.chartColors.blue,
            data: {!! json_encode($act_details) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }
        ]
      };

      window.onload = function() {
        Chart.Legend.prototype.afterFit = function() {
          this.height = this.height + 15;
        };

        var ctx = document.getElementById('canvas').getContext('2d');
        window.myMixedChart = new Chart(ctx, {
          type: 'bar',
          data: chartData,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  stepSize: 10, 
                  callback: function(value, index, values) {
                    return value + '%';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
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
                    var data = dataset.data[index] + "%";
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'CR Report',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
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
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + "%";
                },
              },
            }
          }
        });

        var ctxDetail = document.getElementById('canvas-detail').getContext('2d');
        window.myMixedChart = new Chart(ctxDetail, {
          type: 'bar',
          data: chartDataDetail,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  stepSize: 10, 
                  callback: function(value, index, values) {
                    return value + '%';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  // callback: function(t) {
                  //   var maxLabelLength = 20;
                  //   if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                  //   else return t;
                  // }, 
                  autoSkip: false,
                  maxRotation: 90,
                  minRotation: 90
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
                    var data = dataset.data[index] + "%";
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'CR Report',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
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
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + "%";
                },
              },
            }
          }
        });
      };
    @endif

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();

      var urlRedirect = "{{ route('bgttcrsubmits.indexgrafik', ['param','param2']) }}";
      urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
      window.location.href = urlRedirect;
    });

    $('#btn-dashboard').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();

      var urlRedirect = "{{ route('bgttcrsubmits.indexdashboard', ['param','param2']) }}";
      urlRedirect = urlRedirect.replace('param2', bulan);
      urlRedirect = urlRedirect.replace('param', tahun);
      // window.location.href = urlRedirect;
      window.open(urlRedirect, '_blank');
    });
  </script>
@endsection
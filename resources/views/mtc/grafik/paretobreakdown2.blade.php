@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pareto Breakdown
        <small>Pareto Breakdown</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MTC - Laporan</li>
        <li class="active">Pareto Breakdown</li>
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
                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                      @if ($i == $tahun)
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endfor
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblbulan', 'Bulan') !!}
                  <select name="filter_status_bulan" aria-controls="filter_status" class="form-control select2">
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
                    </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('filter_status_plant', 'Plant') !!}
                  <select size="1" id="filter_status_plant" name="filter_status_plant" class="form-control select2">
                    @if ($plant->get()->count() < 1)
                      <option value="-" selected="selected">Pilih Plant</option>
                    @else
                      @foreach($plant->get() as $kode)
                        @if ($kode->kd_plant == $kd_plant)
                          <option value="{{ $kode->kd_plant }}" selected="selected">{{ $kode->nm_plant }}</option>
                        @else
                          <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                        @endif
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
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
      @if (!empty($tahun) && !empty($bulan) && !empty($kd_plant))
        <div class="row" id="field_plant">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">Per-Plant</h3>
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
                <canvas id="canvas" width="1100" height="300"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row" id="field_line">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik2">Per-Plant dan Line</h3>
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
                <canvas id="canvas2" width="1100" height="400"></canvas>
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
  <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
  <script>
    //Initialize Select2 Elements
    $(".select2").select2();

    var nm_tahun = "{{ $nm_tahun }}";
    var nm_bulan = "{{ $nm_bulan }}";
    var nm_plant = "{{ $nm_plant }}";

    if(nm_tahun === "") {
      nm_tahun = "-";
    }
    if(nm_bulan === "") {
      nm_bulan = "-";
    }
    if(nm_tahun === "") {
      nm_tahun = "-";
    }

    document.getElementById("box-grafik").innerHTML = "Per-Plant Tahun: " + nm_tahun + " Bulan: " + nm_bulan + " Plant: " + nm_plant;

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
      labels: ["{{ $nm_plant }}"],
      datasets: 
      [
        {
          type: 'bar',
          label: 'Total Line Stop',
          backgroundColor: window.chartColors.red,
          data: {!! json_encode($sum_jml_ls) !!}, 
          borderColor: 'white',
          borderWidth: 2
        }
      ]
    };

    document.getElementById("box-grafik2").innerHTML = "Per-Plant dan Line Tahun: " + nm_tahun + " Bulan: " + nm_bulan + " Plant: " + nm_plant;

    var chartData2 = {
      labels: {!! json_encode($lines) !!}, 
      datasets: 
      [
        {
          type: 'bar',
          label: 'Total Line Stop',
          backgroundColor: window.chartColors.red,
          data: {!! json_encode($jml_ls_lines) !!},
          borderColor: 'white',
          borderWidth: 2

          // type: 'line',
          // label: 'Total Line Stop',
          // borderColor: window.chartColors.red,
          // borderWidth: 2,
          // fill: false, //[false, 'origin', 'start', 'end']
          {{-- // data: {!! json_encode($jml_ls_lines) !!} --}}
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
                // stepSize: 50
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

                  return format(value);
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
            text: 'Pareto Breakdown',
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

      ctx = document.getElementById('canvas2').getContext('2d');
      window.myMixedChart2 = new Chart(ctx, {
        type: 'bar',
        data: chartData2,
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true,
                // max: 100, 
                // stepSize: 20
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

                  return format(value);
                }
              },
              gridLines: {
                display:true
              }
            }],
            xAxes: [{
              ticks: {
                callback: function(t) {
                  var maxLabelLength = 20;
                  if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                  else return t;
                }, 
                autoSkip: false,
                maxRotation: 30,
                minRotation: 30
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
            text: 'Pareto Breakdown',
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
    };

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();
      var kd_plant = $('select[name="filter_status_plant"]').val();

      if(kd_plant === "-") {
        swal("Kode Plant tidak boleh kosong!", "", "warning");
      } else {
        var urlRedirect = "{{ route('tmtcwo1s.paretobreakdown', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
        urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
        window.location.href = urlRedirect;
      }
    });
  </script>
@endsection
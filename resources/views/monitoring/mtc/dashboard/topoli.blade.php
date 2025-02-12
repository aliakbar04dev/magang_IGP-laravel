@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container2">
    <div class="row" id="box-body" name="box-body">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;">
                <strong>
                  TOP 20 PEMAKAIAN OLI IGP-{{ $kd_plant }} BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }}
                </strong>
              </h3>
            </center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body form-horizontal">
            <div class="form-group">
              <div class="col-sm-2">
                {!! Form::label('filter_tahun', 'Tahun') !!}
                <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                class="form-control select2">
                  @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                    @if (isset($tahun))
                      @if ($i == $tahun)
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @else 
                      @if ($i == \Carbon\Carbon::now()->format('Y'))
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endif
                  @endfor
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('filter_bulan', 'Bulan') !!}
                <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
                class="form-control select2">
                  @if (isset($bulan))
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
              <div class="col-sm-2" style="display: none;">
                {!! Form::label('lblresume', 'Action') !!}
                <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
          <div class="row" id="field_bulan_hidrolik">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">HIDROLIK</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-bulan-hidrolik" width="1100" height="300"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row" id="field_bulan_lubrikasi">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">LUBRIKASI</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-bulan-lubrikasi" width="1100" height="300"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row" id="field_bulan_spindle">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">SPINDLE</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="canvas-bulan-spindle" width="1100" height="300"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <footer style="background-color:white; min-height:50px;" class="navbar-fixed-bottom">
      <center>
        <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button  id="onback" class="btn bg-navy">Back</a>
  </center>
    </footer>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
<script src="{{ asset('chartjs/utils.js') }}"></script>
<script type="text/javascript">
 var urlParams = new URLSearchParams(window.location.search);
        // let smartmtc = urlParams.has('type'); 
        console.log(urlParams.has('type'))
        if(urlParams.has('type')){
          var x = document.getElementById("btn-close");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
  document.getElementById("filter_tahun").focus();
  $("#onback").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var kd_site = "IGPJ";
    var urlRedirect = "{{ route('smartmtcs.resumepengisianoli', ['param','param2']) }}";
    urlRedirect = urlRedirect.replace('param2', window.btoa(tahun));
    urlRedirect = urlRedirect.replace('param', kd_site);
    // window.location.href = urlRedirect;
    window.location = urlRedirect;
  });
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $('select[name="filter_tahun"]').change(function() {
      $('#btn-display').click();
    });
    
    $('select[name="filter_bulan"]').change(function() {
      $('#btn-display').click();
    });

    $('#btn-display').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var kd_plant = "{{ $kd_plant }}";
      var urlRedirect = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3']) }}";
      urlRedirect = urlRedirect.replace('param3', kd_plant);
      urlRedirect = urlRedirect.replace('param2', bulan);
      urlRedirect = urlRedirect.replace('param', tahun);
      window.location.href = urlRedirect;
    });
  });

  var chartDataH1 = {
    labels: {!! json_encode($value_x_bulan_h) !!}, 
    datasets: 
    [
      {
        type: 'bar',
        label: 'Total',
        backgroundColor: window.chartColors.blue,
        data: {!! json_encode($value_y_bulan_h) !!}, 
        borderColor: 'white',
        borderWidth: 2
      }
    ]
  };

  var chartDataL1 = {
    labels: {!! json_encode($value_x_bulan_l) !!}, 
    datasets: 
    [
      {
        type: 'bar',
        label: 'Total',
        backgroundColor: window.chartColors.blue,
        data: {!! json_encode($value_y_bulan_l) !!}, 
        borderColor: 'white',
        borderWidth: 2
      }
    ]
  };

  var chartDataS1 = {
    labels: {!! json_encode($value_x_bulan_s) !!}, 
    datasets: 
    [
      {
        type: 'bar',
        label: 'Total',
        backgroundColor: window.chartColors.blue,
        data: {!! json_encode($value_y_bulan_s) !!}, 
        borderColor: 'white',
        borderWidth: 2
      }
    ]
  };

  window.onload = function() {
    Chart.Legend.prototype.afterFit = function() {
      this.height = this.height + 15;
    };
    
    var ctxH1 = document.getElementById('canvas-bulan-hidrolik').getContext('2d');
    window.myMixedChartH1 = new Chart(ctxH1, {
      type: 'bar',
      data: chartDataH1,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
              // max: 100, 
              // stepSize: 10, 
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

                return format(value) + ' L';
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
              // minRotation: 30
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
          text: 'TOP 20 PEMAKAIAN OLI HIDROLIK IGP-{{ $kd_plant }} BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }}',
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
          callbacks: {
            title: function(t, d) {
              return d.labels[t[0].index];
            }
          }, 
          mode: 'index',
          intersect: true, 
          callbacks: {
            title: function(tooltipItem, data) {
              return data['labels'][tooltipItem[0].index];
            },
            label: function(tooltipItem, data) {
              return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
            },
          },
        }, 
        events: ['click'], 
        onClick: function(event, element) {
          var activeElement = element[0];
          var data = activeElement._chart.data;
          var barIndex = activeElement._index;
          var datasetIndex = activeElement._datasetIndex;

          var datasetLabel = data.datasets[datasetIndex].label;
          var xLabel = data.labels[barIndex];
          var yLabel = data.datasets[datasetIndex].data[barIndex];
          // console.log(datasetLabel, xLabel, yLabel);
          var tahun = "{{ $tahun }}";
          var bulan = "{{ $bulan }}";
          var kd_plant = "{{ $kd_plant }}";
          var jns_oli = "HIDROLIK";
          var kd_mesin = xLabel;
          var url = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3','param4','param5']) }}";
          url = url.replace('param5', kd_mesin);
          url = url.replace('param4', jns_oli);
          url = url.replace('param3', kd_plant);
          url = url.replace('param2', bulan);
          url = url.replace('param', tahun);
          window.open(url, '_blank');
        }, 
      }
    });

    var ctxL1 = document.getElementById('canvas-bulan-lubrikasi').getContext('2d');
    window.myMixedChartL1 = new Chart(ctxL1, {
      type: 'bar',
      data: chartDataL1,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
              // max: 100, 
              // stepSize: 10, 
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

                return format(value) + ' L';
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
              // minRotation: 30
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
          text: 'TOP 20 PEMAKAIAN OLI LUBRIKASI IGP-{{ $kd_plant }} BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }}',
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
          callbacks: {
            title: function(t, d) {
              return d.labels[t[0].index];
            }
          }, 
          mode: 'index',
          intersect: true, 
          callbacks: {
            title: function(tooltipItem, data) {
              return data['labels'][tooltipItem[0].index];
            },
            label: function(tooltipItem, data) {
              return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
            },
          },
        }, 
        events: ['click'], 
        onClick: function(event, element) {
          var activeElement = element[0];
          var data = activeElement._chart.data;
          var barIndex = activeElement._index;
          var datasetIndex = activeElement._datasetIndex;

          var datasetLabel = data.datasets[datasetIndex].label;
          var xLabel = data.labels[barIndex];
          var yLabel = data.datasets[datasetIndex].data[barIndex];
          // console.log(datasetLabel, xLabel, yLabel);
          var tahun = "{{ $tahun }}";
          var bulan = "{{ $bulan }}";
          var kd_plant = "{{ $kd_plant }}";
          var jns_oli = "LUBRIKASI";
          var kd_mesin = xLabel;
          var url = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3','param4','param5']) }}";
          url = url.replace('param5', kd_mesin);
          url = url.replace('param4', jns_oli);
          url = url.replace('param3', kd_plant);
          url = url.replace('param2', bulan);
          url = url.replace('param', tahun);
          window.open(url, '_blank');
        }, 
      }
    });

    var ctxS1 = document.getElementById('canvas-bulan-spindle').getContext('2d');
    window.myMixedChartS1 = new Chart(ctxS1, {
      type: 'bar',
      data: chartDataS1,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
              // max: 100, 
              // stepSize: 10, 
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

                return format(value) + ' L';
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
              // minRotation: 30
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
          text: 'TOP 20 PEMAKAIAN OLI SPINDLE IGP-{{ $kd_plant }} BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }}',
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
          callbacks: {
            title: function(t, d) {
              return d.labels[t[0].index];
            }
          }, 
          mode: 'index',
          intersect: true, 
          callbacks: {
            title: function(tooltipItem, data) {
              return data['labels'][tooltipItem[0].index];
            },
            label: function(tooltipItem, data) {
              return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
            },
          },
        }, 
        events: ['click'], 
        onClick: function(event, element) {
          var activeElement = element[0];
          var data = activeElement._chart.data;
          var barIndex = activeElement._index;
          var datasetIndex = activeElement._datasetIndex;

          var datasetLabel = data.datasets[datasetIndex].label;
          var xLabel = data.labels[barIndex];
          var yLabel = data.datasets[datasetIndex].data[barIndex];
          // console.log(datasetLabel, xLabel, yLabel);
          var tahun = "{{ $tahun }}";
          var bulan = "{{ $bulan }}";
          var kd_plant = "{{ $kd_plant }}";
          var jns_oli = "SPINDLE";
          var kd_mesin = xLabel;
          var url = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3','param4','param5']) }}";
          url = url.replace('param5', kd_mesin);
          url = url.replace('param4', jns_oli);
          url = url.replace('param3', kd_plant);
          url = url.replace('param2', bulan);
          url = url.replace('param', tahun);
          window.open(url, '_blank');
        }, 
      }
    });
  };
</script>
@endsection
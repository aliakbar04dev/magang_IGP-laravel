@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container2">
    <div class="row" id="field_header">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 20px;">
                <strong>Grafik Data Performance</strong>
              </h3>
            </center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          @if (isset($label_bulans) && isset($load_times) && isset($bd_currents) && isset($bd_lasts) && isset($bd_stds))
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box-grafik">&nbsp;</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body">
                    <canvas id="canvas-2" width="1100" height="300"></canvas>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          @endif
          @if (isset($label_tgls) && isset($label_schs) && isset($stds) && isset($jmls))
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box-grafik">&nbsp;</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body">
                    <canvas id="canvas-3" width="1100" height="300"></canvas>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          @endif
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
@endsection

@if (isset($tahun) && isset($bulan) && isset($kd_plant))
  @section('scripts')
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
    <script>
      var nm_tahun = "{{ $nm_tahun }}";
      var nm_bulan = "{{ $nm_bulan }}";
      var nm_plant = "{{ $nm_plant }}";
      var nm_line = "{{ $nm_line }}";

      document.getElementById("box-title").innerHTML = "Data Performance Tahun: " + nm_tahun + ". Bulan: " + nm_bulan + ". Plant: " + nm_plant + ". Line: " + nm_line;

      @if (isset($label_bulans) && isset($load_times) && isset($bd_currents) && isset($bd_lasts) && isset($bd_stds))
        var chartData2 = {
          labels: {!! json_encode($label_bulans) !!},
          datasets: [{
            type: 'bar',
            label: 'Loading Time',
            backgroundColor: window.chartColors.gray,
            data: {!! json_encode($load_times) !!},
            borderColor: 'black',
            borderWidth: 2, 
            yAxisID: 'A'
          }, {
            type: 'line',
            label: 'BD Current (%)',
            borderColor: window.chartColors.red,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($bd_currents) !!}, 
            yAxisID: 'B'
          }, {
            type: 'line',
            label: 'BD Last (%)',
            borderColor: window.chartColors.green,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($bd_lasts) !!}, 
            yAxisID: 'B'
          }, {
            type: 'line',
            label: 'STD (%)',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($bd_stds) !!}, 
            yAxisID: 'B'
          }]
        };
      @endif

      @if (isset($label_tgls) && isset($label_schs) && isset($stds) && isset($jmls))
        var chartData3 = {
          labels: {!! json_encode($label_tgls) !!},
          datasets: [{
            type: 'line',
            label: 'STD',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($stds) !!}
          }, {
            type: 'line',
            label: 'ACT',
            borderColor: window.chartColors.red,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($jmls) !!}
          }]
        };
      @endif

      window.onload = function() {
        Chart.Legend.prototype.afterFit = function() {
          this.height = this.height + 15;
        };
        
        @if (isset($label_bulans) && isset($load_times) && isset($bd_currents) && isset($bd_lasts) && isset($bd_stds))
          var ctx = document.getElementById('canvas-2').getContext('2d');
          window.myMixedChart2 = new Chart(ctx, {
            type: 'bar',
            data: chartData2,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  id: 'A',
                  position: 'right', 
                  ticks: {
                    beginAtZero:true,
                    // max: 120, 
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
                }, {
                  id: 'B',
                  position: 'left', 
                  ticks: {
                    beginAtZero:true,
                    max: 100, 
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
                      if(i > 0) {
                        data = dataset.data[index] + "%";
                      } else {
                        data = dataset.data[index];

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
                      }
                      ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                  });
                }
              },
              title: {
                display: true,
                position: 'top', 
                text: '{{ $kd_line }} - {{ $nm_line }}',
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
                    if(tooltipItem.datasetIndex > 0) {
                      label = label + "%";
                    } else {
                      label = label;

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
                    }
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + label;
                  },
                },
              }
            }
          });
        @endif

        @if (isset($label_tgls) && isset($label_schs) && isset($stds) && isset($jmls))
          var ctx = document.getElementById('canvas-3').getContext('2d');
          window.myMixedChart3 = new Chart(ctx, {
            type: 'bar',
            data: chartData3,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true,
                    // max: 120, 
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
                text: '{{ $kd_line }} - {{ $nm_line }}',
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
        @endif
      };

      //auto refresh
      setTimeout(function() {
        // location.reload();
        var kd_plant = "{{ $kd_plant }}";
        var tahun = "{{ $tahun }}";
        var bulan = "{{ $bulan }}";
        var kd_line = "{{ $kd_line }}";
        var urlRedirect = "{{ route('smartmtcs.monitoringasakai', ['param','param2','param3','param4']) }}";
        urlRedirect = urlRedirect.replace('param4', kd_line);
        urlRedirect = urlRedirect.replace('param3', bulan);
        urlRedirect = urlRedirect.replace('param2', tahun);
        urlRedirect = urlRedirect.replace('param', kd_plant);
        window.location.href = urlRedirect;
      }, 180000); //1000 = 1 second
    </script>
  @endsection
@endif
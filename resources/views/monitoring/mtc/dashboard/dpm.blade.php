@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container2">
    <div class="row" id="field_header">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;">
                <strong>DIGITAL POWER METER MDB-{{ $mdb }} ({{ $tanggal->format('d F Y') }})</strong>
              </h1>
            </center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <!-- PMS Achievement Per-Plant -->
          <!-- Info boxes -->

          <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,300,200,100,900' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css'>

          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">Grafik V Avg</h3>
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
                  <canvas id="canvas" width="1100" height="400"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">Grafik I Avg</h3>
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
                  <canvas id="canvas-2" width="1100" height="400"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- PMS Achievement Per-Plant -->

          <!-- Ratio Breakdown vs Preventive Per-Plant -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box-grafik">Grafik Power Total</h3>
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
                  <canvas id="canvas-3" width="1100" height="400"></canvas>
                </div>
                <!-- ./box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- Ratio Breakdown vs Preventive Per-Plant -->
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
  <a href="{{ route('smartmtcs.powerutil') }}" class="btn bg-navy">Back</a>
</center>
  </footer>
@endsection

@section('scripts')
  @if (isset($value_x_1) && isset($value_y_1) && isset($value_x_2) && isset($value_y_2) && isset($value_x_3) && isset($value_y_3))
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
  @endif
  <script type="text/javascript">

    @if (isset($value_x_1) && isset($value_y_1) && isset($value_x_2) && isset($value_y_2) && isset($value_x_3) && isset($value_y_3))

      var chartData = {
        labels: {!! json_encode($value_x_1) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Jam',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_1) !!}
          }
        ]
      };

      var chartData2 = {
        labels: {!! json_encode($value_x_2) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Jam',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_2) !!}
          }
        ]
      };

      var chartData3 = {
        labels: {!! json_encode($value_x_3) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Jam',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_3) !!}
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

                    return format(value) + ' Volt';
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
                    // var data = dataset.data[index];
                    var data = "";
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'V Avg',
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
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " Volt";
                },
              },
            }
          }
        });

        ctx = document.getElementById('canvas-2').getContext('2d');
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

                    return format(value) + ' Ampere';
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
                    // var data = dataset.data[index];
                    var data = "";
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'I Avg',
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
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " Ampere";
                },
              },
            }
          }
        });

        ctx = document.getElementById('canvas-3').getContext('2d');
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

                    return format(value) + ' Kw';
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
                    // var data = dataset.data[index];
                    var data = "";
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'POWER TOTAL',
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
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " Kw";
                },
              },
            }
          }
        });
      };
    @endif
  </script>
@endsection
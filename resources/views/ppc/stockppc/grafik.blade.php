@extends('monitoring.mtc.layouts.app2')

@section('content')
  <div class="container2">
    <div class="row" id="field_header">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <div class="col-md-11">
              <center><h3 class="box-title" id="box-grafik">{{ $info }}</h3></center>
            </div>
            <div class="col-md-1" style="padding-top: 15px">
              <button id="btn-close" name="btn-close" class="btn btn-default" title="" onclick="window.close();" data-original-title="Close">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row" id="field_line">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body">
            <canvas id="canvas" width="1100" height="475"></canvas>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
  <script>
    var chartData = {
      labels: {!! json_encode($label_tgls) !!},
      datasets: [
        {
          type: 'line',
          label: '{{ $kets[0] }}',
          borderColor: window.chartColors.red,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($min_stocks) !!}
        }, {
          type: 'line',
          label: '{{ $kets[1] }}',
          borderColor: window.chartColors.blue,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($max_stocks) !!}
        }, {
          type: 'line',
          label: '{{ $kets[2] }}',
          borderColor: window.chartColors.green,
          borderWidth: 2,
          fill: false, //[false, 'origin', 'start', 'end']
          data: {!! json_encode($stock_acts) !!}
        }, {
          type: 'bar',
          label: '{{ $kets[3] }}',
          // backgroundColor: window.chartColors.purple,
          data: {!! json_encode($qty_dns) !!},
          borderColor: 'purple',
          borderWidth: 2
        }, {
          type: 'bar',
          label: '{{ $kets[4] }}',
          // backgroundColor: window.chartColors.green,
          data: {!! json_encode($qty_lpbs) !!},
          fill: false,
          borderColor: 'green',
          borderWidth: 2
        }, {
          type: 'bar',
          label: '{{ $kets[5] }}',
          // backgroundColor: window.chartColors.gray,
          data: {!! json_encode($ots_dns) !!},
          borderColor: 'orange',
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
                  // ctx.fillText(data, bar._model.x, bar._model.y - 5);
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
  </script>
@endsection
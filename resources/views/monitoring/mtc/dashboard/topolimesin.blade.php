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
                  PEMAKAIAN OLI {{ $jns_oli }} <br>{{ $nm_plant }} {{ strtoupper(namaBulan((int) $bulan)) }} {{ $tahun }} (M/C {{ $kd_mesin }})
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
          <div class="row">
            <canvas id="canvas-mesin-hari" width="1100" height="400"></canvas>
          </div>
          <!-- /.row -->
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
<script type="text/javascript">
  
  var chartData = {
    labels: {!! json_encode($value_x_hari) !!}, 
    datasets: 
    [
      {
        type: 'line',
        label: 'Total',
        borderColor: window.chartColors.blue,
        borderWidth: 2,
        fill: false, //[false, 'origin', 'start', 'end']
        data: {!! json_encode($value_y_hari) !!}
      }
    ]
  };

  window.onload = function() {
    Chart.Legend.prototype.afterFit = function() {
      this.height = this.height + 15;
    };
    
    var ctx = document.getElementById('canvas-mesin-hari').getContext('2d');
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
          text: 'PEMAKAIAN OLI {{ $jns_oli }} {{ $nm_plant }} - {{ strtoupper(namaBulan((int) $bulan)) }} {{ $tahun }} (M/C {{ $kd_mesin }})',
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
        }
      }
    });
  };
</script>
@endsection
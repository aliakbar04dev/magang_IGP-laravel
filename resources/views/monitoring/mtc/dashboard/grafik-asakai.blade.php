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
          @if (isset($tahun) && isset($bulan) && isset($kd_plant))
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
                    <canvas id="canvas" width="1100" height="400"></canvas>
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
      @if (isset($lines) && isset($prs_bds))
        var nm_tahun = "{{ $nm_tahun }}";
        var nm_bulan = "{{ $nm_bulan }}";
        var nm_plant = "{{ $nm_plant }}";
        var label_br = '{!! $label_br !!}';

        document.getElementById("box-title").innerHTML = "Data Performance Tahun: " + nm_tahun + ". Bulan: " + nm_bulan + ". Plant: " + nm_plant + "" + label_br;

        var chartData = {
          labels: {!! json_encode($lines) !!}, 
          datasets: 
          [
            {
              type: 'line',
              label: 'Target (%)',
              borderColor: window.chartColors.green,
              borderWidth: 2,
              fill: false, //[false, 'origin', 'start', 'end']
              data: {!! json_encode($prs_targets) !!}
            }, 
            {
              type: 'bar',
              label: 'Breakdown Rate (%)',
              backgroundColor: window.chartColors.red,
              data: {!! json_encode($prs_bds) !!},
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
                      var data = dataset.data[index] + "%";
                      ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                  });
                }
              },
              title: {
                display: true,
                position: 'top', 
                text: 'Breakdown Rate',
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
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + "%";
                  },
                },
              }, 
              events: ['click'], 
              onClick: function(event, element) {
                var activeElement = element[0];
                if(activeElement != null) {
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
                  var kd_line = xLabel;
                  kd_line = kd_line.toString().split("-")[0];
                  
                  var urlRedirect = "{{ route('smartmtcs.monitoringasakai', ['param','param2','param3','param4']) }}";
                  urlRedirect = urlRedirect.replace('param4', kd_line);
                  urlRedirect = urlRedirect.replace('param3', bulan);
                  urlRedirect = urlRedirect.replace('param2', tahun);
                  urlRedirect = urlRedirect.replace('param', kd_plant);
                  window.open(urlRedirect, '_blank');
                }
              }, 
            }
          });
        };
      @endif

      //auto refresh
      setTimeout(function() {
        // location.reload();
        {{-- // var kd_plant = "{{ $kd_plant }}"; --}}
        {{-- // var urlRedirect = "{{ url('/monitoringasakai/param') }}"; --}}
        // urlRedirect = urlRedirect.replace('param', kd_plant);
        // window.location.href = urlRedirect;
        
        var kd_site = "IGPJ";
        var urlRedirect = "{{ route('smartmtcs.monitoringmtc', 'param') }}";
        urlRedirect = urlRedirect.replace('param', kd_site);
        window.location.href = urlRedirect;
      }, 180000); //1000 = 1 second
    </script>
  @endsection
@endif
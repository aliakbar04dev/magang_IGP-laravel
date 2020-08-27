@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container2">
    <div class="row" id="field_header">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;">
                @if($kd_site === "IGPK") 
                  <strong>MTC KARAWANG PERFORMANCE</strong>
                @else 
                  <strong>MTC JAKARTA PERFORMANCE</strong>
                @endif
              </h3>
            </center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          @if (isset($kd_plant_pmsachievement))
            <!-- PMS Achievement Per-Plant -->
            <!-- Info boxes -->
            <div class="row">
              <div class="col-md-6">
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
                    <canvas id="canvas-pmsachievement" width="1100" height="480"></canvas>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
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
                    <canvas id="canvas-paretobreakdown" width="1100" height="480"></canvas>
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
                    <canvas id="canvas-ratiobreakdownpreventive" width="1100" height="300"></canvas>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Ratio Breakdown vs Preventive Per-Plant -->
          @endif
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
@endsection

@if (isset($kd_plant_pmsachievement))
  @section('scripts')
    <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('chartjs/utils.js') }}"></script>
    <script>
      var chartDataPmsAchievement = {
        labels: {!! json_encode($kd_plant_pmsachievement) !!}, 
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

      var chartDataParetoBreakdown = {
        labels: {!! json_encode($kd_plant_paretobreakdown) !!}, 
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

      var chartDataRatioBreakdownPreventive = {
        labels: {!! json_encode($kd_plant_ratiobreakdownpreventive) !!}, 
        datasets: 
        [
          {
            type: 'bar',
            label: 'Line Stop',
            backgroundColor: window.chartColors.red,
            data: {!! json_encode($sum_jml_ls) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }, 
          {
            type: 'bar',
            label: 'PMS',
            backgroundColor: window.chartColors.blue,
            data: {!! json_encode($sum_jml_pms) !!}, 
            borderColor: 'white',
            borderWidth: 2
          }
        ]
      };

      window.onload = function() {
        Chart.Legend.prototype.afterFit = function() {
          this.height = this.height + 15;
        };
        
        var ctx_pmsachievement = document.getElementById('canvas-pmsachievement').getContext('2d');
        window.myMixedChart_pmsachievement = new Chart(ctx_pmsachievement, {
          type: 'bar',
          data: chartDataPmsAchievement,
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
              text: '{{ $title1 }}',
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

        var ctx_paretobreakdown = document.getElementById('canvas-paretobreakdown').getContext('2d');
        window.myMixedChart_paretobreakdown = new Chart(ctx_paretobreakdown, {
          type: 'bar',
          data: chartDataParetoBreakdown,
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
              text: '{{ $title2 }}',
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

        var ctx_ratiobreakdownpreventive = document.getElementById('canvas-ratiobreakdownpreventive').getContext('2d');
        window.myMixedChart_ratiobreakdownpreventive = new Chart(ctx_ratiobreakdownpreventive, {
          type: 'bar',
          data: chartDataRatioBreakdownPreventive,
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
              text: '{{ $title3 }}',
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

      //auto refresh
      setTimeout(function() {
        // location.reload();
        {{-- // var kd_site = "{{ $kd_site }}"; --}}
        {{-- // var urlRedirect = "{{ url('/monitoringmtc/param') }}"; --}}
        // urlRedirect = urlRedirect.replace('param', kd_site);
        // window.location.href = urlRedirect;

        var kd_plant = "2";
        var urlRedirect = "{{ route('smartmtcs.monitoringasakai', 'param') }}";
        urlRedirect = urlRedirect.replace('param', kd_plant);
        window.location.href = urlRedirect;

      }, 180000); //1000 = 1 second
    </script>
  @endsection
@endif
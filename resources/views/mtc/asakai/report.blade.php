@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Performance
        <small>Laporan Data Performance Maintenance</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> Data Performance</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_filter">
        <div class="col-md-12">
          <div class="box box-primary">
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
                <div class="col-sm-2">
                  {!! Form::label('kd_plant', 'Plant') !!}
                  <select size="1" id="kd_plant" name="kd_plant" class="form-control select2">
                    @if (isset($kd_plant))
                      <option value="ALL">Pilih Plant</option>
                      @foreach($plant->get() as $kode)
                        <option value="{{ $kode->kd_plant }}" @if ($kode->kd_plant == $kd_plant) selected="selected" @endif>{{ $kode->nm_plant }}</option>
                      @endforeach
                    @else 
                      <option value="ALL" selected="selected">Pilih Plant</option>
                      @foreach($plant->get() as $kode)
                        <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
            @if (isset($mtctasakais))
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <caption style="display: table-caption;"><strong>Tahun: {{ $nm_tahun }}, Bulan: {{ $nm_bulan }}, Plant: {{ $nm_plant }}</strong></center></caption>
                  <thead>
                    <tr>
                      <th style="text-align: center;width: 1%;">No</th>
                      <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Line</th>
                      <th style="text-align: center;width: 5%;">Target (%)</th>
                      <th style="text-align: center;width: 5%;">Availability Mesin (%)</th>
                      <th style="text-align: center;width: 5%;">Breakdown Rate (%)</th>
                      <th style="text-align: center;width: 5%;">MTTR</th>
                      <th style="text-align: center;width: 5%;">MTBF</th>
                      <th style="text-align: center;width: 5%;">Operating Time</th>
                      <th style="text-align: center;width: 5%;">Loading Time (Menit)</th>
                      <th style="text-align: center;width: 5%;">Freq. Kejadian Line Stop</th>
                      <th style="text-align: center;width: 5%;">Waktu Line Stop (Menit)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mtctasakais->get() as $data)
                      <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="white-space: nowrap;max-width: 400px;overflow: auto;text-overflow: clip;">
                          {{ $data->kd_line }} - {{ $data->nm_line }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->prs_target) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->prs_avail_mesin) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->prs_bd_rate) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->nil_mttr) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->nil_mtbf) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->nil_opr_time) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->load_time) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->ls_freq) }}
                        </td>
                        <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                          {{ numberFormatter(0, 2)->format($data->ls_time) }}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            @endif
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      @if (!empty($tahun) && !empty($bulan) && !empty($kd_plant))
        <div class="row" id="field_line">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" id="box-grafik">Grafik Data Performance</h3>
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
              @if (isset($label_bulans) && isset($load_times) && isset($bd_currents) && isset($bd_lasts) && isset($bd_stds))
                <div class="box-body">
                  <canvas id="canvas-2" width="1100" height="600"></canvas>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <table id="tbl1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="text-align: center;"></th>
                        @foreach($label_bulans as $label_bulan)
                          <th style="text-align: center;width: 5%;">{{ $label_bulan }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>Loading Time</td>
                          @foreach($label_bulans as $label_bulan)
                            <td style="text-align: right;">{{ numberFormatter(0, 2)->format($load_times[$loop->iteration - 1]) }}</td>
                          @endforeach
                        </tr>
                        <tr>
                          <td>BD Current (%)</td>
                          @foreach($label_bulans as $label_bulan)
                            <td style="text-align: right;">{{ numberFormatter(0, 2)->format($bd_currents[$loop->iteration - 1]) }}%</td>
                          @endforeach
                        </tr>
                        <tr>
                          <td>BD Last (%)</td>
                          @foreach($label_bulans as $label_bulan)
                            <td style="text-align: right;">{{ numberFormatter(0, 2)->format($bd_lasts[$loop->iteration - 1]) }}%</td>
                          @endforeach
                        </tr>
                        <tr>
                          <td>STD (%)</td>
                          @foreach($label_bulans as $label_bulan)
                            <td style="text-align: right;">{{ numberFormatter(0, 2)->format($bd_stds[$loop->iteration - 1]) }}%</td>
                          @endforeach
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              @endif

              @if (isset($label_tgls) && isset($label_schs) && isset($stds) && isset($jmls))
                <div class="box-body">
                  <canvas id="canvas-3" width="1100" height="400"></canvas>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                  <table id="tbl2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        @foreach($label_tgls as $label_tgl)
                          <th style="text-align: center;">{{ $label_tgl }}</th>
                        @endforeach
                      </tr>
                      <tr>
                        @foreach($label_schs as $label_sch)
                          <th style="text-align: center;">{{ $label_sch }}</th>
                        @endforeach
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.box-body -->
              @endif
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
@if (isset($lines) && isset($prs_bds))
  <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
@endif
<script type="text/javascript">
  document.getElementById("filter_tahun").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){

    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      // 'searching': false,
      "scrollX": true,
      "scrollY": "400px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#btn-display').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var kd_plant = document.getElementById('kd_plant').value.trim();
      if(kd_plant !== "ALL") {
        var urlRedirect = "{{ route('mtctasakais.laporanasakai', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
        urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
        window.location.href = urlRedirect;
      } else {
        if(kd_plant === "ALL") {
          document.getElementById("kd_plant").focus();
        }
        swal("Plant tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
      }
    });
  });

  @if (isset($lines) && isset($prs_bds))
    var nm_tahun = "{{ $nm_tahun }}";
    var nm_bulan = "{{ $nm_bulan }}";
    var nm_plant = "{{ $nm_plant }}";
    var label_br = '{!! $label_br !!}';

    document.getElementById("box-grafik").innerHTML = "Tahun: " + nm_tahun + " Bulan: " + nm_bulan + " Plant: " + nm_plant + "" + label_br;

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
        }, {
          type: 'bar',
          label: 'Breakdown Rate (%)',
          backgroundColor: window.chartColors.red,
          data: {!! json_encode($prs_bds) !!},
          borderColor: 'white',
          borderWidth: 2
        }
      ]
    };

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
              
              var urlRedirect = "{{ route('mtctasakais.laporanasakai', ['param','param2','param3','param4']) }}";
              urlRedirect = urlRedirect.replace('param4', window.btoa(kd_line));
              urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
              urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
              urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
              window.location.href = urlRedirect;
            }
          }, 
        }
      });

      @if (isset($label_bulans) && isset($load_times) && isset($bd_currents) && isset($bd_lasts) && isset($bd_stds))
        ctx = document.getElementById('canvas-2').getContext('2d');
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
  @endif
</script>
@endsection
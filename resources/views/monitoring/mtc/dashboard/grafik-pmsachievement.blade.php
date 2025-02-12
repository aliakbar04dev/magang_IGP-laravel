@extends('monitoring.mtc.layouts.app3')
<style type="text/css">
  #field_data { 
    height: 100%; 
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>
@section('content')
  <div class="container2">
    <div class="row" id="box-body" name="box-body">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border" id="box-overflow-1">
            <center><h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;"><strong>PMS ACHIEVEMENT IGP-{{ $kd_plant }} ZONA {{ $lok_zona }}</strong></h3></center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body form-horizontal" id="box-overflow-2">
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
              <div class="col-sm-2" style="display: none;">
                {!! Form::label('lblusername2', 'Action') !!}
                <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            </div>
            <!-- /.form-group -->
          </div>

          <div class="box-body" id="field_data">
            <div class="row" id="field_tahun" name="field_tahun">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box-grafik-tahun">Per-Plant</h3>
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
                    <canvas id="canvas-tahun" width="1100" height="300"></canvas>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.box-body -->
            <div class="row" id="field_plant" name="field_plant">
              <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box-grafik">Per-Plant</h3>
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
                    <canvas id="canvas" width="1100" height="600"></canvas>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box-grafik2">Per-Plant dan Line</h3>
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
                    <canvas id="canvas2" width="1100" height="600"></canvas>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      <p><label id="info-detail">PMS Outstanding</label></p>
                    </h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width: 1%;">No</th>
                          <th style="width: 15%;">Mesin</th>
                          <th>Item Pengerjaan</th>
                          <th style="width: 10%;">Tanggal</th>
                          <th style="width: 15%;">No. LP</th>
                          <th style="width: 15%;">No. DM</th>
                          <th>No. PMS</th>
                          <th>No. MS</th>
                          <th>Plant</th>
                          <th>Zona</th>
                          <th>Periode</th>
                          <th>PIC Tarik</th>
                          <th>PIC Pending</th>
                          <th>Ket. Pending</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      <p><label id="info-detail2">PMS Today</label></p>
                    </h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="tblCurrent" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th style="width: 1%;">No</th>
                          <th style="width: 15%;">Mesin</th>
                          <th>Item Pengerjaan</th>
                          <th style="width: 10%;">Tanggal</th>
                          <th style="width: 15%;">No. LP</th>
                          <th style="width: 15%;">No. DM</th>
                          <th>No. PMS</th>
                          <th>No. MS</th>
                          <th>Plant</th>
                          <th>Zona</th>
                          <th>Periode</th>
                          <th>PIC Tarik</th>
                          <th>PIC Pending</th>
                          <th>Ket. Pending</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
          </div>
          <!-- /.field_data -->
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
  <a href="{{ route('smartmtcs.preventive') }}" class="btn bg-navy">Back</a>
</center>
  </footer>
@endsection

@section('scripts')
  <script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
  <script>
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
    
    //Initialize Select2 Elements
    $(".select2").select2();

    var calcDataTableHeight = function() {
      return $(window).height() * 45 / 100;
    };

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

    var tahun = "{{ $tahun }}";
    var bulan = "{{ $bulan }}";
    var today = "{{ \Carbon\Carbon::now()->format('d F Y') }}";
    var periode_pilih = tahun + "" + bulan;
    var periode_now = "{{ \Carbon\Carbon::now()->format('Ym') }}";
    var tanggal_pilih;
    var label_outstanding = "PMS Outstanding";
    if(periode_pilih == periode_now) {
      tanggal_pilih = periode_pilih + "{{ \Carbon\Carbon::now()->format('d') }}";
    } else if(periode_pilih > periode_now) {
      tanggal_pilih = periode_pilih + "01";
    } else {
      tanggal_pilih = periode_pilih + "32";
      label_outstanding = "PMS Outstanding (Tahun: " + nm_tahun + " Bulan: " + nm_bulan + ")";
    }

    var urlMaster = '{{ route('smartmtcs.dashboardmtctpms', ['param', 'param2', 'param3', 'param4', 'param5']) }}';
    urlMaster = urlMaster.replace('param5', window.btoa(periode_pilih));
    urlMaster = urlMaster.replace('param4', window.btoa(tanggal_pilih));
    urlMaster = urlMaster.replace('param3', window.btoa("{{ $lok_zona }}"));
    urlMaster = urlMaster.replace('param2', window.btoa("{{ $kd_plant }}"));
    urlMaster = urlMaster.replace('param', window.btoa("OUTSTANDING"));
    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": -1,
      responsive: true, 
      "scrollY": calcDataTableHeight(),
      "scrollCollapse": true,
      "order": [[10, 'asc'],[1, 'asc'],[7, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      "dom": '<"top"fli>rt<"clear">', 
      serverSide: true,
      ajax: urlMaster, 
      columns: [
        {data: null, name: null},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'nm_ic', name: 'nm_ic'},
        {data: 'nm_tgl', name: 'nm_tgl', className: "dt-center"},
        {data: 'no_lp', name: 'no_lp'},
        {data: 'no_dm', name: 'no_dm'},
        {data: 'no_pms', name: 'no_pms', className: "none"},
        {data: 'no_ms', name: 'no_ms', className: "none"},
        {data: 'kd_plant', name: 'kd_plant', className: "none"},
        {data: 'lok_zona', name: 'lok_zona', className: "none"},
        {data: 'periode', name: 'periode', className: "none"},
        {data: 'pic_tarik', name: 'pic_tarik', className: "none"},
        {data: 'pending_pic', name: 'pending_pic', className: "none"},
        {data: 'pending_ket', name: 'pending_ket', className: "none"}
      ], 
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });

    var urlCurrent = '{{ route('smartmtcs.dashboardmtctpms', ['param', 'param2', 'param3']) }}';
    urlCurrent = urlCurrent.replace('param3', window.btoa("{{ $lok_zona }}"));
    urlCurrent = urlCurrent.replace('param2', window.btoa("{{ $kd_plant }}"));
    urlCurrent = urlCurrent.replace('param', window.btoa("CURRENT"));
    var tableCurrent = $('#tblCurrent').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": -1,
      responsive: true, 
      "scrollY": calcDataTableHeight(),
      "scrollCollapse": true,
      "order": [[10, 'asc'],[1, 'asc'],[7, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      "dom": '<"top"fli>rt<"clear">', 
      serverSide: true,
      ajax: urlCurrent, 
      columns: [
        {data: null, name: null},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'nm_ic', name: 'nm_ic'},
        {data: 'nm_tgl', name: 'nm_tgl', className: "dt-center"},
        {data: 'no_lp', name: 'no_lp'},
        {data: 'no_dm', name: 'no_dm'},
        {data: 'no_pms', name: 'no_pms', className: "none"},
        {data: 'no_ms', name: 'no_ms', className: "none"},
        {data: 'kd_plant', name: 'kd_plant', className: "none"},
        {data: 'lok_zona', name: 'lok_zona', className: "none"},
        {data: 'periode', name: 'periode', className: "none"},
        {data: 'pic_tarik', name: 'pic_tarik', className: "none"},
        {data: 'pending_pic', name: 'pending_pic', className: "none"},
        {data: 'pending_ket', name: 'pending_ket', className: "none"}
      ], 
    });

    $('#tblCurrent tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      } else {
        tableCurrent.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });

    document.getElementById("info-detail").innerHTML = label_outstanding;
    document.getElementById("info-detail2").innerHTML = "PMS Today (" + today + ")";
    document.getElementById("box-grafik-tahun").innerHTML = "Tahun: " + nm_tahun;
    document.getElementById("box-grafik").innerHTML = "Tahun: " + nm_tahun + " Bulan: " + nm_bulan;

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

    var chartDataTahun = {
      labels: {!! json_encode($value_bulan) !!}, 
      datasets: 
      [
        {
          type: 'bar',
          label: 'Plan',
          backgroundColor: window.chartColors.red,
          data: {!! json_encode($value_y_plan) !!}, 
          borderColor: 'white',
          borderWidth: 2
        }, 
        {
          type: 'bar',
          label: 'Actual',
          backgroundColor: window.chartColors.blue,
          data: {!! json_encode($value_y_act) !!}, 
          borderColor: 'white',
          borderWidth: 2
        }
      ]
    };

    var chartData = {
      labels: ["{{ $nm_plant }}"],
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

    document.getElementById("box-grafik2").innerHTML = "Tahun: " + nm_tahun + " Bulan: " + nm_bulan;

    var chartData2 = {
      labels: {!! json_encode($lines) !!}, 
      datasets: 
      [
        {
          type: 'bar',
          label: 'Plan',
          backgroundColor: window.chartColors.red, //"rgba(255, 99, 132, 0.2)",
          data: {!! json_encode($plan_lines) !!}, 
          borderColor: 'white', //'rgba(255, 99, 132, 0.2)',
          borderWidth: 2
        }, 
        {
          // type: 'line',
          // label: 'Actual',
          // borderColor: window.chartColors.blue,
          // borderWidth: 2,
          // fill: false, //[false, 'origin', 'start', 'end']
          {{-- // data: {!! json_encode($act_lines) !!} --}}

          type: 'bar',
          label: 'Actual',
          backgroundColor: window.chartColors.blue,
          data: {!! json_encode($act_lines) !!},
          borderColor: 'white',
          borderWidth: 2
        }
      ]
    };

    window.onload = function() {
      Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 15;
      };
      
      var ctxTahun = document.getElementById('canvas-tahun').getContext('2d');
      window.myMixedChartTahun = new Chart(ctxTahun, {
        type: 'bar',
        data: chartDataTahun,
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
            text: 'PMS Achievement IGP-{{ $kd_plant }} ZONA {{ $lok_zona }}',
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
            text: 'PMS Achievement',
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
            text: 'PMS Achievement',
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

    $('select[name="filter_status_tahun"]').change(function() {
      $('#display').click();
    });
    $('select[name="filter_status_bulan"]').change(function() {
      $('#display').click();
    });

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();
      var kd_plant = "{{ $kd_plant }}";
      var lok_zona = "{{ $lok_zona }}";

      if(kd_plant === "-") {
        swal("Kode Plant tidak boleh kosong!", "", "warning");
      } else {
        var urlRedirect = "{{ route('smartmtcs.pmsachievement', ['param','param2','param3','param4']) }}";
        urlRedirect = urlRedirect.replace('param4', lok_zona);
        urlRedirect = urlRedirect.replace('param3', kd_plant);
        urlRedirect = urlRedirect.replace('param2', bulan);
        urlRedirect = urlRedirect.replace('param', tahun);
        window.location.href = urlRedirect;
      }
    });
  </script>
@endsection
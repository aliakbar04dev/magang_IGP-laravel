@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quality Performance
        <small>Quality Performance / QPR Status</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-exchange"></i> Quality Performance</li>
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
                      @if (empty($tahun))
                        @if ($i == \Carbon\Carbon::now()->format('Y'))
                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                        @else
                          <option value={{ $i }}>{{ $i }}</option>
                        @endif
                      @else
                        @if ($i == $tahun)
                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                        @else
                          <option value={{ $i }}>{{ $i }}</option>
                        @endif
                      @endif
                    @endfor
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblbulan', 'Bulan') !!}
                  <select id="filter_status_bulan" name="filter_status_bulan" aria-controls="filter_status" class="form-control select2">
                    @if (empty($bulan))
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
                    @else
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
                    @endif
                  </select>
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <div class="col-sm-4">
                  {!! Form::label('lblsupplier', 'Supplier') !!}
                  <select id="filter_status_supplier" name="filter_status_supplier" aria-controls="filter_status" class="form-control select2">
                    @if (empty($kd_supp))
                      @if (strlen(Auth::user()->username) <= 5)
                        <option value="-">-</option>
                      @endif
                    @endif
                    @foreach ($suppliers->get() as $supplier)
                      @if (empty($kd_supp))
                        <option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                      @else
                        @if ($supplier->kd_supp == $kd_supp)
                          <option value={{ $supplier->kd_supp }} selected="selected">{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                        @else
                          <option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                        @endif
                      @endif
                    @endforeach
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
      <div class="row" id="field_cr">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box-grafik">CLAIM RATIO</h3>
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
            <div class="box-body">
              <table id="tbl1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center;">SUBJECT</th>
                    <th rowspan="2" style="text-align: center;width: 8%;" id="th-thnlalu">TAHUN-1</th>
                    <th colspan="12" style="text-align: center;" id="th-thn">TAHUN</th>
                    <th rowspan="2" style="text-align: center;width: 8%;">TOTAL</th>
                  </tr>
                  <tr>
                    <th style="text-align: center;width: 6%;">JAN</th>
                    <th style="text-align: center;width: 6%;">PEB</th>
                    <th style="text-align: center;width: 6%;">MAR</th>
                    <th style="text-align: center;width: 6%;">APR</th>
                    <th style="text-align: center;width: 6%;">MAY</th>
                    <th style="text-align: center;width: 6%;">JUN</th>
                    <th style="text-align: center;width: 6%;">JUL</th>
                    <th style="text-align: center;width: 6%;">AUG</th>
                    <th style="text-align: center;width: 6%;">SEPT</th>
                    <th style="text-align: center;width: 6%;">OCT</th>
                    <th style="text-align: center;width: 6%;">NOV</th>
                    <th style="text-align: center;width: 6%;">DEC</th>
                  </tr>
                </thead>
                @if (!empty($claim_rekaps1))
                  <tbody>
                    @foreach ($claim_rekaps1 as $key => $value)
                      <tr>
                        <td>{{ $value['subject'] }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['tahun_lalu']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jan']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['feb']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mar']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['apr']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mei']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jun']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jul']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['aug']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['sept']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['oct']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['nov']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['des']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['total']) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                @endif
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row" id="field_cs">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box-grafik-2">QPR STATUS</h3>
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
              <canvas id="canvas-2" width="1100" height="300"></canvas>
            </div>
            <!-- /.box-body -->
            <div class="box-body">
              <table id="tbl2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center;">SUBJECT</th>
                    <th rowspan="2" style="text-align: center;width: 8%;" id="th-thnlalu-2">TAHUN-1</th>
                    <th colspan="12" style="text-align: center;" id="th-thn-2">TAHUN</th>
                    <th rowspan="2" style="text-align: center;width: 8%;">TOTAL</th>
                  </tr>
                  <tr>
                    <th style="text-align: center;width: 6%;">JAN</th>
                    <th style="text-align: center;width: 6%;">PEB</th>
                    <th style="text-align: center;width: 6%;">MAR</th>
                    <th style="text-align: center;width: 6%;">APR</th>
                    <th style="text-align: center;width: 6%;">MAY</th>
                    <th style="text-align: center;width: 6%;">JUN</th>
                    <th style="text-align: center;width: 6%;">JUL</th>
                    <th style="text-align: center;width: 6%;">AUG</th>
                    <th style="text-align: center;width: 6%;">SEPT</th>
                    <th style="text-align: center;width: 6%;">OCT</th>
                    <th style="text-align: center;width: 6%;">NOV</th>
                    <th style="text-align: center;width: 6%;">DEC</th>
                  </tr>
                </thead>
                @if (!empty($claim_rekaps2))
                  <tbody>
                    @foreach ($claim_rekaps2 as $key => $value)
                      <tr>
                        <td>{{ $value['subject'] }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['tahun_lalu']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jan']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['feb']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mar']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['apr']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['mei']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jun']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['jul']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['aug']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['sept']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['oct']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['nov']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['des']) }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($value['total']) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                @endif
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row" id="field_mutasi2">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box-grafik-mutasi2">&nbsp;</h3>
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
              <table id="tbl3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="text-align: center;width: 1%;">NO</th>
                    <th style="text-align: center;width: 15%;">QPR</th>
                    <th style="text-align: center;width: 10%;">PART NO</th>
                    <th style="text-align: center;width: 15%;">PART NAME</th>
                    <th style="text-align: center;width: 5%;">QTY</th>
                    <th style="text-align: center;">PROBLEM</th>
                    <th style="text-align: center;width: 5%;">RESPONSE</th>
                    <th style="text-align: center;width: 5%;">STATUS</th>
                    <th style="text-align: center;width: 10%;">MODEL</th>
                  </tr>
                </thead>
                @if (!empty($mutasi2))
                  <tbody>
                    @foreach ($mutasi2->get() as $model)
                      <tr>
                        <td style="text-align: center;">{{ numberFormatter(0, 0)->format($loop->iteration) }}</td>
                        <td style="text-align: left;">{{ $model->no_qpr }}</td>
                        <td style="text-align: left;">{{ $model->part_no }}</td>
                        <td style="text-align: left;">{{ $model->part_name }}</td>
                        <td style="text-align: right;">{{ numberFormatter(0, 1)->format($model->qty) }}</td>
                        <td style="text-align: left;">{{ $model->problem }}</td>
                        <td style="text-align: center;">{{ $model->st_respon }}</td>
                        <td style="text-align: center;">{{ $model->st_close }}</td>
                        <td style="text-align: left;">{{ $model->kd_model }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                @endif
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        <button id="print" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print"><span class='glyphicon glyphicon-print'></span> Print</button>
      </div>
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

    document.getElementById("box-grafik").innerHTML = "CLAIM RATIO - " + $( "#filter_status_tahun option:selected" ).text() + $('select[name="filter_status_bulan"]').val() + " - " + $( "#filter_status_supplier option:selected" ).text();
    document.getElementById("th-thnlalu").innerHTML = $( "#filter_status_tahun option:selected" ).text() - 1;
    document.getElementById("th-thn").innerHTML = $( "#filter_status_tahun option:selected" ).text();

    document.getElementById("box-grafik-2").innerHTML = "QPR STATUS - " + $( "#filter_status_tahun option:selected" ).text() + $('select[name="filter_status_bulan"]').val() + " - " + $( "#filter_status_supplier option:selected" ).text();
    document.getElementById("th-thnlalu-2").innerHTML = $( "#filter_status_tahun option:selected" ).text() - 1;
    document.getElementById("th-thn-2").innerHTML = $( "#filter_status_tahun option:selected" ).text();

    var chartData = {
      labels: ["JAN", "PEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEPT", "OCT", "NOV", "DEC"],
      datasets: [{
        type: 'bar',
        label: 'PPM',
        backgroundColor: "rgba(255, 99, 132, 0.2)", //window.chartColors.red,
        data: {!! json_encode($nilai) !!},
        borderColor: "black", //'white',
        borderWidth: 2
      }, {
        type: 'line',
        label: 'TARGET',
        borderColor: window.chartColors.blue,
        borderWidth: 2,
        fill: false, //[false, 'origin', 'start', 'end']
        data: {!! json_encode($target) !!}
      }]
    };

    var chartData2 = {
      labels: ["JAN", "PEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEPT", "OCT", "NOV", "DEC"],
      datasets: [{
        type: 'bar',
        label: 'RESPONSE',
        backgroundColor: window.chartColors.gray,
        data: {!! json_encode($prs_respone) !!},
        borderColor: 'black',
        borderWidth: 2
      }, {
        type: 'line',
        label: 'CLOSE',
        borderColor: window.chartColors.red,
        borderWidth: 2,
        fill: false, //[false, 'origin', 'start', 'end']
        data: {!! json_encode($prs_close) !!}
      }, {
        type: 'line',
        label: 'TARGET',
        borderColor: window.chartColors.green,
        borderWidth: 2,
        fill: false, //[false, 'origin', 'start', 'end']
        data: {!! json_encode($prs_target) !!}
      }]
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
                // stepSize: 20
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
                  ctx.fillText(data, bar._model.x, bar._model.y - 5);
                });
              });
            }
          },
          title: {
            display: true,
            position: 'top', 
            text: 'CLAIM RATIO',
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
            intersect: true
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
                // max: 120, 
                // stepSize: 20
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
                  ctx.fillText(data, bar._model.x, bar._model.y - 5);
                });
              });
            }
          },
          title: {
            display: true,
            position: 'top', 
            text: 'QPR STATUS',
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
            intersect: true
          }
        }
      });
    };

    $(document).ready(function(){ 

      var table1 = $('#tbl1').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        responsive: true,
        'searching': false,
        "paging": false,
        "ordering": false,
      });

      var table2 = $('#tbl2').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        responsive: true,
        'searching': false,
        "paging": false,
        "ordering": false,
      });

      var table3 = $('#tbl3').DataTable({
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        responsive: true,
        //'searching': false,
        //"paging": false,
        //"ordering": true,
      });
    });

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();
      var kd_supp = $('select[name="filter_status_supplier"]').val();

      var urlRedirect = "{{ route('qprs.monitoring2', ['param','param2','param3']) }}";
      urlRedirect = urlRedirect.replace('param3', window.btoa(kd_supp));
      urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
      window.location.href = urlRedirect;
    });

    $('#print').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();
      var kd_supp = $('select[name="filter_status_supplier"]').val();

      var urlRedirect = "{{ route('qprs.monitoringprint', ['param','param2','param3']) }}";
      urlRedirect = urlRedirect.replace('param3', window.btoa(kd_supp));
      urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
      // window.location.href = urlRedirect;
      window.open(urlRedirect, '_blank');
    });
  </script>
@endsection
@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Categories Report
        <small>CR Categories Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - REPORT</li>
        <li class="active"><i class="fa fa-files-o"></i> CR Categories Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body form-horizontal">
              <div class="form-group">
                {!! Form::hidden('param_tahun', \Carbon\Carbon::now()->format('Y'), ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'param_tahun']) !!}
                {!! Form::hidden('param_bulan', \Carbon\Carbon::now()->format('m'), ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'param_bulan']) !!}
                <div class="col-sm-3">
                  {!! Form::label('filter_bulan', 'Bulan') !!}
                  <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
                    class="form-control select2">
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
                  </select>
                </div>
                <div class="col-sm-3">
                  {!! Form::label('filter_tahun', 'Tahun') !!}
                  <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                  class="form-control select2">
                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                      @if ($i == \Carbon\Carbon::now()->format('Y'))
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endfor
                  </select>
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <div class="col-sm-6">
                  {!! Form::label('lblcategories', 'Categories') !!}
                  <select name="filter_nm_kategori" aria-controls="filter_status" class="form-control select2" multiple="multiple">
                    @foreach($bgtt_cr_kategors->get() as $bgtt_cr_kategor)
                      <option value="{{$bgtt_cr_kategor->nm_kategori}}">{{$bgtt_cr_kategor->nm_kategori}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lbldisplay', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->

            <div class="box-body">
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="width: 5%;">No</th>
                    <th rowspan="2">Categories</th>
                    <th rowspan="2" style="width: 20%;">CR Planning/Year</th>
                    <th colspan="2" style="width: 30%;text-align: center">CR Achievement</th>
                    <th rowspan="2" style="width: 5%;">%</th>
                  </tr>
                  <tr>
                    <th style="width: 15%;">Plan</th>
                    <th style="width: 15%;">Actual</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->

            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><p id="info-detail">Detail</p></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th rowspan="2" style="width: 5%;">No</th>
                            <th rowspan="2">Activity</th>
                            <th rowspan="2" style="width: 10%;">Data Submission</th>
                            <th rowspan="2" style="width: 20%;">CR Planning/Year</th>
                            <th colspan="2" style="width: 30%;text-align: center">CR Achievement</th>
                            <th rowspan="2" style="width: 5%;">%</th>
                            <th rowspan="2">Division</th>
                            <th rowspan="2">Department</th>
                            <th rowspan="2">Classification</th>
                            <th rowspan="2">CR Categories</th>
                          </tr>
                          <tr>
                            <th style="width: 15%;">Plan</th>
                            <th style="width: 15%;">Actual</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function(){

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        // "orderable": false,
        "targets": 0,
	    render: function (data, type, row, meta) {
	        return meta.row + meta.settings._iDisplayStart + 1;
	    }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[5, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('bgttcrsubmits.dashboardreportcategories') }}",
      columns: [
      	{data: null, name: null},
        {data: 'nm_kategori', name: 'nm_kategori'},
        {data: 'plan_year_amt', name: 'plan_year_amt', className: "dt-right"},
        {data: 'plan_ytd_amt', name: 'plan_ytd_amt', className: "dt-right"},
        {data: 'act_ytd_amt', name: 'act_ytd_amt', className: "dt-right"},
        {data: 'persen_ytd', name: 'persen_ytd', className: "dt-right"}
      ], 
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
          i : 0;
        };

        var total_plan = 0;
        var total_act = 0;

        var column = 2;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total_plan = total;
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total_act = total;
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var persen = 0;
        if(total_plan > 0) {
          persen = (total_act/total_plan)*100;
        }
        var column = 5;
        persen = persen.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + persen + '%</p>'
        );
      }
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail';
        initTable(window.btoa('-'), window.btoa('-'), window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var tahun = document.getElementById("param_tahun").value.trim();
          var bulan = document.getElementById("param_bulan").value.trim();
          var index = tableMaster.row('.selected').index();
          var nm_kategori = tableMaster.cell(index, 1).data();
          var info = "Categories: " + nm_kategori + ", Tahun: " + tahun + ", Bulan: " + bulan;
          document.getElementById("info-detail").innerHTML = 'Detail (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(tahun.replace(regex, "")), window.btoa(bulan.replace(regex, "")), window.btoa(nm_kategori.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('bgttcrsubmits.dashboardreportcategoriesdetail', ['param', 'param2', 'param3']) }}';
    url = url.replace('param3', window.btoa("-"));
    url = url.replace('param2', window.btoa("-"));
    url = url.replace('param', window.btoa("-"));
    var tableDetail = $('#tblDetail').DataTable({
      "columnDefs": [{
        "searchable": false,
        // "orderable": false,
        "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[6, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'nm_aktivitas', name: 'nm_aktivitas'},
        {data: 'submit_dt', name: 'submit_dt', className: "dt-center"},
        {data: 'plan_year_amt', name: 'plan_year_amt', className: "dt-right"},
        {data: 'plan_ytd_amt', name: 'plan_ytd_amt', className: "dt-right"},
        {data: 'act_ytd_amt', name: 'act_ytd_amt', className: "dt-right"},
        {data: 'persen_ytd', name: 'persen_ytd', className: "dt-right"}, 
        {data: 'desc_div', name: 'desc_div', className: "none"},
        {data: 'desc_dep', name: 'desc_dep', className: "none"},
        {data: 'nm_klasifikasi', name: 'nm_klasifikasi', className: "none"},
        {data: 'nm_kategori', name: 'nm_kategori', className: "none"}
      ], 
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
          i : 0;
        };

        var total_plan = 0;
        var total_act = 0;

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total_plan = total;
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 5;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total_act = total;
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var persen = 0;
        if(total_plan > 0) {
          persen = (total_act/total_plan)*100;
        }
        var column = 6;
        persen = persen.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + persen + '%</p>'
        );
      }
    });

    function initTable(tahun, bulan, nm_kategori) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('bgttcrsubmits.dashboardreportcategoriesdetail', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', nm_kategori);
      url = url.replace('param2', bulan);
      url = url.replace('param', tahun);
      tableDetail.ajax.url(url).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.bulan = $('select[name="filter_bulan"]').val();
      data.tahun = $('select[name="filter_tahun"]').val();
      data.nm_kategori = $('select[name="filter_nm_kategori"]').val();
      document.getElementById("param_tahun").value = $('select[name="filter_tahun"]').val();
      document.getElementById("param_bulan").value = $('select[name="filter_bulan"]').val();
    });

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail';
      document.getElementById("param_tahun").value = $('select[name="filter_tahun"]').val();
      document.getElementById("param_bulan").value = $('select[name="filter_bulan"]').val();
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'), window.btoa('-'), window.btoa('-'));
        }
      });
    });
  });
</script>
@endsection
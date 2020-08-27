@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Progress PMS
        <small>Progress PMS</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> Progress PMS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('tgl_awal', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal']) !!}
      {!! Form::hidden('tgl_akhir', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir']) !!}
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lbltglawal', 'Tanggal Awal') !!}
              {!! Form::date('filter_tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tanggal Awal', 'id' => 'filter_tgl_awal']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbltglakhir', 'Tanggal Akhir') !!}
              {!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tanggal Akhir', 'id' => 'filter_tgl_akhir']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblplant', 'Plant') !!}
              <select name="filter_plant" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($plant->get() as $kode)
                  <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>
    		</div>
    		<!-- /.box-body -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    <p><label>Progress PMS</label></p>
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
                        <th style="width: 5%;">No</th>
                        <th>Kode Plant</th>
                        <th style="width: 20%;">Plan</th>
                        <th style="width: 20%;">Actual</th>
                        <th style="width: 20%;">%</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.box-body -->

                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            <p><label id="info-zona">Progress PMS</label></p>
                          </h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                              <i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <table id="tblZona" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th style="width: 5%;">No</th>
                                <th>Zona</th>
                                <th style="width: 20%;">Plan</th>
                                <th style="width: 20%;">Actual</th>
                                <th style="width: 20%;">%</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>Total</th>
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

                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            <p><label id="info-detail">Progress PMS</label></p>
                          </h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                              <i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th style="width: 1%;">No</th>
                                <th style="width: 15%;">Kode Mesin</th>
                                <th>Nama Mesin</th>
                                <th style="width: 10%;">Plan</th>
                                <th style="width: 10%;">Actual</th>
                                <th style="width: 10%;">%</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>Total</th>
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
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
  var urlMaster = '{{ route('mtctpmss.dashboardprogress') }}';
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
    "iDisplayLength": 10,
    responsive: true,
    "order": [[1, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlMaster, 
    columns: [
      {data: null, name: null, className: "dt-left"},
      {data: 'kd_plant', name: 'kd_plant', className: "dt-left"},
      {data: 'plan', name: 'plan', className: "dt-right"},
      {data: 'actual', name: 'actual', className: "dt-right"},
      {data: 'persen', name: 'persen', className: "dt-right"}
    ], 
  });

  $('#tblMaster tbody').on( 'click', 'tr', function () {
    if ($(this).hasClass('selected') ) {
      $(this).removeClass('selected');
      document.getElementById("info-zona").innerHTML = 'Progress PMS';
      initTable(window.btoa('-'));
    } else {
      tableMaster.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      if(tableMaster.rows().count() > 0) {
        var index = tableMaster.row('.selected').index();
        var kd_plant = tableMaster.cell(index, 1).data();
        document.getElementById("info-zona").innerHTML = 'Progress PMS (Kode Plant: ' + kd_plant + ')';
        var regex = /(<([^>]+)>)/ig;
        initTable(window.btoa(kd_plant.replace(regex, "")));
      }
    }
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
    data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    data.plant = $('select[name="filter_plant"]').val();
  });

  var urlZona = '{{ route('mtctpmss.dashboardprogresszona', ['param','param2','param3']) }}';
  urlZona = urlZona.replace('param3', window.btoa("-"));
  urlZona = urlZona.replace('param2', window.btoa($('input[name="filter_tgl_akhir"]').val()));
  urlZona = urlZona.replace('param', window.btoa($('input[name="filter_tgl_awal"]').val()));
  var tableZona = $('#tblZona').DataTable({
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0,
      render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    }],
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 5,
    responsive: true,
    "order": [[1, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlZona,
    columns: [
      {data: null, name: null, className: "dt-left"},
      {data: 'zona', name: 'zona', className: "dt-left"},
      {data: 'plan', name: 'plan', className: "dt-right"},
      {data: 'actual', name: 'actual', className: "dt-right"},
      {data: 'persen', name: 'persen', className: "dt-right"}
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
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );
    }
  });

  $('#tblZona tbody').on( 'click', 'tr', function () {
    if ($(this).hasClass('selected') ) {
      $(this).removeClass('selected');
      document.getElementById("info-detail").innerHTML = 'Progress PMS';
      initTable2(window.btoa('-'));
    } else {
      tableZona.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      if(tableZona.rows().count() > 0) {
        var indexMaster = tableMaster.row('.selected').index();
        var kd_plant = tableMaster.cell(indexMaster, 1).data();

        var indexZona = tableZona.row('.selected').index();
        var zona = tableZona.cell(indexZona, 1).data();

        document.getElementById("info-detail").innerHTML = 'Progress PMS (Kode Plant: ' + kd_plant + ', Zona: ' + zona + ')';
        var regex = /(<([^>]+)>)/ig;
        initTable2(window.btoa(kd_plant.replace(regex, "")), window.btoa(zona.replace(regex, "")));
      }
    }
  });

  var urlDetail = '{{ route('mtctpmss.dashboardprogressmesin', ['param','param2','param3','param4']) }}';
  urlDetail = urlDetail.replace('param4', window.btoa("-"));
  urlDetail = urlDetail.replace('param3', window.btoa("-"));
  urlDetail = urlDetail.replace('param2', window.btoa($('input[name="filter_tgl_akhir"]').val()));
  urlDetail = urlDetail.replace('param', window.btoa($('input[name="filter_tgl_awal"]').val()));
  var tableDetail = $('#tblDetail').DataTable({
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0,
      render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    }],
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "order": [[1, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlDetail,
    columns: [
      { data: null, name: null, className: "dt-left"},
      { data: 'kd_mesin', name: 'kd_mesin'},
      { data: 'nm_mesin', name: 'nm_mesin'},
      { data: 'plan', name: 'plan', className: "dt-right"},
      { data: 'actual', name: 'actual', className: "dt-right"},
      { data: 'persen', name: 'persen', className: "dt-right"}
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
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );
    }
  });

  function initTable(kd_plant) {

    var tgl_awal = document.getElementById("tgl_awal").value.trim();
    var tgl_akhir = document.getElementById("tgl_akhir").value.trim();

    tableZona.search('').columns().search('').draw();
    var urlZona = '{{ route('mtctpmss.dashboardprogresszona', ['param','param2','param3']) }}';
    urlZona = urlZona.replace('param3', kd_plant);
    urlZona = urlZona.replace('param2', window.btoa(tgl_akhir));
    urlZona = urlZona.replace('param', window.btoa(tgl_awal));

    document.getElementById("info-detail").innerHTML = 'Progress PMS';
    tableZona.ajax.url(urlZona).load( function ( json ) {
      if(tableZona.rows().count() > 0) {
        $('#tblZona tbody tr:eq(0)').click(); 
      } else {
        initTable2(window.btoa('-'), window.btoa('-'));
      }
    });
  }

  function initTable2(kd_plant, zona) {

    var tgl_awal = document.getElementById("tgl_awal").value.trim();
    var tgl_akhir = document.getElementById("tgl_akhir").value.trim();

    tableDetail.search('').columns().search('').draw();
    var urlDetail = '{{ route('mtctpmss.dashboardprogressmesin', ['param','param2','param3','param4']) }}';
    urlDetail = urlDetail.replace('param4', zona);
    urlDetail = urlDetail.replace('param3', kd_plant);
    urlDetail = urlDetail.replace('param2', window.btoa(tgl_akhir));
    urlDetail = urlDetail.replace('param', window.btoa(tgl_awal));
    tableDetail.ajax.url(urlDetail).load();
  }

  $('#display').click( function () {
    document.getElementById("tgl_awal").value = $('input[name="filter_tgl_awal"]').val();
    document.getElementById("tgl_akhir").value = $('input[name="filter_tgl_akhir"]').val();

    document.getElementById("info-zona").innerHTML = 'Progress PMS';
    document.getElementById("info-detail").innerHTML = 'Progress PMS';
    tableMaster.ajax.reload( function ( json ) {
      if(tableMaster.rows().count() > 0) {
        $('#tblMaster tbody tr:eq(0)').click(); 
      } else {
        initTable(window.btoa('-'));
      }
    });
  });

  $('#display').click();
});
</script>
@endsection
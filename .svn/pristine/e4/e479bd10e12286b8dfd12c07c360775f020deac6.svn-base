@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring PKL ALL
        <small>Monitoring PKL ALL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Monitoring PKL ALL</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lbltahun', 'Tahun') !!}
              <select name="filter_status_tahun" aria-controls="filter_status" 
                class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
                  @if ($i == \Carbon\Carbon::now()->format('Y'))
                    <option value={{ $i }} selected="selected">{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblbulan', 'Bulan') !!}
              <select name="filter_status_bulan" aria-controls="filter_status" 
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
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 5%;">NPK</th>
                <th>Nama</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 10%;">Finger</th>
                <th style="width: 10%;">Jam Prik</th>
                <th style="width: 10%;">Jam PKL</th>
                <th style="width: 10%;">Total Jam</th>
                <th style="width: 10%;">Jam Lembur</th>
                <th style="width: 10%;">Jam TUL</th>
                <th>No. PKL</th>
                <th>Keperluan</th>
                <th>Uang-Makan/Pot. Istirahat 1</th>
                <th>Uang-Makan/Pot. Istirahat 2</th>
                <th>Potongan Istirahat</th>
                <th>Schedule Kerja</th>
                <th>Libur</th>
                <th>Transport</th>
                <th>Submit</th>
                <th>Section Head</th>
                <th>Dept Head</th>
                <th>Div Head</th>
                <th>Payroll</th>
                <th>Tgl Input</th>
                <th>Periode Gaji</th>
                <th>TULGP/JAM</th>
                <th>TULMT/JAM</th>
                <th>DIVISI</th>
                <th>DEPARTEMEN</th>
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
                <th>Total</th>
                <th>Total</th>
                <th>Total</th>
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
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
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
    // "searching": false,
    // "scrollX": true,
    // "scrollY": "700px",
    // "scrollCollapse": true,
    // "paging": false,
    // "lengthChange": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    "order": [[3, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: "{{ route('mobiles.dashboardmonitoringpklall') }}",
    columns: [
      {data: null, name: null},
      {data: 'npk', name: 'npk'},
      {data: 'nama', name: 'nama'},
      {data: 'tgl_pkl', name: 'tgl_pkl'},
      {data: 'absen_finger', name: 'absen_finger'},
      {data: 'jam_prik', name: 'jam_prik'},
      {data: 'jam_pkl', name: 'jam_pkl'},
      {data: 'total_jam', name: 'total_jam', className: "dt-right"},
      {data: 'jam_lembur', name: 'jam_lembur', className: "dt-right"},
      {data: 'jam_tul', name: 'jam_tul', className: "dt-right", orderable: false, searchable: false},
      {data: 'no_pkl', name: 'no_pkl', className: "none"},
      {data: 'keperluan', name: 'keperluan', className: "none"},
      {data: 'makan', name: 'makan', className: "none"},
      {data: 'makan2', name: 'makan2', className: "none"},
      {data: 'wkt_istirahat', name: 'wkt_istirahat', className: "none"},
      {data: 'sch_kerja', name: 'sch_kerja', className: "none"},
      {data: 'libur', name: 'libur', className: "none"},
      {data: 'transp', name: 'transp', className: "none"},
      {data: 'print_by', name: 'print_by', className: "none", orderable: false, searchable: false},
      {data: 'app_sie_code', name: 'app_sie_code', className: "none"},
      {data: 'app_dep_code', name: 'app_dep_code', className: "none"},
      {data: 'app_div_code', name: 'app_div_code', className: "none"},
      {data: 'npk_payroll', name: 'npk_payroll', className: "none"},
      {data: 'tgl_input', name: 'tgl_input', className: "none"},
      {data: 'periode_gaji', name: 'periode_gaji', className: "none"},
      {data: 'tulgp', name: 'tulgp', className: "none"},
      {data: 'tulmt', name: 'tulmt', className: "none"},
      {data: 'divisi', name: 'divisi', className: "none"},
      {data: 'departemen', name: 'departemen', className: "none"}
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

      var column = 7;
      total = api.column(column).data().reduce( function (a, b) {
        return intVal(a) + intVal(b);
      },0);
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );

      var column = 8;
      total = api.column(column).data().reduce( function (a, b) {
        return intVal(a) + intVal(b);
      },0);
      total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      $(api.column(column).footer() ).html(
        // 'Total OK: '+ pageTotal + ' ('+ total +')'
        '<p align="right">' + total + '</p>'
      );

      var column = 9;
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

  $(function() {
    $('\
      <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
        <label>Status\
        <select size="1" name="filter_status" aria-controls="filter_status" \
          class="form-control select2" style="width: 150px;">\
            <option value="ALL" selected="selected">ALL</option>\
            <option value="D">Draft</option>\
            <option value="S">Submit</option>\
            <option value="SEC">Approve Section</option>\
            <option value="DEP">Approve Dept Head</option>\
            <option value="DIV">Approve Div Head</option>\
            <option value="P">Approve Payroll</option>\
            <option value="K">Jam Prik Kosong</option>\
            <option value="EA">Edit Absen</option>\
          </select>\
        </label>\
      </div>\
    ').insertAfter('.dataTables_length');

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('select[name="filter_status_tahun"]').val();
      data.bulan = $('select[name="filter_status_bulan"]').val();
      data.status = $('select[name="filter_status"]').val();
    });

    $('select[name="filter_status"]').change(function() {
      tableMaster.ajax.reload();
    });
  });

  $('#display').click( function () {
    tableMaster.ajax.reload();
  });

  $('#display').click();
});
</script>
@endsection
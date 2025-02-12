@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi Mesin Finger
        <small>Absensi Mesin Finger</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> HR - Mobile</li>
        <li class="active"><i class="fa fa-files-o"></i> Absensi Mesin Finger</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Absensi Mesin Finger</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
                {!! Form::label('lbltahun', 'Tahun') !!}
                <select name="filter_status_tahun" aria-controls="filter_status" 
                  class="form-control select2">
                  @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
                    @if ($i == base64_decode($tahun))
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
                  <option value="01" @if ("01" == base64_decode($bulan)) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == base64_decode($bulan)) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == base64_decode($bulan)) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == base64_decode($bulan)) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == base64_decode($bulan)) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == base64_decode($bulan)) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == base64_decode($bulan)) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == base64_decode($bulan)) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == base64_decode($bulan)) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == base64_decode($bulan)) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == base64_decode($bulan)) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == base64_decode($bulan)) selected="selected" @endif>Desember</option>
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
                <th rowspan="2" style="text-align: center;width: 15%;">Tanggal</th>
                <th rowspan="2" style="text-align: center;width: 15%;">Hari</th>
                <th colspan="2" style='text-align: center'>Jam</th>
                <th rowspan="2" style="text-align: center;width: 10%;">Shift PKL</th>
                <th rowspan="2">Keterangan</th>
              </tr>
              <tr>
                <th style="width: 10%;">IN</th>
                <th style="width: 10%;">OUT</th>
              </tr>
            </thead>
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

  var tahun = "{{ $tahun }}";
  var bulan = "{{ $bulan }}";
  var url = "{{ route('mobiles.dashboardabsenprik', ['param','param2']) }}";
  url = url.replace('param2', bulan);
  url = url.replace('param', tahun);

  var tableMaster = $('#tblMaster').DataTable({
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "searching": false,
    // "scrollX": true,
    // "scrollY": "700px",
    // "scrollCollapse": true,
    "paging": false,
    // "lengthChange": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    "order": [],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: url,
    columns: [
      {data: 'tgl', name: 'tgl', className: "dt-center", orderable: false, searchable: false},
      {data: 'hari', name: 'hari', className: "dt-center", orderable: false, searchable: false},
      {data: 'jam_in', name: 'jam_in', className: "dt-center", orderable: false, searchable: false},
      {data: 'jam_out', name: 'jam_out', className: "dt-center", orderable: false, searchable: false},
      {data: 'shift_pkl', name: 'shift_pkl', className: "dt-center", orderable: false, searchable: false},
      {data: 'ket', name: 'ket', orderable: false, searchable: false}
    ]
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.tahun = $('select[name="filter_status_tahun"]').val();
    data.bulan = $('select[name="filter_status_bulan"]').val();
  });

  $('#display').click( function () {
    var tahun = $('select[name="filter_status_tahun"]').val();
    var bulan = $('select[name="filter_status_bulan"]').val();

    var urlRedirect = "{{ route('mobiles.absenprik', ['param','param2']) }}";
    urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
    urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
    window.location.href = urlRedirect;
  });
});
</script>
@endsection
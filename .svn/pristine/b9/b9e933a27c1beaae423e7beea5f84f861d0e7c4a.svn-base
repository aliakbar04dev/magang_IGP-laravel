@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Genba BOD - Countermeasure
        <small>Daftar Genba BOD - Countermeasure</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MANAGEMENT - Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Genba BOD - CM</li>
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
                <div class="col-sm-3">
                  {!! Form::label('lblawal', 'Tgl Awal') !!}
                  {!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('lblakhir', 'Tgl Akhir') !!}
                  {!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
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
			            	<th style="width: 1%;">No</th>
		                <th style="width: 12%;">No. Genba</th>
		                <th style="width: 5%;">Tgl</th>
		                <th>Detail</th>
		                <th>Site</th>
                    <th style="width: 5%;">Area</th>
                    <th style="width: 20%;">Lokasi</th>
                    <th>PIC</th>
                    <th>Picture</th>
                    <th>Countermeasure</th>
                    <th>CM Picture</th>
                    <th style="width: 10%;">Status Close</th>
                    <th>Creaby</th>
                    <th>Modiby</th>
		                <th style="width: 5%;">Action</th>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('mgt.popup.imgModal')
@endsection

@section('scripts')
<script type="text/javascript">

  function showPict(title, lok_file, mime) {
    $("#boxtitle").html(title);
    $('#lok_pict').attr('src', "data:" + mime + ";charset=utf-8;base64," + lok_file);
  }
  
  $(document).ready(function(){

    var url = '{{ route('dashboardcm.mgmtgembas') }}';
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
      "order": [['1','desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'no_gemba', name: 'no_gemba', className: "dt-center"},
        {data: 'tgl_gemba', name: 'tgl_gemba', className: "dt-center"},
        {data: 'det_gemba', name: 'det_gemba'},
        {data: 'nm_site', name: 'nm_site', className: "none"},
        {data: 'kd_area', name: 'kd_area'},
        {data: 'lokasi', name: 'lokasi'},
        {data: 'npk_pic', name: 'npk_pic', className: "none"},
        {data: 'pict_gemba', name: 'pict_gemba', className: "none", orderable: false, searchable: false}, 
        {data: 'cm_ket', name: 'cm_ket', className: "none", orderable: false, searchable: false},
        {data: 'cm_pict', name: 'cm_pict', className: "none", orderable: false, searchable: false}, 
        {data: 'st_gemba', name: 'st_gemba', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $(function() {
      $('\
        <div id="filter_gemba" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Close\
          <select size="1" name="filter_gemba" aria-controls="filter_gemba" \
            class="form-control select2" style="width: 100px;">\
              <option value="ALL" selected="selected">All</option>\
              <option value="T">YES</option>\
              <option value="F">NO</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.st_gemba = $('select[name="filter_gemba"]').val();
      });

      $('select[name="filter_gemba"]').change(function() {
        tableMaster.ajax.reload();
      });
    });
  });
</script>
@endsection
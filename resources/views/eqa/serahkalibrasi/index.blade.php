@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengambilan Alat Ukur 
      <small>Kalibrasi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('serahkalibrasi.index') }}"><i class="fa fa-files-o"></i>QA - Kalibrasi</a></li>
      <li class="active">Pengambilan Alat Ukur</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Pengambilan Alat Ukur</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('qa-serahkalibrasi-create')
        <p>
          <a class="btn btn-primary" href="{{ route('serahkalibrasi.create') }}"><span class="fa fa-plus"></span> Add Pengambilan Alat Ukur</a>
        </p>
        @endpermission        
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-3">
            {!! Form::label('tahun', 'Tahun') !!}
            <div class="input-group">
              {!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
              {!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <div class="col-sm-2">
            {!! Form::label('bulan', 'Bulan') !!}
            <div class="input-group">
              {!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
              {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}       
            </div>            
          </div>
        </div>

        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
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
              <th style="width: 3%;">No Serah</th>
              <th style="width: 3%;">Tgl Serah</th>
              <th style="width: 3%;">No Order</th>              
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("tahun").focus();


  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){

    var url = '{{ route('serahkalibrasi.dashboard') }}';
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
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'no_srhalat', name: 'no_srhalat'},
      {data: 'tgl_serah', name: 'tgl_serah'},
      {data: 'no_wdo', name: 'no_wdo'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('input[name="tahun"]').val();
      data.bulan = $('select[name="bulan"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });    
  });
  
</script>
@endsection
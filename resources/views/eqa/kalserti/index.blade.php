@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sertifikat Kalibrasi 
      <small>Kalibrasi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('kalserti.index') }}"><i class="fa fa-files-o"></i>QA - Sertifikat</a></li>
      <li class="active">Sertifikat Kalibrasi</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Sertifikat Kalibrasi</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
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
              <th style="width: 5%;">No Sertifikat</th>
              <th style="width: 5%;">Tgl Sertifikat</th>
              <th style="width: 5%;">No Seri</th>
              <th style="width: 5%;">Nama Alat</th>
              <th style="width: 5%;">Tipe</th> 
              <th style="width: 5%;">Merk</th> 
              <th style="width: 5%;">Customer</th> 
              <th style="width: 5%;">No Worksheet</th> 
              <th style="width: 5%;">Tgl Kalibrasi</th>   
              <th style="width: 5%;">File Sertifikat</th>                      
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

  //Initialize Select2 Elements
  $(".select2").select2();
  document.getElementById("tahun").focus();
  $(document).ready(function(){    
    var url = '{{ route('kalserti.dashboard') }}';
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
      {data: 'no_serti', name: 'no_serti'},
      {data: 'tgl_serti', name: 'tgl_serti'},
      {data: 'no_seri', name: 'no_seri'},
      {data: 'nm_alat', name: 'nm_alat'},
      {data: 'nm_type', name: 'nm_type'},
      {data: 'nm_merk', name: 'nm_merk'},
      {data: 'nm_cust', name: 'nm_cust'},
      {data: 'no_ws', name: 'no_ws'},
      {data: 'tgl_kalibrasi', name: 'tgl_kalibrasi'},
      {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}    
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
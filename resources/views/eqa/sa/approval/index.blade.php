@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Approval Special Acceptance
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('qatsas.index') }}"><i class="fa fa-files-o"></i>QA - Approval Special Acceptance</a></li>
      <li class="active">Approval Special Acceptance</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Approval Special Acceptance</h3>
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
              <th style="width: 5%;">No SA</th>
              <th style="width: 5%;">Revisi</th>
              <th style="width: 5%;">Tanggal</th>
              <th style="width: 5%;">Partno</th>
              <th style="width: 5%;">Part Detail</th> 
              <th style="width: 5%;">Qty</th> 
              <th style="width: 5%;">Satuan</th>  
              <th style="width: 5%;">Action</th>                         
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
    var url = '{{ route('qatsas.dashboardapp') }}';
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
      {data: 'no_doc', name: 'no_doc'},
      {data: 'rev', name: 'rev'},
      {data: 'tgl', name: 'tgl'},
      {data: 'part_no', name: 'part_no'},
      {data: 'part_detail', name: 'part_detail'},
      {data: 'qty', name: 'qty'},
      {data: 'kd_sat', name: 'kd_sat'},
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
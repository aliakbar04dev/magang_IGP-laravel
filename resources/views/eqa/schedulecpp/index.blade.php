@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Schedule 
      <small>CPP</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('schedulecpp.index') }}"><i class="fa fa-files-o"></i>QA - Schedule CPP</a></li>
      <li class="active">Schedule CPP</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Schedule CPP</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('qa-audit-schedule-cpp')
        <p>
          <a class="btn btn-primary" href="{{ route('schedulecpp.create') }}"><span class="fa fa-plus"></span> Add Schedule</a>
        </p>
        @endpermission        
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-4">
           {!! Form::label('site', 'Site') !!}
              <select name="site" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="IGPJ" @if ("IGPJ" == base64_decode($site)) selected="selected" @endif>IGP Jakarta</option>
                  <option value="IGPK" @if ("IGPK" == base64_decode($site)) selected="selected" @endif>IGP Karawang</option>
                </select>
          </div>         
        </div>

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

        <div class="form-group">
           <div class="col-sm-4">
            {!! Form::label('jenisLine', 'Jenis Line') !!}
              <select name="jenisLine" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="ARC WELDING" @if ("ARC WELDING" == base64_decode($jenisLine)) selected="selected" @endif>ARC WELDING</option>
                  <option value="PROJECTION WELDING" @if ("PROJECTION WELDING" == base64_decode($jenisLine)) selected="selected" @endif>PROJECTION WELDING</option>
                  <option value="HEAT TREATMENT" @if ("HEAT TREATMENT" == base64_decode($jenisLine)) selected="selected" @endif>HEAT TREATMENT</option>
                </select>         
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
              <th style="width: 1%;" rowspan="2">No </th>
              <th style="width: 5%;" rowspan="2">No Document</th>
              <th style="width: 5%;" rowspan="2">Site</th>
              <th style="width: 5%;" rowspan="2">Jenis Line</th>
              <th style="width: 5%;" rowspan="2">Line</th>
              <th style="width: 5%;" rowspan="2">Mesin</th> 
              <th style="width: 5%;" rowspan="2">Lead Auditor</th>
              <th style="width: 5%;" colspan="2">Tgl</th>                         
            </tr>
            <tr>
              <th>Plan</th>
              <th>Act</th>
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
  //document.getElementById("site").focus();
  $(document).ready(function(){
    $("#btnpopupCust").click(function(){
      popupCust();
    });
    
    var url = '{{ route('schedulecpp.dashboard') }}';

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
      {data: 'kd_site', name: 'kd_site'},
      {data: 'jns_line', name: 'jns_line'},
      {data: 'kd_line', name: 'kd_line'},
      {data: 'kd_mesin', name: 'kd_mesin'},
      {data: 'npk', name: 'npk'},
      {data: 'tgl_plan', name: 'tgl_plan'},    
      {data: 'tgl_act', name: 'tgl_act'} ,  
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.site = $('select[name="site"]').val();
      data.jenisLine = $('select[name="jenisLine"]').val();
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
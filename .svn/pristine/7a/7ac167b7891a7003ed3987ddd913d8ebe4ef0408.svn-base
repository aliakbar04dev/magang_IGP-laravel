@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      BPB CR Consumable  
      <small>Ireguler</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-truck"></i> PPC - TRANSAKSI</li>
      <li class="active">BPB CR Consumable Ireguler</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">BPB CR Consumable Ireguler</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('ppc-bpbcrcons-create')
        <p>
          <a class="btn btn-primary" href="{{ route('bpbcrconsireg.create') }}"><span class="fa fa-plus"></span> Add BPB</a>
        </p>
        @endpermission
        
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
            <div class="input-group">
             {!! Form::label('kd_plant', 'Plant (*)') !!}
             {!! Form::select('kd_plant', ['ALL' => 'ALL', 'A' => 'KIM-1A', 'B' => 'KIM-1B'], null, ['class'=>'form-control select2','data-placeholder' => 'Pilih Plant', 'required', 'id' => 'kd_plant']) !!}
            </div>
          </div>
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
            <th style="width: 3%;">No Doc</th>
            <th style="width: 3%;">Tanggal</th>
            <th style="width: 3%;">Kode Line</th>
            <th style="width: 3%;">Nama Line</th>
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

  document.getElementById("kd_plant").focus();
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    
    var url = '{{ route('bpbcrconsireg.dashboard') }}';
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
      {data: 'tgl', name: 'tgl'},
      {data: 'kd_line', name: 'kd_line'},
      {data: 'nmline', name: 'nmline'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.plant = $('select[name="kd_plant"]').val();
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
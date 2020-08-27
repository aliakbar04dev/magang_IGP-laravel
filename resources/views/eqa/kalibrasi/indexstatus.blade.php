@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Status Alat Ukur 
      <small>Kalibrasi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('kalibrasidet.index') }}"><i class="fa fa-files-o"></i>QA - Kalibrasi</a></li>
      <li class="active">Status Alat Ukur</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Status Alat Ukur</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal">
        <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">          
          <div class="col-sm-3">
            {!! Form::label('pt', 'PT (*)') !!}
            <div class="input-group">
              {!! Form::select('pt', ['IGP' => 'INTI GANDA PERDANA', 'GKD' => 'GEMALA KEMPA DAYA', 'AWI' => 'AKASHI WAHANA INDONESIA', 'AGI' => 'ASANO GEAR INDONESIA'], null, ['class'=>'form-control select2', 'id' => 'pt', 'required']) !!}         
              {!! $errors->first('pt', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <div class="col-sm-2">
            {!! Form::label('kd_plant', 'Plant (*)') !!}
            <div class="input-group">
              <select id="kd_plant" name="kd_plant" class="form-control select2">
                <option value="" selected="selected">ALL</option>
                @foreach($plants->get() as $kode)
                  <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                @endforeach
              </select> 
            </div>
          </div>
        </div>
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
              <th style="width: 3%;">No Order</th>
              <th style="width: 3%;">No Seri</th>
              <th style="width: 3%;">Nama Alat Ukur</th>
              <th style="width: 3%;">Tgl Daftar</th>
              <th style="width: 3%;">Tgl Hasil</th>
              <th style="width: 3%;">Tgl Sertifikat</th>
              <th style="width: 3%;">Tgl Kembali</th>
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
    $("#btnpopupLine").click(function(){
      popupLine();
    });

    $("#btnpopupJenis").click(function(){
      popupJenis();
    });

    var url = '{{ route('kalibrasidet.dashboard') }}';
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
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'no_order', name: 'no_order'},
      {data: 'no_seri', name: 'no_seri'},
      {data: 'nm_alat', name: 'nm_alat'},
      {data: 'tgl_order', name: 'tgl_order'},
      {data: 'tgl_selesai', name: 'tgl_selesai'},
      {data: 'tgl_serti', name: 'tgl_serti'},
      {data: 'tgl_kembali', name: 'tgl_kembali'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.plant = $('select[name="kd_plant"]').val();
      data.pt = $('select[name="pt"]').val();
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
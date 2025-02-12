@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Work Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('wos.approval') }}"><i class="fa fa-files-o"></i> Daftar Work Order</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Work Order</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($wo, ['url' => route('wos.updatesolusi', base64_encode($wo->id)),
            'method'=>'get', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          <div class="box-body">
            <div class="form-group"> 
              <div class="col-sm-3 {{ $errors->has('no_wo') ? ' has-error' : '' }}">
                {!! Form::label('no_wo', 'No. WO') !!}
                @if (empty($wos->no_wo))
                  {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. WO', 'disabled'=>'']) !!}
                @else
                  {!! Form::text('no_wo2', $wos->no_dm, ['class'=>'form-control','placeholder' => 'No. WO', 'required', 'disabled'=>'']) !!}
                  {!! Form::hidden('no_wo', null, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'readonly'=>'readonly']) !!}
                @endif
                {!! $errors->first('no_wo', '<p class="help-block">:message</p>') !!}
              </div>

              <div class="col-sm-2 {{ $errors->has('tgl_wo') ? ' has-error' : '' }}">
                {!! Form::label('tgl_wo', 'Tanggal WO (*)') !!}
                @if (empty($wo->tgl_wo))
                  {!! Form::date('tgl_wo', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl WO', 'required', 'readonly'=>'readonly']) !!}
                @else
                  {!! Form::date('tgl_wo', \Carbon\Carbon::parse($wo->tgl_wo), ['class'=>'form-control','placeholder' => 'Tgl WO', 'required', 'readonly'=>'readonly']) !!}
                @endif
                {!! $errors->first('tgl_wo', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-3 {{ $errors->has('kd_pt') ? ' has-error' : '' }}">
                {!! Form::label('kd_pt', 'PT') !!}
                @if (empty($wo->kd_pt))
                  {!! Form::select('kd_pt', ['IGP' => 'PT INTI GANDA PERDANA', 'WEP' => 'PT WAHANA EKA PARAMITRA'], null, ['class'=>'form-control select2']) !!}
                @else
                  {!! Form::select('kd_pt', ['IGP' => 'PT INTI GANDA PERDANA', 'WEP' => 'PT WAHANA EKA PARAMITRA'], null, ['class'=>'form-control select2', 'disabled'=>'']) !!}
                @endif
                {!! $errors->first('kd_pt', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-2 {{ $errors->has('ext') ? ' has-error' : '' }}">
                {!! Form::label('ext', 'EXT (*)') !!}
                {!! Form::number('ext', null, ['class'=>'form-control', 'placeholder' => 'Bagian','required', 'maxlength'=>'5', 'disabled'=>'']) !!}
                {!! $errors->first('ext', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-3 {{ $errors->has('jenis_orders') ? ' has-error' : '' }}">
                {!! Form::label('jenis_orders', 'Permintaan/Problem (*)') !!}
                {!! Form::select('jenis_orders',array('Internet/E-mail' => 'Internet/E-mail', 'Jaringan dan Peripheral' => 'Jaringan dan Peripheral', 'Login User/Hak Aplikasi' => 'Login User/Hak Aplikasi', 'Pembelian Hardware Baru' => 'Pembelian Hardware Baru', 'Program Aplikasi' => 'Program Aplikasi', 'Service Komputer dan Peripheral' => 'Service Komputer dan Peripheral','Service Printer/Scanner' => 'Service Printer/Scanner','Software Paket/Utility/Operating System' => 'Software Paket/Utility/Operating System'), null, ['class'=>'form-control select2', 'required',  'onchange' => 'detail()','disabled'=>'']) !!}
                {!! $errors->first('jenis_orders', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-3 {{ $errors->has('detail_orders') ? ' has-error' : '' }}">
                {!! Form::label('detail_orders', 'Detail Permintaan/Problem') !!}
                {!! Form::select('detail_orders',['-' => '-', 'Mutasi' => 'Mutasi', 'Penambahan' => 'Penambahan', 'Pengurangan' => 'Pengurangan', 'Modifikasi/Penambahan' => 'Modifikasi/Penambahan', 'Permintaan Data' => 'Permintaan Data', 'Program Baru' => 'Program Baru'],null, ['id' => 'detail_orders', 'class'=>'form-control select2', 'required', 'disabled'=>'']) !!}
                {!! $errors->first('detail_orders', '<p class="help-block">:message</p>') !!}
              </div>
              <div class="col-sm-3 {{ $errors->has('id_hw') ? ' has-error' : '' }}">
                {!! Form::label('id_hw', 'ID Hardware') !!}
                {!! Form::text('id_hw', null, ['class'=>'form-control', 'placeholder' => 'ID Hardware','disabled'=>'']) !!}
                {!! $errors->first('id_hw', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-9 {{ $errors->has('uraian') ? ' has-error' : '' }}">
                {!! Form::label('uraian', 'Penjelasan (*)') !!}
                {!! Form::textarea('uraian', null, ['class'=>'form-control', 'placeholder' => 'uraian', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required','disabled'=>'']) !!}
                {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
              </div>
            </div>  
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-3 {{ $errors->has('jenis_solusi') ? ' has-error' : '' }}">
                {!! Form::label('jenis_solusi', 'Penanganan/Solusi (*)') !!}
                @if (empty($wo->jenis_solusi))
                  {!! Form::select('jenis_solusi', ['Technical Support' => 'Technical Support', 'System Development' => 'System Development'], null, ['class'=>'form-control select2']) !!}
                @else
                  {!! Form::select('jenis_solusi', ['Technical Support' => 'Technical Support', 'System Development' => 'System Development'], null, ['class'=>'form-control select2', 'disabled'=>'']) !!}
                @endif
                {!! $errors->first('jenis_solusi', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-9 {{ $errors->has('solusi') ? ' has-error' : '' }}">
                {!! Form::label('solusi', 'Solusi (*)') !!}
                {!! Form::textarea('solusi', null, ['class'=>'form-control', 'placeholder' => 'solusi', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
                {!! $errors->first('solusi', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
          </div>
          <!-- /.box -->
          <div class="box-footer">
            @if ($wo->statusapp === "DITERIMA")
            {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
            &nbsp;&nbsp;
            @elseif ($wo->statusapp === "SOLUSI")
              <a class="btn btn-default" href="{{ route('wos.approval') }}">Selesai</a>
               &nbsp;&nbsp;
            @else
            <a class="btn btn-default" href="{{ route('wos.approval') }}">Cancel</a>
              &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
            @endif
          </div>
        {!! Form::close() !!}
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
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('wos.dashboardapproval') }}",
      columns: [
        {data: null, name: null},
        {data: 'no_wo', name: 'no_wo'},
        {data: 'tgl_wo', name: 'tgl_wo'},
        {data: 'jenis_orders', name: 'jenis_orders'},
        {data: 'uraian', name: 'uraian'},
        {data: 'statusapp', name: 'statusapp'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection
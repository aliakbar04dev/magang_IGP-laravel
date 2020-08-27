@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Data Registrasi Karyawan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="glyphicon glyphicon-info-sign"></i> Reg karyawan</li>
      <li class="active"><i class="fa fa-files-o"></i> Data Registrasi Karyawan </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row" id="field_detail">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Data Reg Karyawan</h3>
            <hr>
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
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">         
            <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style='width: 1%;'>No</th>
                  <th style="width: 1%;text-align:center;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
                  <th style='width: 3%;'>No Reg</th>    
                   <th style='width: 2%;'>NPK LC</th>            
                  <th style='width: 8%;'>Nama</th>
                  <!-- <th style='width: 3%;'>NPK</th> -->
                  <th style='width: 4%;'>No. KTP</th>
                  <th style='width: 3%;'>Tanggal Masuk</th>
                  <!-- <th style='width: 3%;'>Tempat Lahir</th>
                  <th style='width: 3%;'>Tanggal Lahir</th> -->
                  <th style='width: 1%;'>Jenis Kelamin</th>                
                  
                </tr>
              </thead>
            </table>      
          </div>
          <!-- /.box-body -->
          <div class="box-footer">           
            <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (Oracle to PostgreSql)">
              <span class="glyphicon glyphicon-save"></span> Download
            </button>
          </div>
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
@endsection 
@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var tableDetail = $('#tblDetail').DataTable({
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
      ajax: "{{ route('hrdtregkars.listregkar') }}",
      columns: [
      {data: null, name: null, orderable: false, searchable: false},
      {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}, 
      {data: 'no_reg', name: 'no_reg'},
      {data: 'npk_lc', name: 'npk_lc'},
      {data: 'nama', name: 'nama'},
      // {data: 'npk', name: 'npk'},
      {data: 'no_ktp', name: 'no_ktp'},
      {data: 'tgl_masuk', name: 'tgl_masuk'},
      // {data: 'tmp_lahir', name: 'tmp_lahir'},
      // {data: 'tgl_lahir', name: 'tgl_lahir'},
      {data: 'kelamin', name: 'kelamin'}
      
      ]
    });

    $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('input[name="tahun"]').val();
      data.bulan = $('select[name="bulan"]').val();
    });

    tableDetail.ajax.reload();

    $('#display').click( function () {
      tableDetail.ajax.reload();
    }); 
  });
</script>
@endsection
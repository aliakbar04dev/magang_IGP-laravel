@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengambilan Alat Ukur
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('kalibrasi.index') }}"><i class="fa fa-files-o"></i>QA - Kalibrasi</a></li>
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

        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
            {!! Form::label('bulan', 'Bulan') !!}
            <div class="input-group">
              {!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
              {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}       
            </div>            
          </div>
          <div class="col-sm-2">
            {!! Form::label('tahun', 'Tahun') !!}
            <div class="input-group">
              {!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
              {!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
            </div>
          </div>        
          <div class="col-sm-3">
            {!! Form::label('status', 'Status') !!}
            <div class="input-group">
              {!! Form::select('status', array('ALL' => 'ALL', 'SUDAH' => 'SUDAH', 'BELUM' => 'BELUM'), 'ALL', ['class'=>'form-control']) !!}
              {!! $errors->first('status', '<p class="help-block">:message</p>') !!}      
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
              <th style="width: 5%;">No Order</th>
              <th style="width: 5%;">Tgl Order</th>
              <th style="width: 5%;">PT</th>
              <th style="width: 5%;">No Seri</th>
              <th style="width: 5%;">Nama Alat</th>
              <th style="width: 5%;">Tipe</th> 
              <th style="width: 5%;">Merk</th>
              <th style="width: 5%;">Status</th>
              <th style="width: 5%;">Tanggal Kembali</th>
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

@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("tahun").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){

    var url = '{{ route('kalibrasidet.dashboardkembali') }}';
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
      {data: 'no_order', name: 'no_order'},
      {data: 'tgl_order', name: 'tgl_order'},
      {data: 'pt', name: 'pt'},
      {data: 'no_seri', name: 'no_seri'},
      {data: 'nm_alat', name: 'nm_alat'},
      {data: 'nm_type', name: 'nm_type'},
      {data: 'nm_merk', name: 'nm_merk'}, 
      {data: 'status', name: 'status', orderable: 'false', searchable: 'false'},
      {data: 'tgl_kembali', name: 'tgl_kembali', orderable: 'false', searchable: 'false'},
      {data: 'action', name: 'action', orderable: 'false', searchable: 'false'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('input[name="tahun"]').val();
      data.bulan = $('select[name="bulan"]').val();
      data.status = $('select[name="status"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();
    
    $('#display').click( function () {
      tableMaster.ajax.reload();
    }); 
  });

  

  function savekembali(no_order, no_seri){
        var st_kembali  = '';
        var checkBox = document.getElementById(no_seri+"-cb-kembali");
        if (checkBox.checked == true){
          st_kembali = 'T';
        } else {
          st_kembali = 'F';
        }

        //startcode
        var info = "";
        var info2 = "";
        var info3 = "warning";
        
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('kalibrasidet.savekembali', ['param', 'param1', 'param2'])}}";
        url = url.replace('param',  window.btoa(no_order));
        url = url.replace('param1', window.btoa(no_seri));
        url = url.replace('param2', window.btoa(st_kembali));
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'GET',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
           if(data.status === 'OK'){
            info = "Pengambilan!";
            info2 = data.message;
            info3 = "success";
            swal(info, info2, info3);
            var table = $('#tblMaster').DataTable();
            table.ajax.reload();
          } else {
            info = "Cancelled";
            info2 = data.message;
            info3 = "error";
            swal(info, info2, info3);
          }
        }, error:function(){ 
          info = "System Error!";
          info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
          info3 = "error";
          swal(info, info2, info3);
        }
      });            
  }

</script>
@endsection
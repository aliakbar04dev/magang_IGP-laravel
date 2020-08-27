@extends('layouts.app')
@section('content')
<style>
.btn-group-sm > .btn, .btn-sm {
    padding: 3px 7px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pengajuan Tidak Prik
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Tidak Prik</li>
        <li class="active"><i class="fa fa-files-o"></i> Proses Ulang </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                 <h3 class="box-title">Proses Ulang Pengajuan Tidak Prik</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
               <div class="col-sm-2">
              {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
            </div>

            <div class="col-sm-2">
              {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
            </div>

             <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
             </div>

             <div class="col-sm-2">
                    {!! Form::label('Action', 'Action') !!}
                    <button id="btn-proses" type="button" class="form-control btn btn-warning" data-toggle="tooltip" data-placement="top" title="Proses Ulang">Proses Ulang</button>
             </div> 
            <div>
          </div>

          <br>   
             <div class="form-group" style="margin-top:50px"> 
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%" style="margin-top:60px;">
                <thead>
                  <tr>
                  <th style='width: 1%;'>No</th>
                  <th>No Pengajuan</th> 
                  <th>NPK</th>
                  <th>Nama</th>
                  <th>Tgl Tidak Prik</th>   
                  <th>Tgl Pengajuan</th>        
                  <th style='width: 100px;'>Action</th>   
                  </tr>
                </thead>
              </table> 
            </div>
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
@endsection

@section('scripts')
<script type="text/javascript">



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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'desc']],
      processing: true,
      serverSide: true,
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
    
      ajax: "{{ route('mobiles.dashboard_prosesulang') }}",
      columns: [
      {data: null, name: null, orderable: false, searchable: false},
      {data: 'no_lp', name: 'no_lp'},
      {data: 'npk', name: 'npk'},
      {data: 'nama', name: 'nama'},
      {data: 'tgllupa', name: 'tgllupa'},
      {data: 'tglpengajuan', name: 'tglpengajuan'},     
      {data: 'action', name: 'statuscetak', orderable: false, searchable: false},    
      ]
    });

 $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
        data.tgl_awal = $('input[name="tgl_awal"]').val();
        data.tgl_akhir = $('input[name="tgl_akhir"]').val();
  });

  $('#btn-display').click( function () {
      tableDetail.ajax.reload();
  }); 


  function refresh(){
  tableDetail.ajax.reload();
  }
  
  // $(document).ready(function()
  // {
    // $('#btn-proses').click( function () {
    //   var tgl_awal = $('input[name="tgl_awal"]').val();
    //   var tgl_akhir = $('input[name="tgl_akhir"]').val();
    //   var urlRedirect = "{{ route('mobiles.submit_prosesulang', ['param','param2']) }}";
    //   urlRedirect = urlRedirect.replace('param', tgl_awal);
    //   urlRedirect = urlRedirect.replace('param2', tgl_akhir);
    //   window.location.href = urlRedirect;
    // });
//  });


 $('#btn-proses').click( function () {
     
      var tgl_awal = $('input[name="tgl_awal"]').val();
      var tgl_akhir = $('input[name="tgl_akhir"]').val();
        
      var msg = 'Anda memproses ulang daftar Tidak Prik?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'grey',
        confirmButtonText: '<i class="fa fa-check-circle" ></i> Yes',
        cancelButtonText: '<i  class="fa fa-times" ></i> No',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
       
        var urlRedirect = "{{ route('mobiles.submit_prosesulang', ['param','param2']) }}";
        urlRedirect = urlRedirect.replace('param', tgl_awal);
        urlRedirect = urlRedirect.replace('param2', tgl_akhir);
        $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
           if(_response.indctr == '1'){
            console.log(_response)
            swal('Sukses', _response.msg, 'success')
            tableDetail.ajax.reload();
          } else {
            console.log(_response)
            swal('Gagal memproses', _response.msg, 'danger')
          }
        },
        error: function(){
          swal('Terjadi kesalahan', 'Mohon hubungi Admin!', 'info')
        }
      });
    }, function (dismiss) {    
      if (dismiss === 'cancel') {
      }
    })
  });
  
</script>
@endsection
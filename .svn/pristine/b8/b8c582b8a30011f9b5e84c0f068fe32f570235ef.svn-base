@extends('layouts.app')
@section('content')
<style>
  .btn-group-sm > .btn, .btn-sm {
    padding: 3px 7px;
  }
</style>

<!-- App_UN4 -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Approval
      <small>Izin Telat</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Approval Izin Telat</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <!-- Form Utama Perm. Uniform -->
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">List Approval</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row form-group">
              <div class="col-sm-12">
                <!-- <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
                  <option value="Menunggu diproses">Belum diproses</option>
                  <option value="Izin ditolak">Ditolak</option>
                  <option value="Izin diterima">Disetujui</option>
                  <option value="">Semua</option>
                </select> -->
                <input class="form-control" placeholder="Cari nama..." style="float:left;width:150px;margin: 0px 12px 10px 0px;" type="text" id="table-text-nama">
                <input class="form-control" placeholder="Cari npk..." style="float:left;width:100px;margin: 0px 12px 10px 0px;" type="text" id="table-text-npk">
                <input class="form-control" placeholder="Cari nomor IK..." style="float:left;width:150px;margin: 0px 0px 10px 0px;" type="text" id="table-text-noik">
                <button class="btn btn-success" style="margin-left:10px" onclick="refreshList()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                <table id="dtApprovalIK" class="table-bordered table-striped" style="width:100%;">
                  <thead>
                    <tr>
                      <th style="width:100px;">Action</th>
                      <th>Nama</th>
                      <th>Status</th>
                      <th>Tgl Izin</th>

                      <th>Jam In</th>
                      <th>Alasan</th>
                      <th>No. IK</th>

                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- ./box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  <!-- Form Utama Perm. Uniform -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection


@section('scripts')
<script type="text/javascript">
  var table = $('#dtApprovalIK').DataTable({
    responsive: {
      details: {
        type: 'column',
        target: 2
      }
    },
    columnDefs: [ {
      className: 'control',
      orderable: false,
      targets:  []
    } ],
    "order": [[ 2, "desc" ],[3, "desc"]],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    // serverSide: true,
    searching: true,
    ajax: {
      url: '{{ url("/hronline/mobile/izinterlambat/approval/data") }}'
    },
    "deferRender": true,
    "pageLength": 10,
    columns: [
      // {data: 'DT_Row_Index', name: 'DT_Row_Index'},
      {data: 'action', name: 'action', orderable:false},
      {data: 'nama', name: 'v_mas_karyawan.nama',orderable:false},
      {data: 'status', name: 'itelatpengajuan.status',orderable:false},
      {data: 'tglijin', name: 'itelatpengajuan.tglpengajuan',orderable:false},
      {data: 'jam_masuk', name: 'itelatpengajuan.jam_masuk',orderable:false},
      {data: 'alasan_it', name: 'itelatpengajuan.alasan_it',orderable:false},
      {data: 'no_ik', name: 'itelatpengajuan.no_ik'},
    ],
    destroy: true,
    dom: '<"top">rt<"bottom"pi>',
    // initComplete: function(){
    //   $("div.toolbar")
    //      .html(

    //         );        
    // },
  });

  $('#table-dropdown').ready(function(){
    table.column(2).search('Menunggu diproses').draw();   
  });  

  // $('#table-text').ready(function(){
  //     table.column(1).search("").draw();   
  // });   
  $('#table-dropdown').on('change', function(){
    refreshList();
    table.column(2).search(this.value).draw();   
  });  
  $('#table-text-nama').on('keyup', function(){
    refreshList();
    table.column(1).search(this.value).draw();   
  });  
  $('#table-text-noik').on('keyup', function(){
    refreshList();
    table.column(6).search(this.value).draw();   
  });
  $('#table-text-npk').on('keyup', function(){
    refreshList();
    table.column(0).search(this.value).draw();   
  });    

  function refreshList(){
    table.ajax.reload();
  }
    
  function approve(ths) {
    var no_value = document.getElementById('no_ik_approve'+ths).value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var urlappr = "{{ route('mobiles.itelatappr') }}";
    $.ajax({
      url      : urlappr,
      type     : 'POST',
      dataType : 'json',
      data     : {
        no_ik   : no_value,
        _token  : token,
      },
      success: function(_response){
        if(_response.indctr == '1'){
          swal('Sukses', _response.msg,'success')
          $('.modal').modal('hide');
          refreshList();
        } else if(_response.indctr == '0'){
          console.log(_response)
          swal('Error', _response.msg, 'error')
        }
      },
      error: function(){
        swal(
          'Terjadi kesalahan',
          'Segera hubungi Admin!',
          'error'
          )
      }
    });  
  }

  function decline(ths) {
    var no_value = document.getElementById('no_ik_decline'+ths).value.trim();
    var token = document.getElementsByName('_token')[0].value.trim();
    var urldcln = "{{ route('mobiles.itelatdcln') }}";
    $.ajax({
      url      : urldcln,
      type     : 'POST',
      dataType : 'json',
      data     : {
        no_ik   : no_value,
        _token  : token,
      },
      success: function(_response){
        if(_response.indctr == '1'){
          swal('Sukses', 'Pengajuan izin terlambat berhasil ditolak!','success'
            )
          $('.modal').modal('hide');
          refreshList();
        } else if(_response.indctr == '0'){
          swal('Terjadi kesalahan', 'Segera hubungi Admin!', 'error'
            )
        }
      },
      error: function(){
        swal(
          'Terjadi kesalahan',
          'Segera hubungi Admin!',
          'error'
          )
      }
    });
  }
  </script>
  @endsection
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
        Daftar Approval Tidak Prik
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Tidak Prik</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Approval </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                 <h3 class="box-title">Daftar Approval Tidak Prik</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div>
               <!--  <table>
                  <td>
                   <div id="filter_status_apr" class="dataTables_length" style="width:180px;margin-left:10px;">
                    <select style="margin-bottom: 8px;" size="1" name="filter_status_apr" aria-controls="filter_status_apr"     class="form-control select2" style="width: 150px;">
                        <option value="ALL" selected="selected">ALL</option>
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                        <option value="3">Belum Approval</option>
                      </select>
                     </div> 
                    </td>

                  <td style="width:3%"> </td>
                  <td> <button class="btn btn-success" onclick="refresh()"><i class="fa fa-btn fa-refresh"> </i></button>
                  </td>
            </table> -->
          </div>
          <br>    
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                  <!-- <th style='width: 1%;'>No</th> -->
                  <th style='width: 100px;'>Action</th>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>No Pengajuan</th> 
                  <th>NPK</th>   
                  <th>Tgl Tidak Prik</th>        
                  <th>Alasan</th>  
                  <th>Tgl Pengajuan</th>         
                  </tr>
                </thead>
              </table> 
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
    responsive: {
    details: {
    type: 'column',
    target: 2
    }
  },
      "columnDefs": [{
      "searchable": false,
      "orderable": false,
      //  "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
   //   responsive: true,
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
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      ajax: "{{ route('mobiles.dashboardapprovallupaprik') }}",
      columns: [
     /* {data: null, name: null, orderable: false, searchable: false},*/
      {data: 'action', name: 'statuscetak', orderable: false, searchable: false}, 
      {data: 'nama', name: 'nama'},
      {data: 'status', name: 'status'},
      {data: 'no_lp', name: 'no_lp'},
      {data: 'npk', name: 'npk'},
      {data: 'tgllupa', name: 'tgllupa'},
      {data: 'alasanlupa', name: 'alasanlupa'},
      {data: 'tglpengajuan', name: 'tglpengajuan'},   
      ]
    });

  function refresh(){
  tableDetail.ajax.reload();
  }
  
  $(document).ready(function()
  {
    $(function() {
      $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
        data.status = $('select[name="filter_status_apr"]').val();
      });
      $('select[name="filter_status_apr"]').change(function() {
        tableDetail.ajax.reload();
      });
    });
  });


  function konfirmasitolak(id)
  {
      var msg = 'Anda yakin menolak pengajuan Tidak Prik dengan nomer '+id+'?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
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

       var urlRedirect = "{{route('mobiles.tolakapprovallupaprik', 'param')}}";    
          urlRedirect = urlRedirect.replace('param', id);

          $.ajax({
          url      : urlRedirect,
          type     : 'GET',
          dataType : 'json',
          success: function(_response){
         if(_response.indctr == '1'){
            swal('Sukses', 'Pengajuan Tidak Prik <b>'+id+'</b> berhasil ditolak!','success'
            )
            $('.modal').modal('hide');
            tableDetail.ajax.reload();
          } else if(_response.indctr == '0'){
            console.log(_response)
            swal('Terjadi kesalahan', 'Segera hubungi Admin!', 'info'
            )
          }
        },
        error: function(){
          swal(
            'Terjadi kesalahan',
            'Segera hubungi Admin!',
            'info'
            )
        }
        });
      }, function (dismiss) {     
        if (dismiss === 'cancel') {
        }
      })
  }

  function konfirmasisetuju(id)
  {
    var msg = 'Anda yakin menyetujui pengajuan Tidak Prik dengan nomer '+id+'?';
    var txt = '';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
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
      var urlRedirect = "{{route('mobiles.setujuapprovallupaprik', 'param')}}";    
      urlRedirect = urlRedirect.replace('param', id);
      $.ajax({
        url      : urlRedirect,
        type     : 'GET',
        dataType : 'json',
        success: function(_response){
          if(_response.indctr == '1'){
            console.log(_response)
            swal('Sukses', _response.msg, 'success')
            $('.modal').modal('hide');
            tableDetail.ajax.reload();
          } else {
            console.log(_response)
            swal('Gagal menyetujui', _response.msg, 'danger')
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
  }
</script>
@endsection
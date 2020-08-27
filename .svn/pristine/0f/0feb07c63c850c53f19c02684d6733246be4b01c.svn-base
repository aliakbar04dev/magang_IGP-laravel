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
        List Ijin Meninggalkan Pekerjaan (IMP) hari ini
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> IMP</li>
        <li class="active"><i class="fa fa-files-o"></i> List Ijin Meninggalkan Pekerjaan (IMP) hari ini </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                 <h3 class="box-title">Daftar List IMP</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div>
                <table>
            </table>
          </div>
          <br>    
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                  <th style='width: 1%;'>No</th>
                  <th>NPK</th>
                  <th>NO IMP</th>
                  <th>NO-POL</th>
                  <th>IJIN ATASAN</th> 
                  <th>ACTION</th>         
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
      "targets": 0,
      //  "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
     // responsive: true,
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // // "ordering": true,
      // "info": true,
      // // "autoWidth": false,
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('mobiles.dashboard') }}",
      columns: [
      {data: null, name: null, orderable: false, searchable: false},
      // {data: 'action', name: 'statuscetak', orderable: false, searchable: false},
      // {data: null, name: null},
      {data: 'npk', name: 'npk'}, 
       {data: 'noimp', name: 'noimp'},
      {data: 'nopol', name: 'nopol'},
      {data: 'status', name: 'status'},
      {data: 'action', name: 'action'}
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
      var msg = 'Anda yakin menolak pengajuan lupa prik dengan nomer '+id+'?';
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

       var urlRedirect = "/hr/mobile/approvallupaprik/"+id+"/tolak/";     
       window.location.href = urlRedirect;
      // window.open(urlRedirect);
       //window.location.reload(urlRedirect);
        swal({
              position: 'top-end',
              type: 'success',
              title: 'No. Pengajuan Lupa Prik <b>'+id+'</b> Berhasil Ditolak! ',
              showConfirmButton: false,
              timer: 2000
            })
        table.ajax.reload();
      }, function (dismiss) {     
        if (dismiss === 'cancel') {
        }
      })
  }

  function konfirmasisetuju(id)
   {
      var msg = 'Anda yakin menyetujui pengajuan lupa prik dengan nomer '+id+'?';
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
       var urlRedirect = "/hr/mobile/approvallupaprik/"+id+"/setuju/";
       window.location.href = urlRedirect;
       //window.open(urlRedirect);
        swal({
              position: 'top-end',
              type: 'success',
              title: 'No. Pengajuan Lupa Prik <b>'+id+'</b> Berhasil Disetujui! ',
              showConfirmButton: false,
              timer: 2000
            })
        table.ajax.reload();
      }, function (dismiss) {    
        if (dismiss === 'cancel') {
        }
      })
  }
</script>
@endsection
@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Work Order
        <small>Daftar Work Order</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Work Order</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['it-wo-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('wos.create') }}">
                    <span class="fa fa-plus"></span> Add Daftar Work Order
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 10%;">No. WO</th>
			                <th style="width: 5%;">Tgl WO</th>
                      <th style="width: 20%;">Permintaan/Problem</th>
			                <th style="width: 20%;">Penjelasan</th>
                      <th style="width: 5%;">Status</th>
                      <th style="width: 5%;">Action</th>
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.wos') }}",
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

    // $(function() {
    //   $('\
    //     <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
    //       <label>Kode Site\
    //       <select size="1" name="filter_status" aria-controls="filter_status" \
    //         class="form-control select2" style="width: 110px;">\
    //           <option value="ALL" selected="selected">ALL</option>\
    //           <option value="IGPJ">JAKARTA</option>\
    //           <option value="IGPK">KARAWANG</option




        //         </select>\
    //       </label>\
    //     </div>\
    //     <div id="filter_status_apr" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
    //       <label>Approve\
    //       <select size="1" name="filter_status_apr" aria-controls="filter_status_apr" \
    //         class="form-control select2" style="width: 110px;">\
    //           <option value="ALL" selected="selected">ALL</option>\
    //           <option value="B">Belum</option>\
    //           <option value="F">Foreman</option>\
    //           <option value="S">Section</option>\
    //         </select>\
    //       </label>\
    //     </div>\
    //   ').insertAfter('.dataTables_length');

    //   $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    //     data.status = $('select[name="filter_status"]').val();
    //     data.status_apr = $('select[name="filter_status_apr"]').val();
    //   });

    //   $('select[name="filter_status"]').change(function() {
    //     tableMaster.ajax.reload();
    //   });

    //   $('select[name="filter_status_apr"]').change(function() {
    //     tableMaster.ajax.reload();
    //   });
    // });
  });

  function userselesai(no_wo, statusapp)
  {
    var msg = 'Anda yakin Selesaikan No. WO ' + no_wo;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('wos.userselesai', ['param','param2'] ) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
      urlRedirect = urlRedirect.replace('param2', window.btoa(statusapp));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  }

  function printwo(no_wo)
  {
    var msg = 'Anda yakin akan mencetak No. WO ' + no_wo;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('wos.printwo', ['param'] ) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  }
</script>
@endsection

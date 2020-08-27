@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PFC
        <small>Process Flow Chart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> Process Flow Chart</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              <div class="box-header">
                <p> 
                  @permission(['eng-pfc-create'])
                  <a class="btn btn-primary" href="{{ route('engttpfc1s.create') }}">
                    <span class="fa fa-plus"></span> Add PFC
                  </a>
                  @endpermission
                </p>
              </div>
              <!-- /.box-header -->
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 15%;">Customer</th>
			                <th style="width: 20%;">Model Name</th>
                      <th>Line</th>
                      <th style="width: 15%;">Doc Type</th>
			                <th style="width: 10%;">Status</th>
                      <th>Prepared</th>
                      <th>Checked</th>
                      <th>Approved</th>
                      <th>Registrasi Doc</th>
                      <th>Revision</th>
                      <th>Tgl Revisi</th>
                      <th>Ket. Revisi</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
			                <th style="width: 10%;">Action</th>
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

  function approve(id, info)
  {
    var msg = "Anda yakin " + info + "?";
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
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('engttpfc1s.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          id             : id
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var table = $('#tblMaster').DataTable();
            table.ajax.reload(null, false);
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
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
  
  function printPfc(id)
  {
    swal({
      title: "Internal atau Eksternal?",
      text: "",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="glyphicon glyphicon-resize-small"></i> Internal',
      cancelButtonText: '<i class="glyphicon glyphicon-resize-full"></i> Eksternal',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = '{{ route('engttpfc1s.print', ['param','param2']) }}';
      urlRedirect = urlRedirect.replace('param2', window.btoa("IN"));
      urlRedirect = urlRedirect.replace('param', id);
      window.open(urlRedirect, '_blank');
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        var urlRedirect = '{{ route('engttpfc1s.print', ['param','param2']) }}';
        urlRedirect = urlRedirect.replace('param2', window.btoa("OUT"));
        urlRedirect = urlRedirect.replace('param', id);
        window.open(urlRedirect, '_blank');
      }
    })
  }

  $(document).ready(function(){

    var url = '{{ route('dashboard.engttpfc1s') }}';
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
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'kd_cust', name: 'kd_cust'},
        {data: 'kd_model', name: 'kd_model'},
        {data: 'kd_line', name: 'kd_line'},
        {data: 'reg_doc_type', name: 'reg_doc_type'},
        {data: 'st_pfc', name: 'st_pfc'},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'checkby', name: 'checkby', className: "none"},
        {data: 'approvby', name: 'approvby', className: "none"},
        {data: 'reg_no_doc', name: 'reg_no_doc', className: "none"},
        {data: 'reg_no_rev', name: 'reg_no_rev', className: "none"},
        {data: 'reg_tgl_rev', name: 'reg_tgl_rev', className: "none"},
        {data: 'reg_ket_rev', name: 'reg_ket_rev', className: "none"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });
  });
</script>
@endsection
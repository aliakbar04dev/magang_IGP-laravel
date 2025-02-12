@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Register Permintaan Pembelian
        {{-- <small>Daftar Register PP</small> --}}
        <small>Hanya untuk kondisi <b>LUAR BIASA & URGENT</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PP</li>
        <li class="active"><i class="fa fa-files-o"></i> Register PP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['pp-reg-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('ppregs.create') }}">
                    <span class="fa fa-plus"></span> Add Register PP
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
			                <th style="width: 15%;">No. Registrasi</th>
			                <th style="width: 5%;">Tgl</th>
			                <th style="width: 15%;">Pemakai</th>
			                <th>Untuk</th>
			                <th style="width: 15%;">Status Approve</th>
                      <th>Alasan</th>
                      <th>Dept. Pembuat</th>
                      <th>Supplier</th>
                      <th>Email Supplier</th>
                      <th>No. IA/EA</th>
                      <th>No. Rev IA/EA</th>
                      <th>No. Urut IA/EA</th>
                      <th>Desc. IA/EA</th>
                      <th>Approve Div Head</th>
                      <th>Approve Purchasing</th>
                      <th>Reject By</th>
                      <th>Keterangan</th>
                      <th style="width: 10%;">No. PP</th>
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

  function approveRegPp(no_reg, status)
  {
    var msg = 'Anda yakin APPROVE No. Register PP ' + no_reg;
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
      var urlRedirect = "{{ route('ppregs.approve', ['param', 'param2']) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_reg));
      urlRedirect = urlRedirect.replace('param2', window.btoa(status));
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

  function rejectRegPp(no_reg)
  {
    var msg = 'Anda yakin REJECT No. Register PP ' + no_reg;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, reject it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Reject',
        input: 'textarea',
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              if(value.length > 200) {
                reject('Keterangan Reject Max 200 Karakter!')
              } else {
                resolve()
              }
            } else {
              reject('Keterangan Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var urlRedirect = "{{ route('ppregs.reject', ['param', 'param2']) }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_reg));
        urlRedirect = urlRedirect.replace('param2', window.btoa(result));
        window.location.href = urlRedirect;
      })
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
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.ppregs') }}",
      columns: [
      	{data: null, name: null},
        {data: 'no_reg', name: 'no_reg'},
        {data: 'tgl_reg', name: 'tgl_reg'},
        {data: 'pemakai', name: 'pemakai'},
        {data: 'untuk', name: 'untuk'},
        {data: 'status_approve', name: 'status_approve', className: "dt-center", orderable: false, searchable: false},
        {data: 'alasan', name: 'alasan', className: "none"},
        {data: 'kd_dept_pembuat', name: 'kd_dept_pembuat', className: "none"},
        {data: 'supplier', name: 'supplier', className: "none"},
        {data: 'email_supp', name: 'email_supp', className: "none"},
        {data: 'no_ia_ea', name: 'no_ia_ea', className: "none"},
        {data: 'no_ia_ea_revisi', name: 'no_ia_ea_revisi', className: "none"},
        {data: 'no_ia_ea_urut', name: 'no_ia_ea_urut', className: "none"},
        {data: 'desc_ia', name: 'desc_ia', className: "none", orderable: false, searchable: false},
        {data: 'approve_div', name: 'approve_div', className: "none"},
        {data: 'approve_prc', name: 'approve_prc', className: "none"},
        {data: 'reject_by', name: 'reject_by', className: "none"},
        {data: 'keterangan', name: 'keterangan', className: "none"},
        {data: 'no_pp', name: 'no_pp'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status Approve\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 155px;">\
              <option value="ALL" selected="selected">All</option>\
              <option value="F">Belum</option>\
              <option value="D">Div Head</option>\
              <option value="P">Purchasing</option>\
              <option value="R">Reject</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.status = $('select[name="filter_status"]').val();
      });

      $('select[name="filter_status"]').change(function() {
        tableMaster.ajax.reload();
      });
    });
  });
</script>
@endsection
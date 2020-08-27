@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        FCM
        <small>Form Characteristic Matrix</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> Form Characteristic Matrix</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
                      <th style="width: 20%;">Reg. Doc</th>
                      <th style="width: 10%;">No. OP</th>
                      <th>M/C Code # Type # Name</th>
			                <th style="width: 10%;">Action</th>
                      <th>Customer</th>
                      <th>Model Name</th>
                      <th>Line</th>
                      <th>Doc Type</th>
                      <th>Status</th>
                      <th>Revision</th>
                      <th>Tgl Revisi</th>
                      <th>Ket. Revisi</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
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

    var url = '{{ route('dashboard.engtfcm1s') }}';
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
      "order": [[11, 'desc'], [1, 'desc'], [2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'reg_no_doc', name: 'reg_no_doc'},
        {data: 'no_op', name: 'no_op', className: "dt-center"},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'action', name: 'action', orderable: false, searchable: false}, 
        {data: 'kd_cust', name: 'kd_cust', className: "none"},
        {data: 'kd_model', name: 'kd_model', className: "none"},
        {data: 'kd_line', name: 'kd_line', className: "none"},
        {data: 'reg_doc_type', name: 'reg_doc_type', className: "none"},
        {data: 'st_pfc', name: 'st_pfc', className: "none"},
        {data: 'reg_no_rev', name: 'reg_no_rev', className: "none"},
        {data: 'reg_tgl_rev', name: 'reg_tgl_rev', className: "none"},
        {data: 'reg_ket_rev', name: 'reg_ket_rev', className: "none"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
	    ]
    });
  });
</script>
@endsection
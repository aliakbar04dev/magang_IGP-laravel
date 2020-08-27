@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mesin
        <small>Daftar Mesin</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li class="active"><i class="fa fa-files-o"></i> Mesin</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission('eng-msteng-create')
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('engtmmesins.create') }}">
                    <span class="fa fa-plus"></span> Add Mesin
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
                      <th>Kode Mesin</th>
                      <th>Nama Mesin</th>
                      <th>Make</th>
                      <th>type</th>
                      <th>Proses</th>
                      <th>tahun Buat</th>
                      <th>Asset ENG</th>
                      <th>Asset ACC</th>
                      <th>Currency</th>
                      <th>Harga</th>
                      <th>Line</th>
                      <th>Status</th>
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
    var url = "{{ route('dashboard.engtmmesins') }}";
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'nm_mesin', name: 'nm_mesin'},
        {data: 'nm_maker', name: 'nm_maker'},
        {data: 'mdl_type', name: 'mdl_type'},
        {data: 'nm_proses', name: 'nm_proses'},
        {data: 'thn_buat', name: 'thn_buat'},
        {data: 'no_asset', name: 'no_asset'},
        {data: 'no_asset_acc', name: 'no_asset_acc'},
        {data: 'curr_perolehan', name: 'curr_perolehan'},
        {data: 'hrg_perolehan', name: 'hrg_perolehan'},
        {data: 'nm_line', name: 'nm_line'},
        {data: 'st_aktif', name: 'st_aktif'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });
  });
</script>
@endsection
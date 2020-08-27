@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar User
        <small>Daftar User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-gear"></i> Daftar User</li>
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
			            	<th style="width: 5%;">No</th>
			                <th>Nama</th>
			                <th style="width: 10%;">Username</th>
			                <th style="width: 20%;">Email</th>
			                <th>Role</th>
			                <th style="width: 1%;">Active</th>
                      <th style="width: 1%;">Online</th>
                      <th>Init</th>
                      <th>No. HP</th>
                      <th>ID Telegram</th>
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('list.users') }}",
      columns: [
      	{data: null, name: null},
        {data: 'name', name: 'name'},
        {data: 'username', name: 'username'},
        {data: 'email', name: 'email'},
        {data: 'rolename', name: 'rolename', orderable: false},
        {data: 'status_active', name: 'status_active', className: "dt-center", orderable: false, searchable: false},
        {data: 'online', name: 'online', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'init_supp', name: 'init_supp', className: "none"},
        {data: 'no_hp', name: 'no_hp', className: "none"},
        {data: 'telegram_id', name: 'telegram_id', className: "none"}
	  ]
    });

    $(function() {
  	  $('\
  	    <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
  	      <label>Aktif \
  	      <select size="1" name="filter_status" aria-controls="filter_status" \
  	        class="form-control select2" style="width: 100px;">\
  	          <option value="all" selected="selected">Semua</option>\
  	          <option value="T">Ya</option>\
  	          <option value="F">Tidak</option>\
  	        </select>\
  	      </label>\
  	    </div>\
        <div id="filter_status_online" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status Online \
          <select size="1" name="filter_status_online" aria-controls="filter_status_online" \
            class="form-control select2" style="width: 100px;">\
              <option value="all" selected="selected">Semua</option>\
              <option value="O">Online</option>\
              <option value="F">Offline</option>\
            </select>\
          </label>\
        </div>\
  	  ').insertAfter('.dataTables_length');

  	  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
  	    data.status = $('select[name="filter_status"]').val();
        data.status_online = $('select[name="filter_status_online"]').val();
  	  });

  	  $('select[name="filter_status"]').change(function() {
  	    tableMaster.ajax.reload();
  	  });

      $('select[name="filter_status_online"]').change(function() {
        tableMaster.ajax.reload();
      });
	  });
  });
</script>
@endsection
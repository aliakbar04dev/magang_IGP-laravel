@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring Logs
        <small>Monitoring Logs</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-lock"></i> Monitoring Logs</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Monitoring Logs</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-4">
              <label>Tanggal</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="filter_status_tgl">
              </div>
              <!-- /.input group -->
            </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblstatususers', 'Status User') !!}
  		      	<select name="filter_status_user" aria-controls="filter_status" class="form-control select2">
	              <option value="ALL" selected="selected">Semua</option>
	              <option value="K">Karyawan</option>
	              <option value="S">Supplier</option>
  	          </select>
    		    </div>
    		  </div>
    		  <!-- /.form-group -->
    		  <div class="form-group">
    		    <div class="col-sm-4">
  		      	{!! Form::label('lblusername', 'Username') !!}
  		      	<select name="filter_status_username" aria-controls="filter_status" class="form-control select2">
              	<option value="ALL" selected="selected">Semua</option>
  			        @foreach (Auth::user()::select(['id', 'name', 'username'])->whereNotIn('username', ['ian'])->orderBy('name')->get() as $user)
		            	<option value={{ $user->username }}>{{ $user->name.' - '.$user->username }}</option>
  		          @endforeach
  		       	</select>
    		    </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', ' ') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
    		  </div>
    		  <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">Username</th>
                <th style="width: 20%;">Nama</th>
                <th>Keterangan</th>
                <th style="width: 15%;">IP</th>
                <th style="width: 10%;">Tanggal</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  //Date range picker
  $('#filter_status_tgl').daterangepicker(
    {
      startDate: moment().startOf('month'), 
      endDate: moment().endOf('month'),
      locale: {
        format: 'DD/MM/YYYY'
      }
    }
  );
  
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
      "order": [[5, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('logusers.users') }}",
      columns: [
        {data: null, name: null},
        {data: 'username', name: 'username'},
        {data: 'name', name: 'name'},
        {data: 'keterangan', name: 'keterangan'},
        {data: 'ip', name: 'ip'},
        {data: 'tgl', name: 'tgl'}
      ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
	    data.awal = $('#filter_status_tgl').data('daterangepicker').startDate.format('DD-MM-YYYY');
      data.akhir = $('#filter_status_tgl').data('daterangepicker').endDate.format('DD-MM-YYYY');
	    data.status_user = $('select[name="filter_status_user"]').val();
	    data.status_username = $('select[name="filter_status_username"]').val();
	  });

    $('#display').click( function () {
		  tableMaster.ajax.reload();
    });

    $('#display').click();
  });
</script>
@endsection
@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        KPI Division
        <small>Daftar KPI Division <b>{{ Auth::user()->masKaryawan()->desc_div }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> HR - KPI Division</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar KPI Division</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['hrd-kpi-create'])
              <div class="box-header">
                <p> 
                  <button id="btn-add" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Add KPI Division</button>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 5%;">Year</th>
			                <th>Name</th>
                      <th>Superior</th>
                      <th style="width: 20%;">Status</th>
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

  $("#btn-add").click(function(){
    var year_now = '{{ \Carbon\Carbon::now()->format('Y') }}';
    var year_next = '{{ \Carbon\Carbon::now()->format('Y')+1 }}';
    var msg = year_now + ' / ' + year_next + '?';
    var txt = "pilih tahun activity plan";
    swal({
      title: msg,
      text: txt,
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="glyphicon glyphicon-arrow-left"></i> ' + year_now,
      cancelButtonText: '<i class="glyphicon glyphicon-arrow-right"></i> ' + year_next,
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('hrdtkpis.buat', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(year_now));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      if (dismiss === 'cancel') {
        var urlRedirect = "{{ route('hrdtkpis.buat', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(year_next));
        window.location.href = urlRedirect;
      }
    })
  });

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
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.hrdtkpis') }}",
      columns: [
      	{data: null, name: null},
        {data: 'tahun', name: 'tahun'},
        {data: 'npk', name: 'npk'},
        {data: 'npk_atasan', name: 'npk_atasan'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 250px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="DRAFT">DRAFT</option>\
              <option value="SUBMIT">SUBMIT</option>\
              <option value="REJECT">REJECT</option>\
              <option value="APPROVE SUPERIOR">APPROVE SUPERIOR</option>\
              <option value="APPROVE HRD">APPROVE HRD</option>\
              <option value="SUBMIT REVIEW Q1">SUBMIT REVIEW Q1</option>\
              <option value="REJECT REVIEW Q1">REJECT REVIEW Q1</option>\
              <option value="APPROVE REVIEW Q1">APPROVE REVIEW Q1</option>\
              <option value="SUBMIT REVIEW Q2">SUBMIT REVIEW Q2</option>\
              <option value="REJECT REVIEW Q2">REJECT REVIEW Q2</option>\
              <option value="APPROVE REVIEW Q2">APPROVE REVIEW Q2</option>\
              <option value="SUBMIT REVIEW Q3">SUBMIT REVIEW Q3</option>\
              <option value="REJECT REVIEW Q3">REJECT REVIEW Q3</option>\
              <option value="APPROVE REVIEW Q3">APPROVE REVIEW Q3</option>\
              <option value="SUBMIT REVIEW Q4">SUBMIT REVIEW Q4</option>\
              <option value="REJECT REVIEW Q4">REJECT REVIEW Q4</option>\
              <option value="APPROVE REVIEW Q4">APPROVE REVIEW Q4</option>\
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
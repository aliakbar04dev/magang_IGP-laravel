@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DEPR
        <small>Delivery Problem Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> E-PPC - Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Delivery Problem Report</li>
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
			                <th style="width: 15%;">No. DEPR</th>
			                <th style="width: 5%;">Tgl</th>
                      <th style="width: 25%;">Supplier</th>
			                <th style="width: 15%;">Status Problem</th>
			                <th>Problem Tittle</th>
                      <th>Site</th>
                      <th>Problem Others</th>
                      <th>Line Stop</th>
                      <th>Jumlah Menit</th>
                      <th>Keterangan Problem</th>
                      <th>Problem Standard</th>
                      <th>Problem Actual</th>
                      <th>Submit to Portal</th>
                      <th>No. PICA</th>
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

  function createPica(no_dpr)
  {
    var msg = 'Anda yakin membuat PICA DEPR untuk data ini?';
    var txt = 'No. DEPR: ' + no_dpr;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, create it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('ppctdprpicas.edit', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
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

  $(document).ready(function(){

    var url = '{{ route('dashboardall.ppctdprs') }}';
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
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'no_dpr', name: 'no_dpr'},
        {data: 'tgl_dpr', name: 'tgl_dpr'},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'problem_st', name: 'problem_st'},
        {data: 'problem_title', name: 'problem_title'},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'problem_oth', name: 'problem_oth', className: "none"},
        {data: 'st_ls', name: 'st_ls', className: "none"},
        {data: 'jml_ls_menit', name: 'jml_ls_menit', className: "none"},
        {data: 'problem_ket', name: 'problem_ket', className: "none"},
        {data: 'problem_std', name: 'problem_std', className: "none"},
        {data: 'problem_act', name: 'problem_act', className: "none"},
        {data: 'dh_aprov', name: 'dh_aprov', className: "none", orderable: false, searchable: false},
        {data: 'no_id', name: 'no_id', className: "none", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status DEPR\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 150px;">\
              <option value="ALL" selected="selected">All</option>\
              <option value="5">Belum PICA</option>\
              <option value="7">Sudah PICA</option>\
              <option value="8">Close PRC</option>\
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
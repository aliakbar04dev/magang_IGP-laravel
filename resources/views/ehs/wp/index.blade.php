@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Ijin Kerja
        <small>Daftar Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Ijin Kerja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['ehs-wp-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('ehstwp1s.create') }}">
                    <span class="fa fa-plus"></span> Add Ijin Kerja
                  </a>
                  &nbsp;&nbsp;
                  <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download User Guide" href="{{ route('ehstwp1s.userguide') }}"><span class="fa fa-book"></span> Download User Guide</a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 8%;">No. WP</th>
			                <th style="width: 5%;">Tgl WP</th>
                      <th style="width: 8%;">No. PP</th>
                      <th>Site</th>
                      <th>Status PO</th>
                      <th>No. PO</th>
                      <th style="width: 20%;">Nama Proyek</th>
			                <th>No. Revisi</th>
                      <th>Lokasi Proyek</th>
			                <th>PIC</th>
                      <th>Tgl Pelaksanaan</th>
                      <th>Perpanjangan</th>
                      <th>Jam</th>
                      <th>Kategori Pekerjaan</th>
                      <th>Keterangan</th>
                      <th>Alat yg digunakan</th>
                      <th>Jenis Pekerjaan</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th>Submitted</th>
                      <th>Tgl Expired</th>
                      <th>Tgl Close</th>
                      <th>Pic Close</th>
                      <th>Scan IN Security</th>
                      <th>Scan OUT Security</th>
                      <th style="width: 12%;">Status</th>
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

  function revisiIjinKerja(no_wp, no_rev, id)
  {
    var no_wp = window.atob(no_wp);
    var no_rev = window.atob(no_rev);
    var msg = 'Anda yakin membuat Revisi data ini?';
    var txt = 'No. WP: ' + no_wp + ', No. Rev: ' + no_rev;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, revisi it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('ehstwp1s.revisi', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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

  function perpanjangIjinKerja(no_wp, no_rev, id)
  {
    var no_wp = window.atob(no_wp);
    var no_rev = window.atob(no_rev);
    var msg = 'Anda yakin membuat Perpanjangan Ijin Kerja ini?';
    var txt = 'No. WP: ' + no_wp + ', No. Rev: ' + no_rev;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
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
      var urlRedirect = "{{ route('ehstwp1s.perpanjang', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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

  function copyIjinKerja(no_wp, no_rev, id)
  {
    var no_wp = window.atob(no_wp);
    var no_rev = window.atob(no_rev);
    var msg = 'Anda yakin membuat Copy Ijin Kerja ini?';
    var txt = 'No. WP: ' + no_wp + ', No. Rev: ' + no_rev;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
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
      var urlRedirect = "{{ route('ehstwp1s.copy', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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
      ajax: "{{ route('dashboard.ehstwp1s') }}",
      columns: [
      	{data: null, name: null},
        {data: 'no_wp', name: 'no_wp'},
        {data: 'tgl_wp', name: 'tgl_wp'},
        {data: 'no_pp', name: 'no_pp'},
        {data: 'kd_site', name: 'kd_site', className: "none", orderable: false, searchable: false},
        {data: 'status_po', name: 'status_po', className: "none", orderable: false, searchable: false},
        {data: 'no_po', name: 'no_po', className: "none"},
        {data: 'nm_proyek', name: 'nm_proyek'},
        {data: 'no_rev', name: 'no_rev', className: "none"},
        {data: 'lok_proyek', name: 'lok_proyek', className: "none"},
        {data: 'pic_pp', name: 'pic_pp', className: "none"},
        {data: 'tgl_laksana1', name: 'tgl_laksana1', className: "none"},
        {data: 'no_perpanjang', name: 'no_perpanjang', className: "none"},
        {data: 'jam_laksana', name: 'jam_laksana', className: "none"},
        {data: 'kat_kerja', name: 'kat_kerja', className: "none", orderable: false, searchable: false},
        {data: 'kat_kerja_ket', name: 'kat_kerja_ket', className: "none"},
        {data: 'alat_pakai', name: 'alat_pakai', className: "none"},
        {data: 'jns_pekerjaan', name: 'jns_pekerjaan', className: "none", orderable: false, searchable: false},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'submit_tgl', name: 'submit_tgl', className: "none"},
        {data: 'tgl_expired', name: 'tgl_expired', className: "none"},
        {data: 'tgl_close', name: 'tgl_close', className: "none"},
        {data: 'pic_close', name: 'pic_close', className: "none"},
        {data: 'scan_sec_in_npk', name: 'scan_sec_in_npk', className: "none", orderable: false, searchable: false},
        {data: 'scan_sec_out_npk', name: 'scan_sec_out_npk', className: "none", orderable: false, searchable: false},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $(function() {
      $('\
        <div id="filter_site" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Site\
          <select size="1" name="filter_site" aria-controls="filter_status" \
            class="form-control select2" style="width: 80px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="IGPJ">IGPJ</option>\
              <option value="IGPK">IGPK</option>\
            </select>\
          </label>\
        </div>\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 180px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="DRAFT">DRAFT</option>\
              <option value="SUBMIT">SUBMIT</option>\
              <option value="APPROVE">APPROVE</option>\
              <option value="REJECT">REJECT</option>\
              <option value="PRC">APPROVE PURCHASING</option>\
              <option value="RPRC">REJECT PURCHASING</option>\
              <option value="USER">APPROVE PROJECT OWNER</option>\
              <option value="RUSER">REJECT PROJECT OWNER</option>\
              <option value="EHS">APPROVE EHS</option>\
              <option value="REHS">REJECT EHS</option>\
              <option value="SCAN_IN">SCAN IN SECURITY</option>\
              <option value="SCAN_OUT">SCAN OUT SECURITY</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.site = $('select[name="filter_site"]').val();
        data.status = $('select[name="filter_status"]').val();
      });

      $('select[name="filter_site"]').change(function() {
        tableMaster.ajax.reload();
      });

      $('select[name="filter_status"]').change(function() {
        tableMaster.ajax.reload();
      });
    });
  });
</script>
@endsection
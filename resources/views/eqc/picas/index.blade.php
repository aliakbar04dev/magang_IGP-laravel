@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA
        <small>Daftar PICA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-exchange"></i> PICA</li>
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
                      <th style="width: 3%;">No.</th>
                      <th style="width: 15%;">No. PICA</th>
                      <th style="width: 5%;">No. Revisi</th>
                      <th style="width: 8%;">Tanggal</th>
                      <th style="width: 10%;">No. QPR</th>
                      <th style="width: 5%;">Status</th>
                      <th>Submitted</th>
                      <th>Approved</th>
                      <th>Rejected</th>
                      <th>Ket. Reject</th>
                      <th>Closed</th>
                      <th>Effectived</th>
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

  function revisiPica(no_pica)
  {
    var msg = 'Anda yakin membuat Revisi data ini?';
    var txt = 'No. PICA: ' + no_pica;
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
      var urlRedirect = "{{ route('picas.revisi', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_pica));
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

  $(document).ready(function() {
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
      "order": [3, 'desc'],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.picas') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'no_pica', name: 'no_pica'},
        {data: 'no_revisi', name: 'no_revisi', className: "dt-center"},
        {data: 'tgl_pica', name: 'tgl_pica', className: "dt-center"},
        {data: 'issue_no', name: 'issue_no'},
        {data: 'status', name: 'status', className: "dt-center"},
        {data: 'portal_submit', name: 'portal_submit', className: "none"},
        {data: 'portal_approve', name: 'portal_approve', className: "none"},
        {data: 'portal_reject', name: 'portal_reject', className: "none"},
        {data: 'reject_ket', name: 'reject_ket', className: "none"},
        {data: 'portal_close', name: 'portal_close', className: "none"},
        {data: 'portal_efektif', name: 'portal_efektif', className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Status\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 100px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="D">DRAFT</option>\
              <option value="FS">SUBMIT</option>\
              <option value="RS">RE-SUBMIT</option>\
              <option value="A">APPROVE</option>\
              <option value="R">REJECT</option>\
              <option value="C">CLOSE</option>\
              <option value="E">EFEKTIF</option>\
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
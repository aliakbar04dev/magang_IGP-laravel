@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Komite Investasi
        <small>Daftar Komite Investasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-files-o"></i> Komite Investasi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              @permission('budget-komite-create')
				       <p> <a class="btn btn-primary" href="{{ route('bgttkomite1s.create') }}"><span class="fa fa-plus"></span> Add Komite Investasi</a></p>
			        @endpermission
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 15%;">No. Komite</th>
                    <th style="width: 1%;">Rev</th>
                    <th style="width: 8%;">Tgl Pengajuan</th>
                    <th>Jenis Komite</th>
                    <th>No. IA/EA</th>
                    <th style="width: 15%;">Presenter</th>
                    <th>Topik</th>
                    <th style="width: 12%;">Status</th>
                    <th>Catatan</th>
                    <th>Departemen</th>
                    <th>Support User</th>
                    <th>Tgl Komite Aktual</th>
                    <th>PIC Komite Aktual</th>
                    <th>Lokasi Komite Aktual</th>
                    <th>Dihadiri</th>
                    <th>Presenter Aktual</th>
                    <th>Hasil Komite</th>
                    <th>Creaby</th>
                    <th>Modiby</th>
                    <th style="width: 1%;">Action</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->

            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><p id="info-detail">Item to be Follow Up</p></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th style="width: 5%;">Seq</th>
                            <th>Keterangan</th>
                            <th style="width: 25%;">Approval 1</th>
                            <th style="width: 25%;">Approval 2</th>
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

  @include('budget.komite.popup.monitoringModal')
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
      "order": [[3, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.bgttkomite1s') }}",
      columns: [
      	{data: null, name: null},
        {data: 'no_komite', name: 'no_komite', className: "dt-center"},
        {data: 'no_rev', name: 'no_rev', className: "dt-center"},
        {data: 'tgl_pengajuan', name: 'tgl_pengajuan', className: "dt-center"},
        {data: 'jns_komite', name: 'jns_komite', className: "none"},
        {data: 'no_ie_ea', name: 'no_ie_ea', className: "none"},
        {data: 'npk_presenter', name: 'npk_presenter'},
        {data: 'topik', name: 'topik'},
        {data: 'status', name: 'status'},
        {data: 'catatan', name: 'catatan', className: "none"},
        {data: 'kd_dept', name: 'kd_dept', className: "none", orderable: false, searchable: false},
        {data: 'support_user', name: 'support_user', className: "none", orderable: false, searchable: false},
        {data: 'tgl_komite_act', name: 'tgl_komite_act', className: "none"},
        {data: 'pic_komite_act', name: 'pic_komite_act', className: "none"},
        {data: 'lok_komite_act', name: 'lok_komite_act', className: "none"},
        {data: 'support_user_act', name: 'support_user_act', className: "none", orderable: false, searchable: false},
        {data: 'npk_presenter_act', name: 'npk_presenter_act', className: "none"},
        {data: 'hasil_komite', name: 'hasil_komite', className: "none"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
	  ]
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Item to be Follow Up';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_komite = tableMaster.cell(index, 1).data();
          document.getElementById("info-detail").innerHTML = 'Item to be Follow Up (' + no_komite + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_komite.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('bgttkomite1s.detail', 'param') }}';
    url = url.replace('param', window.btoa("-"));
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: 'no_seq', name: 'no_seq', className: "dt-center"},
        { data: 'ket_item', name: 'ket_item'},
        { data: 'pic_apr1', name: 'pic_apr1'},
        { data: 'pic_apr2', name: 'pic_apr2'}
      ],
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('bgttkomite1s.detail', 'param') }}';
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    $(function() {
  	  $('\
  	    <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
  	      <label>Status \
  	      <select size="1" name="filter_status" aria-controls="filter_status" \
  	        class="form-control select2" style="width: 150px;">\
  	          <option value="ALL" selected="selected">ALL</option>\
              <option value="1">DRAFT</option>\
              <option value="2">SUBMIT</option>\
  	          <option value="3">BELUM KOMITE</option>\
  	          <option value="4">SUDAH KOMITE</option>\
              <option value="5">APPROVE</option>\
              <option value="6">REVISI</option>\
              <option value="7">CANCEL</option>\
  	        </select>\
  	      </label>\
  	    </div>\
  	  ').insertAfter('.dataTables_length');

  	  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
  	    data.status = $('select[name="filter_status"]').val();
  	  });

  	  $('select[name="filter_status"]').change(function() {
  	    document.getElementById("info-detail").innerHTML = 'Item to be Follow Up';
        tableMaster.ajax.reload( function ( json ) {
          if(tableMaster.rows().count() > 0) {
            $('#tblMaster tbody tr:eq(0)').click(); 
          } else {
            initTable(window.btoa('-'));
          }
        });
  	  });
	  });
  });

  function popupMonitoring(jns_komite, no_ie_ea) {
    var myHeading;
    var url;
    if(jns_komite === "OPS") {
      myHeading = "<p>Monitoring OH (" + no_ie_ea + ")</p>";
      url = '{{ route('datatables.popupMonitoringOH', 'param') }}';
    } else {
      myHeading = "<p>Monitoring IA/EA (" + no_ie_ea + ")</p>";
      url = '{{ route('datatables.popupMonitoringIA', 'param') }}';
    }
    $("#monitoringModalLabel").html(myHeading);
    url = url.replace('param', window.btoa(no_ie_ea));
    var lookupMonitoring = $('#lookupMonitoring').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      paging: false, 
      searching: false, 
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
          { data: 'no_urut', name: 'no_urut', className: 'dt-right'},
          { data: 'progress', name: 'progress'}, 
          { data: 'npk_approve', name: 'npk_approve'}, 
          { data: 'tgl_approve', name: 'tgl_approve'}, 
          { data: 'remark', name: 'remark'}, 
          { data: 'std_hari', name: 'std_hari', className: 'dt-right'}, 
          { data: 'act_hari', name: 'act_hari', className: 'dt-right'}
      ],
      "bDestroy": true,
    });
  }
</script>
@endsection
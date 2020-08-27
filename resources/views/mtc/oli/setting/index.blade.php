@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting Jenis Oli/Mesin
        <small>Setting Jenis Oli/Mesin</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i> Setting Jenis Oli/Mesin</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['mtc-setting-oli-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('mtctmoilings.create') }}">
                    <span class="fa fa-plus"></span> Add Setting Jenis Oli/Mesin
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
                    <th style="width: 20%;">Mesin</th>
                    <th>Nama Mesin</th>
                    <th style="width: 10%;">Action</th>
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
                        <h3 class="box-title"><p id="info-detail">Detail</p></h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 1%;">No</th>
                              <th style="width: 20%;">Part No</th>
                              <th>Deskripsi</th>
                              <th style="width: 20%;">Nama Alias</th>
                              <th style="width: 10%;">Jenis</th>
                              <th style="width: 10%;">Status</th>
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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.mtctmoilings') }}",
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'kd_mesin', name: 'kd_mesin'},
        {data: 'nm_mesin', name: 'nm_mesin'},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
	    ]
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail Mesin';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var kd_mesin = tableMaster.cell(index, 1).data();
          document.getElementById("info-detail").innerHTML = 'Detail Mesin (' + kd_mesin + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(kd_mesin.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('mtctmoilings.detail', 'param') }}';
    url = url.replace('param', window.btoa("-"));
    var tableDetail = $('#tblDetail').DataTable({
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
        { data: null, name: null, className: "dt-center"},
        { data: 'kd_brg', name: 'kd_brg'},
        { data: 'nm_brg', name: 'nm_brg'},
        { data: 'nm_alias', name: 'nm_alias'},
        { data: 'jns_oli', name: 'jns_oli'},
        { data: 'st_aktif', name: 'st_aktif'}
      ],
    });

    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        tableDetail.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('mtctmoilings.detail', 'param') }}';
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }
  });
</script>
@endsection
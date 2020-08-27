@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PC - Exchange Rate
        <small>Price Confirmation - Exchange Rate</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i> PC - Exchange Rate</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['sales-exchangerate-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('tcsls004ms.create') }}">
                    <span class="fa fa-plus"></span> Add Exchange Rate
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
                    <th style="width: 5%;">Tahun</th>
                    <th>Customer</th>
                    <th style="width: 30%;">Periode</th>
                    <th style="width: 10%;">Action</th>
                  </tr>
                </thead>
    			      </table>
	            </div>
	            <!-- /.box-body -->

              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title"><p id="info-detail">Exchange Rate</p></h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 1%;">No</th>
                              <th style="width: 20%;">Currency</th>
                              <th>Amount</th>
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
                  <div class="col-md-6">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title"><p id="info-detail2">Exchange Rate Slide</p></h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <table id="tblDetail2" class="table table-bordered table-striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 1%;">No</th>
                              <th style="width: 20%;">No. Seq</th>
                              <th style="width: 20%;">Currency</th>
                              <th>Amount</th>
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
      "order": [[1, 'desc'],[2, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.tcsls004ms') }}",
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'thn_period', name: 'thn_period', className: "dt-center"},
        {data: 'kd_cust', name: 'kd_cust'},
        {data: 'kd_period', name: 'kd_period'},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
	    ]
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Exchange Rate';
        document.getElementById("info-detail2").innerHTML = 'Exchange Rate Slide';
        initTable(window.btoa('-'), window.btoa('-'), window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var tahun = tableMaster.cell(index, 1).data();
          var kd_cust = tableMaster.cell(index, 2).data();
          var kd_period = tableMaster.cell(index, 3).data();
          var info = tahun + " # " + kd_cust + " # " + kd_period;
          document.getElementById("info-detail").innerHTML = 'Exchange Rate (' + info + ')';
          document.getElementById("info-detail2").innerHTML = 'Exc. Rate Slide (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(tahun.replace(regex, "")), window.btoa(kd_cust.replace(regex, "")), window.btoa(kd_period.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('tcsls004ms.detail', ['param', 'param2', 'param3']) }}';
    url = url.replace('param3', window.btoa("-"));
    url = url.replace('param2', window.btoa("-"));
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
        { data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        { data: 'nil_kurs', name: 'nil_kurs', className: "dt-right"}, 
        { data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
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

    var url2 = '{{ route('tcsls004ms.detail2', ['param', 'param2', 'param3']) }}';
    url2 = url2.replace('param3', window.btoa("-"));
    url2 = url2.replace('param2', window.btoa("-"));
    url2 = url2.replace('param', window.btoa("-"));
    var tableDetail2 = $('#tblDetail2').DataTable({
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
      ajax: url2,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'seq_curr', name: 'seq_curr', className: "dt-center"},
        { data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        { data: 'nil_kurs', name: 'nil_kurs', className: "dt-right"}, 
        { data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
      ],
    });

    $('#tblDetail2 tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        tableDetail2.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });

    function initTable(tahun, kd_cust, kd_period) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('tcsls004ms.detail', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', kd_period);
      url = url.replace('param2', kd_cust);
      url = url.replace('param', tahun);
      tableDetail.ajax.url(url).load();

      tableDetail2.search('').columns().search('').draw();
      var url2 = '{{ route('tcsls004ms.detail2', ['param', 'param2', 'param3']) }}';
      url2 = url2.replace('param3', kd_period);
      url2 = url2.replace('param2', kd_cust);
      url2 = url2.replace('param', tahun);
      tableDetail2.ajax.url(url2).load();
    }
  });
</script>
@endsection